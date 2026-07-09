<?php
/**
 * Production brand migration v2 — direct DB, no HTTP requests.
 * Faster, no server load.
 *
 * Usage:
 *   cd ~/public_html/.website_a4a78f90
 *   wp eval-file wp-content/themes/smokedrop-noir/migrate-production.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    echo "ERROR: Run via wp eval-file.\n";
    return;
}

echo "=== Brand Migration v2 (direct DB) ===\n";
echo "Started: " . date( 'Y-m-d H:i:s' ) . "\n\n";

// --- Get brand blog posts directly from the DB (category 18 = Brands) ---
$brand_posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'category'       => 18,
    'fields'         => 'ids',
) );
echo "Found " . count( $brand_posts ) . " brand blog posts (category 18)\n\n";

// --- Helper: normalize brand name ---
function norm( $s ) {
    $s = strtolower( trim( $s ) );
    $s = preg_replace( '/\b(brand|brands|the|inc|llc|co)\b/i', '', $s );
    $s = preg_replace( '/[^a-z0-9]/', '', $s );
    return $s;
}

// --- Helper: extract image URLs from HTML ---
function extract_imgs( $html ) {
    preg_match_all( '/src="(https?:\/\/[^"]+wp-content\/uploads\/[^"]+)"/', $html, $m );
    if ( empty( $m[1] ) ) return array();
    $skip = array( 'shopifiy.png','shopify.png','shopify-dropshipping.png','shopify-app-store.png',
        'woo-commerce.jpg','woocommerce-logo.svg','big-commerce-1.jpg','bigcommerce-logo.svg',
        'orders.png','darth-vapor-logo-600.png','session.jpg','download-1.png','download.png','sd-white-logo.png' );
    $out = array();
    foreach ( $m[1] as $url ) {
        $base = strtolower( basename( parse_url( $url, PHP_URL_PATH ) ) );
        if ( in_array( $base, $skip ) ) continue;
        if ( strpos( $base, '-300x162' ) !== false ) continue;
        $out[] = $url;
    }
    return $out;
}

// --- Process in batches ---
$updated  = 0;
$skipped  = 0;
$no_match = 0;
$count    = 0;

// Build a lookup of all brand CPT posts once.
$cpt_brands = get_posts( array(
    'post_type'      => 'brand',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
) );
$cpt_map = array();
foreach ( $cpt_brands as $cb ) {
    $cpt_map[ norm( $cb->post_title ) ] = $cb;
    $cpt_map[ $cb->post_name ] = $cb; // also by slug
}
echo "Loaded " . count( $cpt_map ) . " brand CPT posts for matching\n\n";

foreach ( $brand_posts as $bp_id ) {
    $count++;
    $bp = get_post( $bp_id );
    $bp_title = $bp->post_title;
    $bp_slug  = $bp->post_name;

    echo "[$count/" . count( $brand_posts ) . "] $bp_title... ";

    // Find matching CPT post.
    $match = null;
    if ( isset( $cpt_map[ $bp_slug ] ) ) {
        $match = $cpt_map[ $bp_slug ];
    } elseif ( isset( $cpt_map[ norm( $bp_title ) ] ) ) {
        $match = $cpt_map[ norm( $bp_title ) ];
    }

    if ( ! $match ) {
        echo "NO CPT MATCH\n";
        $no_match++;
        continue;
    }

    // 1) Logo from featured image.
    $logo_url = '';
    $thumb_id = get_post_thumbnail_id( $bp_id );
    if ( $thumb_id ) {
        $logo_url = wp_get_attachment_url( $thumb_id );
    }

    // 2) Extract photos from content.
    $photos = extract_imgs( $bp->post_content );
    $hero   = ! empty( $photos ) ? $photos[0] : '';
    $gallery = array_slice( $photos, 1, 3 );

    // 3) Description.
    $desc = wp_strip_all_tags( $bp->post_content, '<h2><h3><h4><p><strong><b><em><i><ul><ol><li><br><blockquote>' );
    $desc = preg_replace( '/\[.*?\]/s', '', $desc );
    $desc = trim( $desc );

    // 4) Write meta (only if empty).
    $changed = false;
    if ( $logo_url && ! get_post_meta( $match->ID, 'brand_logo', true ) ) {
        update_post_meta( $match->ID, 'brand_logo', $logo_url );
        $changed = true;
    }
    if ( $hero && ! get_post_meta( $match->ID, 'brand_hero_image', true ) ) {
        update_post_meta( $match->ID, 'brand_hero_image', $hero );
        $changed = true;
    }
    if ( ! empty( $gallery ) && ! get_post_meta( $match->ID, 'brand_gallery', true ) ) {
        update_post_meta( $match->ID, 'brand_gallery', implode( ',', $gallery ) );
        $changed = true;
    }

    // Description — only if current is boilerplate.
    $cur = $match->post_content;
    $is_bp = stripos( $cur, 'products are available for dropship and wholesale' ) !== false
          || stripos( $cur, 'Cookies branded' ) !== false;
    if ( $desc && strlen( $desc ) > 100 && $is_bp ) {
        wp_update_post( array( 'ID' => $match->ID, 'post_content' => $desc ) );
        $changed = true;
    }

    if ( $changed ) {
        echo "OK (logo:" . ( $logo_url ? 'Y' : '-' ) . " hero:" . ( $hero ? 'Y' : '-' ) . " gal:" . count( $gallery ) . " desc:" . ( strlen( $desc ) > 100 ? 'Y' : '-' ) . ")\n";
        $updated++;
    } else {
        echo "skip\n";
        $skipped++;
    }

    // Don't let it run too long without output.
    if ( $count % 20 == 0 ) echo "--- $count done ---\n";
}

echo "\n=== Done: " . date( 'Y-m-d H:i:s' ) . " ===\n";
echo "Total: $count | Updated: $updated | Skipped: $skipped | No match: $no_match\n";
echo "Setting sdn_brands_migrated = 6\n";
update_option( 'sdn_brands_migrated', '6' );
echo "Migration complete.\n";
