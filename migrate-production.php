<?php
/**
 * Production brand migration script — run via WP-CLI.
 *
 * Usage (from the WordPress root, NOT the theme folder):
 *   wp eval-file wp-content/themes/smokedrop-noir/migrate-production.php
 *
 * Or from cPanel Terminal:
 *   cd ~/public_html/.website_a4a78f90
 *   wp eval-file wp-content/themes/smokedrop-noir/migrate-production.php
 *
 * This script pulls real brand descriptions, logos, hero images, and gallery
 * images from the production blog posts (category 'brands') and writes them
 * into the brand CPT posts. It runs from the command line so it won't block
 * web requests or max out PHP processes.
 *
 * Safe to re-run (idempotent). Reports progress as it goes.
 */

if ( ! defined( 'ABSPATH' ) ) {
    echo "ERROR: This script must be run via 'wp eval-file' (WordPress must be loaded).\n";
    return;
}

echo "=== SmokeDrop Brand Migration (CLI) ===\n";
echo "Started: " . date( 'Y-m-d H:i:s' ) . "\n\n";

// --- Config ---
$api_base = 'https://thesmokedrop.com/wp-json/wp/v2';
$timeout  = 30;

// --- Helper: fetch JSON from an API URL ---
function cli_migrate_get( $url, $timeout = 30 ) {
    $response = wp_remote_get( $url, array(
        'timeout' => $timeout,
        'headers' => array( 'Accept' => 'application/json' ),
    ) );
    if ( is_wp_error( $response ) ) return array();
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );
    return is_array( $data ) ? $data : array();
}

// --- Step 1: Find the brands category ---
$cats = cli_migrate_get( "$api_base/categories?slug=brands&_fields=id,count" );
if ( empty( $cats ) || ! isset( $cats[0]['id'] ) ) {
    echo "ERROR: Could not find the 'brands' category.\n";
    return;
}
$cat_id   = $cats[0]['id'];
$cat_count = $cats[0]['count'];
echo "Found brands category: ID $cat_id ($cat_count posts)\n\n";

// --- Step 2: Fetch ALL brand posts (paginated) ---
$all_posts = array();
$page = 1;
while ( true ) {
    $batch = cli_migrate_get( "$api_base/posts?categories=$cat_id&per_page=100&page=$page&_fields=id,slug,title,featured_media,content" );
    if ( empty( $batch ) ) break;
    $all_posts = array_merge( $all_posts, $batch );
    echo "  Fetched page $page (" . count( $batch ) . " posts)\n";
    if ( count( $batch ) < 100 ) break;
    $page++;
    sleep( 1 ); // be gentle on the API
}
echo "\nTotal brand posts fetched: " . count( $all_posts ) . "\n\n";

// --- Step 3: Normalize a brand name for fuzzy matching ---
function cli_normalize_name( $name ) {
    $name = strtolower( trim( $name ) );
    $name = preg_replace( '/\b(brand|brands|the|inc|llc|co)\b/i', '', $name );
    $name = preg_replace( '/[^a-z0-9]/', '', $name );
    return $name;
}

// --- Step 4: Find a matching brand CPT post by slug or fuzzy title ---
function cli_find_brand_post( $post ) {
    $title = isset( $post['title']['rendered'] ) ? $post['title']['rendered'] : '';
    $slug  = isset( $post['slug'] ) ? $post['slug'] : '';

    // Try exact slug match first.
    $found = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( $found && $found->post_status === 'publish' ) return $found;

    // Try fuzzy title match.
    $norm_title = cli_normalize_name( $title );
    if ( ! $norm_title ) return null;

    $brands = get_posts( array(
        'post_type'      => 'brand',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ) );
    foreach ( $brands as $bid ) {
        $brand_name = get_the_title( $bid );
        if ( cli_normalize_name( $brand_name ) === $norm_title ) {
            return get_post( $bid );
        }
    }
    return null;
}

// --- Step 5: Extract photo URLs from content HTML ---
function cli_extract_photos( $html, $exclude_logo_url = '' ) {
    preg_match_all( '/src="(https:\/\/[^"]+wp-content\/uploads\/[^"]+)"/', $html, $matches );
    if ( empty( $matches[1] ) ) return array();

    $boilerplate = array(
        'shopifiy.png', 'shopify.png', 'shopify-dropshipping.png',
        'shopify-app-store.png', 'woo-commerce.jpg', 'woocommerce-logo.svg',
        'big-commerce-1.jpg', 'bigcommerce-logo.svg', 'orders.png',
        'darth-vapor-logo-600.png', 'session.jpg', 'download-1.png', 'download.png',
        'sd-white-logo.png',
    );
    $logo_base = $exclude_logo_url ? basename( parse_url( $exclude_logo_url, PHP_URL_PATH ) ) : '';

    $photos = array();
    foreach ( $matches[1] as $url ) {
        $base = basename( parse_url( $url, PHP_URL_PATH ) );
        if ( in_array( strtolower( $base ), $boilerplate ) ) continue;
        if ( strpos( $base, '-300x162' ) !== false ) continue;
        if ( $logo_base && $base === $logo_base ) continue;
        $photos[] = $url;
    }
    return $photos;
}

// --- Step 6: Process each brand ---
$updated = 0;
$skipped = 0;
$not_found = 0;

echo "Processing brands...\n\n";

foreach ( $all_posts as $i => $post ) {
    $title = isset( $post['title']['rendered'] ) ? $post['title']['rendered'] : '(unknown)';
    $slug  = isset( $post['slug'] ) ? $post['slug'] : '';

    echo "[" . ( $i + 1 ) . "/" . count( $all_posts ) . "] $title ($slug)... ";

    // Find the matching brand CPT post.
    $brand_post = cli_find_brand_post( $post );
    if ( ! $brand_post ) {
        echo "NOT FOUND (no CPT match)\n";
        $not_found++;
        continue;
    }

    // 1) Logo from featured_media.
    $logo_url = '';
    $fm_id = isset( $post['featured_media'] ) ? intval( $post['featured_media'] ) : 0;
    if ( $fm_id ) {
        $media = cli_migrate_get( "$api_base/media/$fm_id?_fields=source_url,alt_text", $timeout );
        if ( ! empty( $media['source_url'] ) ) {
            $logo_url = $media['source_url'];
        }
    }

    // 2) Extract hero + gallery from content.
    $content_html = isset( $post['content']['rendered'] ) ? $post['content']['rendered'] : '';
    $photos = cli_extract_photos( $content_html, $logo_url );

    $hero_url   = ! empty( $photos ) ? $photos[0] : '';
    $gallery_urls = array_slice( $photos, 1, 3 );
    $gallery_str = implode( ',', $gallery_urls );

    // 3) Extract description (strip boilerplate/shortcodes).
    $desc = wp_strip_all_tags( $content_html, '<h2><h3><h4><p><strong><b><em><i><ul><ol><li><br><blockquote>' );
    // Remove Elementor shortcode remnants.
    $desc = preg_replace( '/\[.*?\]/', '', $desc );
    $desc = trim( $desc );

    // 4) Write to the brand CPT post (only if not empty, don't overwrite existing good data).
    $changed = false;

    if ( $logo_url && ! get_post_meta( $brand_post->ID, 'brand_logo', true ) ) {
        update_post_meta( $brand_post->ID, 'brand_logo', $logo_url );
        $changed = true;
    }
    if ( $hero_url && ! get_post_meta( $brand_post->ID, 'brand_hero_image', true ) ) {
        update_post_meta( $brand_post->ID, 'brand_hero_image', $hero_url );
        $changed = true;
    }
    if ( $gallery_str && ! get_post_meta( $brand_post->ID, 'brand_gallery', true ) ) {
        update_post_meta( $brand_post->ID, 'brand_gallery', $gallery_str );
        $changed = true;
    }
    // Update description if current content is boilerplate.
    $current_content = $brand_post->post_content;
    $is_boilerplate = stripos( $current_content, 'products are available for dropship and wholesale on SmokeDrop' ) !== false
        || stripos( $current_content, 'Cookies branded' ) !== false;
    if ( $desc && strlen( $desc ) > 100 && $is_boilerplate ) {
        wp_update_post( array(
            'ID'           => $brand_post->ID,
            'post_content' => $desc,
        ) );
        $changed = true;
    }

    if ( $changed ) {
        echo "UPDATED (logo:" . ( $logo_url ? 'Y' : 'N' ) . " hero:" . ( $hero_url ? 'Y' : 'N' ) . " gallery:" . count( $gallery_urls ) . " desc:" . ( $desc && strlen( $desc ) > 100 ? 'Y' : 'N' ) . ")\n";
        $updated++;
    } else {
        echo "SKIP (already has data or nothing to migrate)\n";
        $skipped++;
    }

    // Small delay to be gentle on the server.
    if ( $fm_id ) usleep( 100000 ); // 0.1s
}

// --- Done ---
echo "\n=== Migration Complete ===\n";
echo "Finished: " . date( 'Y-m-d H:i:s' ) . "\n";
echo "Total posts: " . count( $all_posts ) . "\n";
echo "Updated: $updated\n";
echo "Skipped (already had data): $skipped\n";
echo "Not found (no CPT match): $not_found\n";
echo "\nMarking sdn_brands_migrated = '6'...\n";
update_option( 'sdn_brands_migrated', '6' );
echo "Done. Brand pages should now show real data.\n";
