<?php
/**
 * Migrate real brand content (logo, product photos, descriptive text) from
 * the production SmokeDrop site into the local brand CPT.
 *
 * Production has 173 brand posts in category 18, each built with Elementor.
 * This script fetches them via REST, extracts the REAL brand assets (filtering
 * out the boilerplate platform/testimonial images that appear in every post),
 * and writes them into the CPT meta that single-brand.php renders.
 *
 * Runs once on init (gated by the sdn_brands_migrated option). Idempotent and
 * batched — re-run by bumping the option value. Per-post errors are skipped so
 * one bad post can't break the whole run.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Boilerplate image basenames to exclude (appear in every post) ---------- */
function sdn_migrate_boilerplate_basenames() {
    return array(
        'shopifiy.png', 'shopify.png', 'shopify-dropshipping.png', 'shopify-app-store.png',
        'woo-commerce.jpg', 'woocommerce-logo.svg', 'big-commerce-1.jpg', 'bigcommerce-logo.svg',
        'orders.png', 'darth-vapor-logo-600.png', 'session.jpg',
        'download-1.png', 'download.png', 'sd-white-logo.png',
    );
}

/* ---------- HTTP GET helper (uses WP HTTP API, not raw curl) ---------- */
function sdn_migrate_get( $url, $timeout = 30 ) {
    $resp = wp_remote_get( $url, array(
        'timeout'    => $timeout,
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) SmokeDropMigrator/1.0',
        'headers'    => array( 'Accept' => 'application/json' ),
    ) );
    if ( is_wp_error( $resp ) ) return null;
    $body = wp_remote_retrieve_body( $resp );
    return json_decode( $body, true );
}

/* ---------- Extract clean description text from a post's rendered content ---------- */
function sdn_migrate_extract_desc( $html, $brand_name ) {
    // Strip scripts/styles/tags, collapse whitespace.
    $text = preg_replace( '/<script.*?<\/script>/s', '', $html );
    $text = preg_replace( '/<style.*?<\/style>/s', '', $text );
    $text = preg_replace( '/<[^>]+>/', ' ', $text );
    $text = html_entity_decode( $text, ENT_QUOTES );
    $text = preg_replace( '/\s+/', ' ', $text );

    // Start anchor: the real brand description begins after the marketing heading,
    // at "Looking for", "Welcome to SmokeDrop", or "If you"re looking".
    $start = 0;
    $anchors = array( 'Looking for', 'Welcome to SmokeDrop', 'If you' );
    foreach ( $anchors as $a ) {
        $pos = stripos( $text, $a );
        if ( $pos !== false && ( $start === 0 || $pos < $start ) ) $start = $pos;
    }
    if ( $start > 0 ) $text = substr( $text, $start );

    // End anchor: the boilerplate picks back up at these markers.
    $end_markers = array( 'Create a SmokeDrop Account', 'SHOPPING CART INTAGRATIONS', 'SHOPPING CART INTEGRATIONS', 'Fillout the form below', 'Get the App', 'START SELLING TODAY' );
    foreach ( $end_markers as $m ) {
        $pos = stripos( $text, $m );
        if ( $pos !== false ) { $text = substr( $text, 0, $pos ); break; }
    }

    $text = trim( $text );
    // Need a minimum of real content; otherwise the caller falls back to the generator.
    return ( strlen( $text ) > 200 ) ? $text : '';
}

/* ---------- Extract real product photo URLs (filtered) ---------- */
function sdn_migrate_extract_photos( $html, $logo_url ) {
    preg_match_all( '/src="(https:\/\/[^"]+wp-content\/uploads\/[^"]+)"/', $html, $m );
    $urls     = array_unique( $m[1] );
    $boiler   = sdn_migrate_boilerplate_basenames();
    $logo_base = $logo_url ? basename( $logo_url ) : '';

    $real = array();
    foreach ( $urls as $u ) {
        $base = strtolower( basename( $u ) );
        if ( in_array( $base, $boiler, true ) ) continue;
        // Drop the 300x162 logo thumbnail (e.g. PAX-300x162.png).
        if ( preg_match( '/-\d+x\d+\.(png|jpg|jpeg|webp)$/', $base ) && stripos( $base, '-300x162' ) !== false ) continue;
        // Drop if it's the same as the logo file.
        if ( $logo_base && $base === strtolower( $logo_base ) ) continue;
        $real[] = $u;
    }
    return $real;
}

/* ---------- Process one brand post from production ---------- */
function sdn_migrate_one_brand( $post, $cat_name ) {
    $slug     = $post['slug'];
    $name     = isset( $post['title']['rendered'] ) ? wp_strip_all_tags( $post['title']['rendered'] ) : ucfirst( $slug );
    $fm_id    = isset( $post['featured_media'] ) ? intval( $post['featured_media'] ) : 0;
    $content  = isset( $post['content']['rendered'] ) ? $post['content']['rendered'] : '';

    // 1) Logo URL from featured media (if any).
    $logo_url = '';
    if ( $fm_id ) {
        $media = sdn_migrate_get( "https://thesmokedrop.com/wp-json/wp/v2/media/{$fm_id}?_fields=source_url,alt_text", 20 );
        if ( ! empty( $media['source_url'] ) ) $logo_url = $media['source_url'];
    }

    // 2) Real product photos (filtered).
    $photos = sdn_migrate_extract_photos( $content, $logo_url );
    $hero   = ! empty( $photos ) ? array_shift( $photos ) : '';
    $gallery = array_slice( $photos, 0, 3 );

    // 3) Clean description.
    $desc = sdn_migrate_extract_desc( $content, $name );

    // 4) Find or create the CPT brand post.
    $existing = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( $existing ) {
        $post_id = $existing->ID;
    } else {
        $post_id = wp_insert_post( array(
            'post_type'    => 'brand',
            'post_status'  => 'publish',
            'post_title'   => $name,
            'post_name'    => $slug,
            'post_content' => $desc ? $desc : ( $name . ' products are available for dropship and wholesale on SmokeDrop.' ),
        ) );
        if ( ! $post_id || is_wp_error( $post_id ) ) return false;
    }

    // 5) Write meta (only when we have real data — never blank-out existing values).
    if ( $logo_url ) update_post_meta( $post_id, 'brand_logo', $logo_url );
    if ( $hero ) update_post_meta( $post_id, 'brand_hero_image', $hero );
    if ( ! empty( $gallery ) ) update_post_meta( $post_id, 'brand_gallery', implode( ',', $gallery ) );
    if ( $desc ) {
        // Update post_content with the clean description (only if it improves on the seed).
        wp_update_post( array( 'ID' => $post_id, 'post_content' => $desc ) );
    }

    return true;
}

/* ---------- Run the migration once (gated by an option) ---------- */
add_action( 'init', 'sdn_migrate_brands_run', 50 );
function sdn_migrate_brands_run() {
    if ( get_option( 'sdn_brands_migrated' ) === '1' ) return;
    if ( ! post_type_exists( 'brand' ) ) return;
    // Only run on the front end, never in the admin (to avoid blocking the dashboard).
    if ( is_admin() ) return;

    $cat = sdn_migrate_get( 'https://thesmokedrop.com/wp-json/wp/v2/categories?slug=brands&_fields=id,count', 20 );
    if ( empty( $cat ) || ! isset( $cat[0]['id'] ) ) {
        // Category not found — try again later, don't set the option.
        return;
    }
    $cat_id  = intval( $cat[0]['id'] );
    $total   = isset( $cat[0]['count'] ) ? intval( $cat[0]['count'] ) : 0;

    // Fetch all brand posts in batches of 100.
    $done = 0;
    $page = 1;
    while ( true ) {
        $url  = add_query_arg( array(
            'categories' => $cat_id,
            'per_page'   => 100,
            'page'       => $page,
            '_fields'    => 'id,slug,title,featured_media,content',
            'orderby'    => 'date',
            'order'      => 'asc',
        ), 'https://thesmokedrop.com/wp-json/wp/v2/posts' );
        $batch = sdn_migrate_get( $url, 45 );
        if ( empty( $batch ) || ! is_array( $batch ) ) break;

        foreach ( $batch as $post ) {
            // Skip on any error so one bad post doesn't break the run.
            try { sdn_migrate_one_brand( $post, '' ); } catch ( Exception $e ) { continue; }
            $done++;
        }

        if ( count( $batch ) < 100 ) break;          // last page
        if ( $total && $done >= $total ) break;       // safety cap
        $page++;
        if ( $page > 5 ) break;                       // hard cap (500 posts)
    }

    // Mark complete regardless of count (idempotent; re-run by bumping the option).
    update_option( 'sdn_brands_migrated', '1' );
}
