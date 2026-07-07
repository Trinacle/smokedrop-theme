<?php
/**
 * Register the Brands Custom Post Type
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', 'sdn_register_brand_cpt' );
function sdn_register_brand_cpt() {

    $labels = array(
        'name'                  => __( 'Brands', 'smokedrop-noir' ),
        'singular_name'         => __( 'Brand', 'smokedrop-noir' ),
        'menu_name'             => __( 'Brands', 'smokedrop-noir' ),
        'name_admin_bar'        => __( 'Brand', 'smokedrop-noir' ),
        'add_new'               => __( 'Add New Brand', 'smokedrop-noir' ),
        'add_new_item'          => __( 'Add New Brand', 'smokedrop-noir' ),
        'new_item'              => __( 'New Brand', 'smokedrop-noir' ),
        'edit_item'             => __( 'Edit Brand', 'smokedrop-noir' ),
        'view_item'             => __( 'View Brand', 'smokedrop-noir' ),
        'all_items'             => __( 'All Brands', 'smokedrop-noir' ),
        'search_items'          => __( 'Search Brands', 'smokedrop-noir' ),
        'parent_item_colon'     => __( 'Parent Brand:', 'smokedrop-noir' ),
        'not_found'             => __( 'No brands found.', 'smokedrop-noir' ),
        'not_found_in_trash'    => __( 'No brands found in Trash.', 'smokedrop-noir' ),
        'featured_image'        => __( 'Brand Hero Image', 'smokedrop-noir' ),
        'set_featured_image'    => __( 'Set brand hero image', 'smokedrop-noir' ),
        'remove_featured_image' => __( 'Remove brand hero image', 'smokedrop-noir' ),
        'use_featured_image'    => __( 'Use as brand hero image', 'smokedrop-noir' ),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true, // Gutenberg + REST API
        'menu_icon'           => 'dashicons-products',
        'menu_position'       => 5,
        'query_var'           => true,
        'rewrite'             => array(
            'slug'       => 'brand', // URLs: /brand/cookies/
            'with_front' => false,
        ),
        'has_archive'         => false, // /brands/ is the real static "Brands We Carry" Page (page-brands.php), not a CPT archive
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
        'taxonomies'          => array( 'product_brand' ), // Link to WooCommerce's brand taxonomy
    );

    register_post_type( 'brand', $args );
}

/* ---------- Connect brand CPT to WooCommerce product_brand taxonomy ---------- */
add_action( 'registered_taxonomy', 'sdn_bind_brand_cpt_to_product_brand', 10, 3 );
function sdn_bind_brand_cpt_to_product_brand( $taxonomy, $object_type, $args ) {
    if ( $taxonomy === 'product_brand' ) {
        register_taxonomy_for_object_type( 'product_brand', 'brand' );
    }
}

/* ---------- Virtual brand pages (work before the CPT is populated) ----------
 * Catches /brand/{slug}/ for brands that exist in sdn_brand_directory() but
 * don't yet have a CPT post, routing them to single-brand.php so the page
 * works immediately (e.g. the Vessel test). Real CPT posts take priority.
 */
add_action( 'init', 'sdn_register_virtual_brand_rewrite' );
function sdn_register_virtual_brand_rewrite() {
    add_rewrite_rule( '^brand/([a-z0-9-]+)/?$', 'index.php?sdn_brand_slug=$matches[1]', 'top' );
    add_rewrite_tag( '%sdn_brand_slug%', '([^&]+)' );
}

/* ---------- Resolve a virtual brand into the main query ---------- */
add_action( 'pre_get_posts', 'sdn_resolve_virtual_brand', 1 );
function sdn_resolve_virtual_brand( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    $slug = $query->get( 'sdn_brand_slug' );
    if ( ! $slug ) return;

    // If a real CPT brand post exists for this slug, defer to it (WP will
    // route via the single-brand template naturally).
    $existing = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( $existing ) return;

    // Otherwise treat this as a virtual brand: flag it so template_include
    // loads single-brand.php. We don't fake a post object — single-brand.php
    // reads the slug from get_query_var('sdn_brand_slug') directly.
    $query->set( 'sdn_virtual_brand', true );
    $query->is_single = false;
    $query->is_page = false;
    $query->is_archive = false;
    $query->is_home = false;
}

/* ---------- Load single-brand.php for virtual brand requests ---------- */
add_filter( 'template_include', 'sdn_virtual_brand_template', 20 );
function sdn_virtual_brand_template( $template ) {
    if ( get_query_var( 'sdn_virtual_brand' ) ) {
        $candidate = get_stylesheet_directory() . '/single-brand.php';
        if ( file_exists( $candidate ) ) return $candidate;
    }
    return $template;
}

/* ---------- Ensure rewrite rules are flushed on theme activation ---------- */
add_action( 'after_switch_theme', 'sdn_flush_brand_rewrites' );
function sdn_flush_brand_rewrites() {
    sdn_register_virtual_brand_rewrite();
    flush_rewrite_rules();
}

/* ---------- Seed the Brands CPT with the 16 real marketplace brands ----------
 * Runs once on init (guarded by the sdn_brands_seeded option), so the brands
 * appear in wp-admin → Brands without needing WP-CLI or manual entry. Idempotent:
 * skips any slug that already exists. Trigger again by deleting the option.
 */
add_action( 'init', 'sdn_seed_real_brands', 20 );
function sdn_seed_real_brands() {
    if ( get_option( 'sdn_brands_seeded' ) ) return;
    if ( ! post_type_exists( 'brand' ) ) return;

    foreach ( sdn_real_brand_logos() as $b ) {
        // Skip if a brand post already exists for this slug.
        if ( get_page_by_path( $b['slug'], OBJECT, 'brand' ) ) continue;

        $post_id = wp_insert_post( array(
            'post_type'    => 'brand',
            'post_status'  => 'publish',
            'post_title'   => $b['name'],
            'post_name'    => $b['slug'],
            'post_content' => $b['name'] . ' products are available for dropship and wholesale on SmokeDrop. Import to your store in a few clicks, with automatic inventory sync and blind dropshipping.',
        ) );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Attach the logo URL as the brand_logo post meta (used by
            // sdn_brand_logo_url() when rendering single-brand.php).
            $logo_url = home_url( '/wp-content/uploads/' . $b['file'] );
            update_post_meta( $post_id, 'brand_logo', $logo_url );
        }
    }

    update_option( 'sdn_brands_seeded', 1 );
}
