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

/* ---------- Virtual brand fallback (for brands not yet in the CPT) ----------
 * Now that the 16 real brands are seeded as CPT posts, WP's native permalink
 * rules handle /brand/{slug}/ and load single-brand.php automatically.
 * This rewrite is a LOW-priority fallback: it only catches brands that exist
 * in sdn_brand_directory() but have no CPT post, so newly-added brands work
 * immediately without a manual wp-admin entry.
 */
add_action( 'init', 'sdn_register_virtual_brand_rewrite' );
function sdn_register_virtual_brand_rewrite() {
    // 'bottom' priority = only used if WP's native CPT permalink doesn't match.
    add_rewrite_rule( '^brand/([a-z0-9-]+)/?$', 'index.php?sdn_brand_slug=$matches[1]', 'bottom' );
    add_rewrite_tag( '%sdn_brand_slug%', '([^&]+)' );
    add_rewrite_tag( '%sdn_virtual_brand%', '([01])' );
}

/* ---------- Resolve a virtual brand fallback into the main query ---------- */
add_action( 'pre_get_posts', 'sdn_resolve_virtual_brand', 1 );
function sdn_resolve_virtual_brand( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    $slug = $query->get( 'sdn_brand_slug' );
    if ( ! $slug ) return;

    // Safety: if a real CPT brand post exists for this slug, don't intercept —
    // WP's native single-brand.php template will handle it.
    $existing = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( $existing ) {
        $query->set( 'sdn_brand_slug', '' ); // clear so native handling proceeds
        return;
    }

    // Verify the slug is a known brand in the directory; otherwise let it 404.
    $known = false;
    foreach ( sdn_brand_directory() as $b ) {
        $bslug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
        if ( $bslug === $slug ) { $known = true; break; }
    }
    if ( ! $known ) return;

    $query->set( 'sdn_virtual_brand', 1 );
    $query->is_single = false;
    $query->is_page = false;
    $query->is_archive = false;
    $query->is_home = false;
}

/* ---------- Load single-brand.php for virtual brand fallbacks ---------- */
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

/* ---------- Seed the Brands CPT with the full marketplace directory ----------
 * Runs once on init (guarded by the sdn_brands_seeded option), creating all
 * ~380 brands from sdn_brand_directory() + sdn_new_brands() as editable CPT
 * posts. Idempotent: skips any slug that already exists. Bump the option value
 * to re-run (e.g. after the spreadsheet is updated).
 */
add_action( 'init', 'sdn_seed_real_brands', 20 );
function sdn_seed_real_brands() {
    if ( get_option( 'sdn_brands_seeded' ) === '2' ) return;
    if ( ! post_type_exists( 'brand' ) ) return;

    $all = array_merge( sdn_brand_directory(), sdn_new_brands() );
    $created = 0;
    foreach ( $all as $b ) {
        $slug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
        // Skip if a brand post already exists for this slug.
        if ( get_page_by_path( $slug, OBJECT, 'brand' ) ) continue;

        $post_id = wp_insert_post( array(
            'post_type'    => 'brand',
            'post_status'  => 'publish',
            'post_title'   => $b['name'],
            'post_name'    => $slug,
            'post_content' => $b['name'] . ' products are available for dropship and wholesale on SmokeDrop. Import to your store in a few clicks, with automatic inventory sync and blind dropshipping.',
        ) );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Logo URL (where known) for single-brand.php hero.
            if ( ! empty( $b['logo'] ) ) {
                update_post_meta( $post_id, 'brand_logo', home_url( '/wp-content/uploads/' . $b['logo'] ) );
            }
            // Store the ranking value for sorting/featured logic.
            if ( isset( $b['value'] ) ) {
                update_post_meta( $post_id, 'brand_value', intval( $b['value'] ) );
            }
            $created++;
        }
    }

    update_option( 'sdn_brands_seeded', '2' );

    // Flush rewrite rules so the newly-created brand CPT permalinks resolve.
    flush_rewrite_rules();
}

/* ---------- One-time flush after the virtual-brand rewrite was fixed ----------
 * The seed above only flushes on first run. This bumps a separate version flag
 * so the permalink rules get re-flushed whenever this code ships, ensuring the
 * /brand/{slug}/ CPT permalinks resolve without a manual flush in wp-admin.
 *
 * IMPORTANT: flush_rewrite_rules() has been unreliable under LiteSpeed's
 * object cache on this host (the option is written but a stale cached copy
 * persists, so /brand/{slug}/ keeps 404ing). The definitive fix is to DELETE
 * the rewrite_rules option entirely — WP then has no rules to read and is
 * forced to rebuild every rule (including the brand CPT's) on the next hit.
 * We also flush LiteSpeed cache + the object cache group as belt-and-suspenders.
 */
add_action( 'init', 'sdn_flush_brand_rewrites_once', 30 );
function sdn_flush_brand_rewrites_once() {
    if ( get_option( 'sdn_brand_rewrite_version' ) === '4' ) return;
    sdn_register_virtual_brand_rewrite();

    // Hard rebuild: delete the persisted rules so WP regenerates from scratch.
    delete_option( 'rewrite_rules' );

    // Belt-and-suspenders: also call the standard flush + clear object cache.
    flush_rewrite_rules( true );
    if ( function_exists( 'wp_cache_flush_group' ) ) {
        wp_cache_flush_group( 'options' );
    }
    // Clear any LiteSpeed page cache so the next request hits fresh rules.
    if ( function_exists( 'run_litespeed_esi' ) ) { /* no-op guard */ }
    do_action( 'litespeed_purge_all' );

    update_option( 'sdn_brand_rewrite_version', '4' );
}
