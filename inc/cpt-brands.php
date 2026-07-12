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

/* ---------- Brand slug aliases ----------
 * Some brands' canonical CPT slugs don't match the URLs visitors expect (or
 * that already exist on production and are indexed by Google). Most notably,
 * Storz & Bickel lives at /brand/storz-and-bickel/ here, but production has
 * always served /storz-bickel/. This map redirects/normalizes the incoming
 * slug to the canonical CPT slug.
 *
 * To add another: add `'requested-slug' => 'canonical-slug'`. That's it — the
 * request filter, single-brand.php, and the legacy redirect all read from here.
 */
function sdn_brand_slug_aliases() {
    return array(
        'storz-bickel'       => 'storz-and-bickel',
    );
}

/* Resolve any slug (incoming URL or otherwise) to its canonical CPT slug. */
function sdn_resolve_brand_slug( $slug ) {
    $slug = sanitize_title( $slug );
    $map  = sdn_brand_slug_aliases();
    return isset( $map[ $slug ] ) ? $map[ $slug ] : $slug;
}

/* ---------- Connect brand CPT to WooCommerce product_brand taxonomy ---------- */
add_action( 'registered_taxonomy', 'sdn_bind_brand_cpt_to_product_brand', 10, 3 );
function sdn_bind_brand_cpt_to_product_brand( $taxonomy, $object_type, $args ) {
    if ( $taxonomy === 'product_brand' ) {
        register_taxonomy_for_object_type( 'product_brand', 'brand' );
    }
}

/* ---------- Brand URL routing (/brand/{slug}/) ----------
 * We route ALL /brand/{slug}/ traffic through one explicit rewrite rule +
 * pre_get_posts handler, instead of relying on the brand CPT's native
 * permalink rules (which proved unreliable to flush on this LiteSpeed host).
 * single-brand.php then resolves the brand — from a real CPT post if one
 * exists, otherwise from the directory array. This works for all 380 brands
 * whether or not they have a CPT post, with a single rule.
 */
add_action( 'init', 'sdn_register_virtual_brand_rewrite' );
function sdn_register_virtual_brand_rewrite() {
    add_rewrite_rule( '^brand/([a-z0-9-]+)/?$', 'index.php?sdn_brand_slug=$matches[1]', 'top' );
    add_rewrite_tag( '%sdn_brand_slug%', '([^&]+)' );
    add_rewrite_tag( '%sdn_virtual_brand%', '([01])' );
}

/* ---------- Resolve a /brand/{slug}/ request into the main query ---------- */
add_action( 'pre_get_posts', 'sdn_resolve_virtual_brand', 1 );
function sdn_resolve_virtual_brand( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    $slug = $query->get( 'sdn_brand_slug' );
    if ( ! $slug ) return;

    // Flag so template_include loads single-brand.php for every brand URL.
    $query->set( 'sdn_virtual_brand', 1 );
    $query->is_404 = false;
    $query->is_single = false;
    $query->is_page = false;
    $query->is_archive = false;
    $query->is_home = false;
}

/* ---------- URL-path fallback: catch /brand/{slug}/ even without a flush ----------
 * The rewrite rule above requires a flush to take effect, which has been
 * unreliable on this host. This `request` filter inspects the raw URL path
 * BEFORE WP 404s, sets the query var, and forces single-brand.php — so brand
 * pages resolve immediately on deploy with no permalink flush needed.
 */
add_filter( 'request', 'sdn_brand_request_fallback' );
function sdn_brand_request_fallback( $qv ) {
    if ( is_admin() ) return $qv;
    $path = isset( $_SERVER['REQUEST_URI'] ) ? rawurldecode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
    // Strip query string + leading slash.
    $path = strtok( $path, '?' );
    $path = ltrim( $path, '/' );

    // Match brand/{slug} (with optional trailing slash), accounting for the
    // staging subpath (/staging/5411/...).
    $home_path = trim( wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
    if ( $home_path && strpos( $path, $home_path ) === 0 ) {
        $path = ltrim( substr( $path, strlen( $home_path ) ), '/' );
    }

    if ( preg_match( '#^brand/([a-z0-9-]+)/?$#i', $path, $m ) ) {
        // Normalize legacy/alternate slugs (e.g. storz-bickel -> storz-and-bickel)
        // so the canonical CPT post resolves instead of 404ing.
        $qv['sdn_brand_slug']    = sdn_resolve_brand_slug( $m[1] );
        $qv['sdn_virtual_brand'] = 1;
    }
    return $qv;
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

/* ---------- 301 redirect legacy /{brand-slug}/ URLs to /brand/{slug}/ ----------
 * The old site used bare slugs (e.g. /puffco/, /grav/) for brand blog posts.
 * The new site uses /brand/{slug}/. When a visitor (or Google) hits a legacy
 * URL that matches a known brand, 301 redirect to the canonical brand page so
 * the correct template renders and SEO link equity transfers.
 * Only fires for slugs that exist as a brand CPT post or in the directory —
 * never hijacks real pages (about, contact, pricing, etc.).
 */
add_action( 'template_redirect', 'sdn_redirect_legacy_brand_urls', 1 );
function sdn_redirect_legacy_brand_urls() {
    if ( is_admin() || is_front_page() ) return;

    // Only redirect single blog posts (the legacy brand pages).
    if ( ! is_singular( 'post' ) ) return;

    $slug = get_queried_object()->post_name ?? '';
    if ( ! $slug ) return;

    // Is this slug a known brand? Check the directory array.
    $is_brand = false;
    if ( function_exists( 'sdn_brand_directory' ) ) {
        foreach ( sdn_brand_directory() as $b ) {
            if ( ( $b['slug'] ?? '' ) === $slug ) { $is_brand = true; break; }
        }
    }
    // Also check for a brand CPT post with this slug.
    if ( ! $is_brand ) {
        $cpt = get_page_by_path( $slug, OBJECT, 'brand' );
        if ( $cpt && $cpt->post_status === 'publish' ) $is_brand = true;
    }
    if ( ! $is_brand ) return;

    // Resolve canonical slug (handles storz-bickel -> storz-and-bickel).
    $canonical = function_exists( 'sdn_resolve_brand_slug' ) ? sdn_resolve_brand_slug( $slug ) : $slug;

    wp_safe_redirect( home_url( '/brand/' . $canonical . '/' ), 301 );
    exit;
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
    if ( get_option( 'sdn_brand_rewrite_version' ) === '5' ) return;
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

    update_option( 'sdn_brand_rewrite_version', '5' );
}
