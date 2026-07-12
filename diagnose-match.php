<?php
/**
 * Diagnostic: show why blog posts don't match CPT brands.
 * Visit: /wp-content/themes/smokedrop-noir/diagnose-match.php?sdn_diag=1
 */

$wp_load = dirname( __FILE__ ) . '/../../../wp-load.php';
if ( ! file_exists( $wp_load ) ) die( 'Cannot find wp-load.php' );
require_once $wp_load;

if ( ! isset( $_GET['sdn_diag'] ) ) die( 'Add ?sdn_diag=1' );

header( 'Content-Type: text/plain' );

function _norm( $s ) {
    $s = strtolower( trim( $s ) );
    $s = preg_replace( '/\b(brand|brands|the|inc|llc|co)\b/i', '', $s );
    $s = preg_replace( '/[^a-z0-9]/', '', $s );
    return $s;
}

// Get all category 18 blog posts.
$brand_posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'category'       => 18,
) );

// Build CPT lookup.
$cpt_brands = get_posts( array(
    'post_type'      => 'brand',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
) );
$cpt_map = array();
$cpt_slugs = array();
foreach ( $cpt_brands as $cb ) {
    $cpt_map[ _norm( $cb->post_title ) ] = $cb;
    $cpt_map[ $cb->post_name ] = $cb;
    $cpt_slugs[ $cb->post_name ] = $cb->post_title;
}

echo "=== Blog posts that DON'T match (showing slug, title, _norm) ===\n\n";
$no_match = array();
foreach ( $brand_posts as $bp ) {
    $slug = $bp->post_name;
    $title = $bp->post_title;
    $match = null;
    if ( isset( $cpt_map[ $slug ] ) ) {
        $match = $cpt_map[ $slug ];
    } elseif ( isset( $cpt_map[ _norm( $title ) ] ) ) {
        $match = $cpt_map[ _norm( $title ) ];
    }
    if ( ! $match ) {
        $no_match[] = $bp;
        echo "BLOG: slug='{$slug}' title='{$title}'\n";
        echo "  _norm(title)='" . _norm( $title ) . "'  slug='{$slug}'\n";
        // Check if slug contains a known brand slug.
        foreach ( $cpt_slugs as $cs => $ct ) {
            if ( stripos( $slug, $cs ) !== false || stripos( $cs, $slug ) !== false ) {
                echo "  >> PARTIAL SLUG MATCH: cpt_slug='{$cs}' cpt_title='{$ct}'\n";
            }
        }
        // Check if title contains a known CPT title.
        foreach ( $cpt_slugs as $cs => $ct ) {
            if ( strlen( $ct ) >= 3 && stripos( $title, $ct ) !== false ) {
                echo "  >> TITLE CONTAINS CPT: cpt='{$ct}' slug='{$cs}'\n";
            }
        }
        echo "\n";
    }
}

echo "\n=== Summary: " . count( $no_match ) . " unmatched out of " . count( $brand_posts ) . " ===\n";
