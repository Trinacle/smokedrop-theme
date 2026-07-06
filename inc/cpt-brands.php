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
