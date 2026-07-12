<?php
/**
 * Web-accessible brand migration — visit this URL to run:
 *   https://thesmokedrop.com/?sdn_migrate=RUN
 *
 * Uses direct DB (no HTTP requests) so it's fast and won't crash the server.
 * FORCES overwrite of existing meta (fixes brands with wrong data).
 */

// Load WordPress.
$wp_load = dirname( __FILE__ ) . '/../../../wp-load.php';
if ( ! file_exists( $wp_load ) ) {
    die( 'Cannot find wp-load.php' );
}
require_once $wp_load;

// Security token.
if ( ! isset( $_GET['sdn_migrate'] ) || $_GET['sdn_migrate'] !== 'RUN' ) {
    die( 'Add ?sdn_migrate=RUN to the URL to run the migration.' );
}

@set_time_limit( 300 );
header( 'Content-Type: text/plain; charset=utf-8' );
echo "=== Brand Migration (web, direct DB, force overwrite) ===\n";
echo "Started: " . date( 'Y-m-d H:i:s' ) . "\n\n";
ob_flush(); flush();

// Get brand blog posts from category 18.
$brand_posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'category'       => 18,
    'fields'         => 'ids',
) );
echo "Found " . count( $brand_posts ) . " brand blog posts\n\n";
ob_flush(); flush();

function _norm( $s ) {
    $s = html_entity_decode( $s, ENT_QUOTES, 'UTF-8' ); // decode &amp; -> &
    $s = strtolower( trim( $s ) );
    $s = preg_replace( '/\b(brand|brands|the|inc|llc|co)\b/i', '', $s );
    $s = preg_replace( '/[^a-z0-9]/', '', $s );
    return $s;
}

function _extract_imgs( $html ) {
    $skip = array( 'shopifiy.png','shopify.png','shopify-dropshipping.png','shopify-app-store.png',
        'woo-commerce.jpg','woocommerce-logo.svg','big-commerce-1.jpg','bigcommerce-logo.svg',
        'orders.png','darth-vapor-logo-600.png','session.jpg','download-1.png','download.png','sd-white-logo.png',
        'hero-bg.png','logo.png','sd-white-logo.png' );
    $out = array();
    $seen = array();

    // 1) <img src="..."> tags.
    preg_match_all( '/src="(https?:\/\/[^"]+wp-content\/uploads\/[^"]+)"/', $html, $m );
    // 2) CSS background-image: url(...) in inline styles.
    preg_match_all( '/background(?:-image)?\s*:\s*url\(\s*["\']?(https?:\/\/[^"\')]+wp-content\/uploads\/[^"\')]+)["\']?\s*\)/', $html, $m2 );
    // 3) background="..." HTML attributes.
    preg_match_all( '/background="(https?:\/\/[^"]+wp-content\/uploads\/[^"]+)"/', $html, $m3 );

    $all_urls = array_merge( $m[1], $m2[1], $m3[1] );
    foreach ( $all_urls as $url ) {
        $base = strtolower( basename( parse_url( $url, PHP_URL_PATH ) ) );
        if ( in_array( $base, $skip ) ) continue;
        // Dedupe by basename (avoid same image in multiple crop sizes).
        if ( isset( $seen[ $base ] ) ) continue;
        $seen[ $base ] = true;
        $out[] = $url;
    }
    return $out;
}

// Build CPT lookup.
$cpt_brands = get_posts( array(
    'post_type'      => 'brand',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
) );
$cpt_map = array();
$cpt_by_slug = array();
foreach ( $cpt_brands as $cb ) {
    $norm_title                = _norm( $cb->post_title );
    $cpt_map[ $norm_title ]    = $cb;
    $cpt_map[ $cb->post_name ] = $cb;
    $cpt_by_slug[ $cb->post_name ] = $cb;
}
echo "Loaded " . count( $cpt_brands ) . " brand CPT posts\n\n";

// Known slug aliases: blog post slug -> CPT post slug (for brands where the
// blog slug doesn't match the CPT slug exactly).
$slug_aliases = array(
    'wyld-cbd'           => 'wyld',
    'elements'           => 'elements-rolling-papers',
    'zeus'               => 'zeus-arsenal',
    'zippo'              => 'zippo-lighters',
    'ocb'                => 'ocb-rolling-papers',
    'infyniti-scales'    => 'infyniti',
    'cloudious-9'        => 'cloudious',
    'high-voltage-detox' => 'high-voltage',
    'nwtn-home'          => 'nwtn',
    'shine-papers'       => 'shine',
    'evolv'              => 'evolved',
    'sweet-lyfe-2'       => 'sweet-lyfe',
    'nectar-collector'   => 'original-nectar-collector',
);

ob_flush(); flush();

$updated = 0; $skipped = 0; $no_match = 0; $created = 0; $count = 0;

foreach ( $brand_posts as $bp_id ) {
    $count++;
    $bp = get_post( $bp_id );
    $bp_title = $bp->post_title;
    $bp_slug  = $bp->post_name;

    echo "[$count/" . count( $brand_posts ) . "] $bp_title... ";
    ob_flush(); flush();

    // Find matching CPT post — try multiple strategies.
    $match = null;
    // 1) Exact slug match.
    if ( isset( $cpt_map[ $bp_slug ] ) ) {
        $match = $cpt_map[ $bp_slug ];
    }
    // 2) Normalized title match.
    if ( ! $match && isset( $cpt_map[ _norm( $bp_title ) ] ) ) {
        $match = $cpt_map[ _norm( $bp_title ) ];
    }
    // 3) Known slug alias.
    if ( ! $match && isset( $slug_aliases[ $bp_slug ] ) && isset( $cpt_by_slug[ $slug_aliases[ $bp_slug ] ] ) ) {
        $match = $cpt_by_slug[ $slug_aliases[ $bp_slug ] ];
    }
    // 4) Fuzzy: blog slug is a prefix of a CPT slug (puffco -> puffco-brand).
    if ( ! $match ) {
        foreach ( $cpt_by_slug as $cs => $cb ) {
            if ( $cs === $bp_slug ) { $match = $cb; break; }
            if ( strpos( $cs, $bp_slug ) === 0 && strlen( $bp_slug ) >= 3 ) {
                $match = $cb; // prefix match — best candidate
                break;
            }
        }
    }
    // 5) Fuzzy: blog title contains a CPT title (or vice versa).
    if ( ! $match ) {
        $blog_norm = _norm( $bp_title );
        foreach ( $cpt_brands as $cb ) {
            $cpt_norm = _norm( $cb->post_title );
            if ( strlen( $cpt_norm ) >= 3 && ( strpos( $blog_norm, $cpt_norm ) !== false || strpos( $cpt_norm, $blog_norm ) !== false ) ) {
                $match = $cb;
                break;
            }
        }
    }

    // 6) Auto-create CPT post if no match — the blog post proves this brand
    //    should have a page. Create one with the blog slug + title.
    if ( ! $match ) {
        $new_id = wp_insert_post( array(
            'post_type'   => 'brand',
            'post_status' => 'publish',
            'post_title'  => $bp_title,
            'post_name'   => $bp_slug,
        ), true );
        if ( ! is_wp_error( $new_id ) ) {
            $match = get_post( $new_id );
            $cpt_map[ $bp_slug ]         = $match;
            $cpt_map[ _norm( $bp_title ) ] = $match;
            $cpt_by_slug[ $bp_slug ]     = $match;
            $cpt_brands[]                = $match;
            echo "CREATED CPT (id=$new_id) ";
            $created++;
        }
    }

    if ( ! $match ) {
        echo "NO CPT MATCH (create failed)\n";
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
    $photos = _extract_imgs( $bp->post_content );
    $hero   = ! empty( $photos ) ? $photos[0] : '';
    $gallery = array_slice( $photos, 1, 3 );

    // 3) Description — strip_tags() preserves the allowlist; wp_strip_all_tags()
    //    was a bug (it stripped ALL tags regardless of the 2nd arg and collapsed
    //    whitespace, producing one giant unformatted blob).
    $desc = strip_tags( $bp->post_content, '<h2><h3><h4><p><strong><b><em><i><ul><ol><li><br><blockquote>' );
    $desc = preg_replace( '/\[.*?\]/s', '', $desc );
    // Normalize whitespace inside tags but preserve block-level structure.
    $desc = preg_replace( '/\s+/', ' ', $desc );
    $desc = preg_replace( '/\s*(<\/?(?:h[2-4]|p|ul|ol|li|br|blockquote)[^>]*>)\s*/', "\n$1\n", $desc );
    $desc = trim( $desc );

    // 4) FORCE overwrite (don't skip existing data).
    $changed = false;

    if ( $logo_url ) {
        update_post_meta( $match->ID, 'brand_logo', $logo_url );
        $changed = true;
    }
    if ( $hero ) {
        update_post_meta( $match->ID, 'brand_hero_image', $hero );
        $changed = true;
    }
    if ( ! empty( $gallery ) ) {
        update_post_meta( $match->ID, 'brand_gallery', implode( ',', $gallery ) );
        $changed = true;
    }

    // Description — always update if we have better content.
    if ( $desc && strlen( $desc ) > 100 ) {
        wp_update_post( array( 'ID' => $match->ID, 'post_content' => $desc ) );
        $changed = true;
    }

    if ( $changed ) {
        echo "OK (logo:" . ( $logo_url ? 'Y' : '-' ) . " hero:" . ( $hero ? 'Y' : '-' ) . " gal:" . count( $gallery ) . " desc:" . ( strlen( $desc ) > 100 ? 'Y' : '-' ) . ")\n";
        $updated++;
    } else {
        echo "nothing to update\n";
        $skipped++;
    }

    if ( $count % 20 == 0 ) {
        echo "--- $count done ---\n";
        ob_flush(); flush();
    }
}

update_option( 'sdn_brands_migrated', '6' );

echo "\n=== Done: " . date( 'Y-m-d H:i:s' ) . " ===\n";
echo "Total: $count | Updated: $updated | Created: $created | Skipped: $skipped | No match: $no_match\n";
echo "Migration complete. Purge LiteSpeed cache to see changes.\n";
