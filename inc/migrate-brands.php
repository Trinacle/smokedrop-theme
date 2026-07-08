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

/* ---------- Extract clean description from a post's rendered content ---------- */
/* Preserves HTML formatting (h2, h3, p, strong, ul, li) so the brand copy
 * keeps its headings and bolds. Works by: (1) finding the start anchor in a
 * plain-text copy, (2) locating that position in the original HTML, (3)
 * slicing the HTML from there to the boilerplate end-marker, (4) keeping only
 * safe formatting tags and stripping the rest. */
function sdn_migrate_extract_desc( $html, $brand_name ) {
    $stripped = preg_replace( '/<script.*?<\/script>/s', '', $html );
    $stripped = preg_replace( '/<style.*?<\/style>/s', '', $stripped );
    $plain    = preg_replace( '/<[^>]+>/', ' ', $stripped );
    $plain    = html_entity_decode( $plain, ENT_QUOTES );
    $plain    = preg_replace( '/\s+/', ' ', $plain );

    // Find the start anchor (the brand-intro hook).
    $hooks = array( 'Looking for', 'Looking to add', 'Welcome to SmokeDrop', 'Meet ', 'If you' );
    $start_plain = false;
    foreach ( $hooks as $hook ) {
        $pos = stripos( $plain, $hook );
        if ( $pos !== false && ( $start_plain === false || $pos < $start_plain ) ) $start_plain = $pos;
    }
    // Fallback: longest segment with the brand name.
    if ( $start_plain === false ) {
        $name_norm = strtolower( preg_replace( '/[^a-z0-9]/', '', $brand_name ) );
        $best = 0;
        foreach ( preg_split( '/\.\s+/', $plain ) as $seg ) {
            if ( strlen( $seg ) < 60 ) continue;
            $sn = strtolower( preg_replace( '/[^a-z0-9]/', '', $seg ) );
            $score = strlen( $seg ) + ( $name_norm && strpos( $sn, $name_norm ) !== false ? 500 : 0 );
            if ( $score > $best ) { $best = $score; $start_plain = stripos( $plain, $seg ); }
        }
    }
    if ( $start_plain === false ) return '';

    // Find a corresponding position in the original HTML: search for the ~30-char
    // window of plain text (tags stripped) right before the anchor, then locate it.
    $before  = substr( $plain, max( 0, $start_plain - 80 ), 50 );
    $before  = trim( $before );
    $html_pos = $before ? stripos( $html, $before ) : false;
    if ( $html_pos === false ) {
        // Fallback: use a short unique snippet at the anchor itself.
        $snippet = trim( substr( $plain, $start_plain, 40 ) );
        $html_pos = $snippet ? stripos( $html, $snippet ) : false;
    }
    if ( $html_pos === false ) return '';

    $slice = substr( $html, $html_pos );

    // Find the end marker (boilerplate that follows the real description).
    $end_markers = array(
        'Create a SmokeDrop Account', 'SHOPPING CART INTAGRATIONS', 'SHOPPING CART INTEGRATIONS',
        'Fillout the form below', 'Get the App', 'START SELLING TODAY', 'WE LOVE YOUR FEEDBACK',
        'Request a Demo', 'Frequently Asked Questions',
    );
    foreach ( $end_markers as $m ) {
        $epos = stripos( $slice, $m );
        if ( $epos !== false ) { $slice = substr( $slice, 0, $epos ); break; }
    }

    // Keep only safe formatting tags; strip everything else (spans, divs, a, img).
    $allowed = '<h2><h3><h4><p><strong><b><em><i><ul><ol><li><br><blockquote>';
    $slice   = strip_tags( $slice, $allowed );
    // Remove empty paragraphs and trim.
    $slice   = preg_replace( '/<p>\s*<\/p>/i', '', $slice );
    $slice   = trim( $slice );

    return ( strlen( wp_strip_all_tags( $slice ) ) > 200 ) ? $slice : '';
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

/* ---------- Find a brand CPT post by title (fuzzy, for slug mismatches) ---------- */
/* Production slugs often differ from our directory slugs (e.g. "vesselbrand"
 * vs "vessel"). Match by normalized title so migrated content lands on the
 * right post regardless of slug. Normalizes "Vessel Brand" -> "vessel". */
function sdn_migrate_find_by_title( $name ) {
    $norm = sdn_migrate_normalize_name( $name );
    if ( ! $norm ) return null;

    // Direct title query (more reliable than loading all 380 posts into memory).
    $q = new WP_Query( array(
        'post_type'      => 'brand',
        'post_status'    => 'any',
        'posts_per_page' => 5,
        'no_found_rows'  => true,
        'fields'         => 'ids',
        'title'          => $name,
    ) );
    foreach ( $q->posts as $pid ) {
        if ( sdn_migrate_normalize_name( get_the_title( $pid ) ) === $norm ) {
            return get_post( $pid );
        }
    }

    // Fallback: scan brand posts whose normalized title matches.
    $all = get_posts( array(
        'post_type'      => 'brand',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'fields'         => 'ids',
    ) );
    foreach ( $all as $pid ) {
        if ( sdn_migrate_normalize_name( get_the_title( $pid ) ) === $norm ) {
            return get_post( $pid );
        }
    }
    return null;
}

/* ---------- Normalize a brand name for matching ---------- */
function sdn_migrate_normalize_name( $name ) {
    $n = strtolower( trim( $name ) );
    // Strip common suffixes/words and punctuation.
    $n = preg_replace( '/\b(brand|brands|the|inc|llc|co)\b/', '', $n );
    $n = preg_replace( '/[^a-z0-9]/', '', $n );
    return $n;
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
    //    First try the exact slug, then fall back to a title match (production
    //    slugs differ from our directory slugs — e.g. "vesselbrand" vs "vessel",
    //    "Vessel Brand" vs "Vessel").
    $existing = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( ! $existing ) {
        $existing = sdn_migrate_find_by_title( $name );
    }
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
add_action( 'init', 'sdn_migrate_brands_run', 60 );
function sdn_migrate_brands_run() {
    if ( get_option( 'sdn_brands_migrated' ) === '6' ) return;
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

    // Dedup: merge brand posts that share a normalized title (created by slug
    // mismatches like vesselbrand/vessel). Keeps the oldest as canonical, copies
    // its meta/content to the canonical if missing, trashes the duplicates.
    sdn_migrate_dedup_brands();

    // Mark complete regardless of count (idempotent; re-run by bumping the option).
    update_option( 'sdn_brands_migrated', '6' );
}

/* ---------- Dedup brand posts by normalized title ---------- */
function sdn_migrate_dedup_brands() {
    $all = get_posts( array(
        'post_type'      => 'brand',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'no_found_rows'  => true,
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'ASC',
    ) );
    $seen = array();
    foreach ( $all as $pid ) {
        $norm = sdn_migrate_normalize_name( get_the_title( $pid ) );
        if ( ! $norm ) continue;
        if ( isset( $seen[ $norm ] ) ) {
            $canonical = $seen[ $norm ];
            // Copy migrated meta to the canonical post if the canonical is missing it.
            foreach ( array( 'brand_logo', 'brand_hero_image', 'brand_gallery' ) as $key ) {
                if ( ! get_post_meta( $canonical, $key, true ) ) {
                    $val = get_post_meta( $pid, $key, true );
                    if ( $val ) update_post_meta( $canonical, $key, $val );
                }
            }
            // Copy real post_content if canonical has the generic seed.
            $canon_content = get_post_field( 'post_content', $canonical );
            $dup_content   = get_post_field( 'post_content', $pid );
            if ( strpos( $canon_content, 'products are available for dropship and wholesale' ) !== false && $dup_content && strlen( $dup_content ) > 200 ) {
                wp_update_post( array( 'ID' => $canonical, 'post_content' => $dup_content ) );
            }
            // Trash the duplicate.
            wp_trash_post( $pid );
        } else {
            $seen[ $norm ] = $pid;
        }
    }
}
