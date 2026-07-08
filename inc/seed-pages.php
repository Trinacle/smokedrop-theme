<?php
/**
 * Seed / repair the bespoke WordPress pages.
 *
 * Creates every page the theme needs (Help Center, Testimonials, For
 * Wholesalers, Integrations hub + 4 platform sub-pages, Marketplace, and the
 * other bespoke templates) with the correct slug + page-template assignment.
 *
 * Runs once on init (gated by the sdn_pages_seeded option). Bump the option
 * value to re-run after a content change. Idempotent: existing pages are
 * updated in place (slug + template corrected) rather than duplicated.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- The pages to seed: slug => [ title, template, parent_slug ] ----------
 * parent_slug of '' = top-level page. For integrations sub-pages, the parent
 * is the 'integrations' hub so the URL becomes /integrations/{slug}/.
 */
function sdn_seed_pages_list() {
    return array(
        // Top-level marketing / resource pages
        'pricing'        => array( 'Pricing',             'page-pricing.php' ),
        'retailers'      => array( 'For Retailers',       'page-retailers.php' ),
        'suppliers'      => array( 'For Suppliers',       'page-suppliers.php' ),
        'wholesalers'    => array( 'For Wholesalers',     'page-wholesalers.php' ),
        'platform'       => array( 'Platform Overview',   'page-platform.php' ),
        'industries'     => array( 'Industries',          'page-industries.php' ),
        'brands'         => array( 'Brands We Carry',     'page-brands.php' ),
        'contact'        => array( 'Contact',             'page-contact.php' ),
        'about'          => array( 'About',               'page-about.php' ),
        'demo'           => array( 'Get a Demo',          'page-demo.php' ),
        'call'           => array( 'Schedule a Call',     'page-call.php' ),
        'help'           => array( 'Help Center',         'page-help.php' ),
        'testimonials'   => array( 'Testimonials',        'page-testimonials.php' ),
        'sitemap'        => array( 'Sitemap',             'page-sitemap.php' ),
        'advertise'      => array( 'Advertise',           'page-advertise.php' ),
        'marketplace-search' => array( 'Marketplace Search', 'page-search.php' ),
        // Recommended partner tools (replaces legacy /recomend-tools-for-ecommerce/)
        'recommend-tools-for-ecommerce' => array( 'Recommended Tools', 'page-recommend-tools-for-ecommerce.php' ),
        // Legal / standard document pages share one reusable legal template.
        'terms-of-use-for-suppliers'    => array( 'Supplier Terms of Use', 'page-legal.php' ),
        'terms-of-use'                  => array( 'Terms of Use', 'page-legal.php' ),
        'privacy-policy'                => array( 'Privacy Policy', 'page-legal.php' ),
        'retailer-terms-of-use-agreement' => array( 'Retailer Terms of Use', 'page-legal.php' ),
        // Integrations hub
        'integrations'   => array( 'Integrations',        'page-integrations.php' ),
        // Integrations sub-pages (parent = integrations -> /integrations/{slug}/)
        'shopify'        => array( 'Shopify',             'page-integration-platform.php', 'integrations' ),
        'woocommerce'    => array( 'WooCommerce',         'page-integration-platform.php', 'integrations' ),
        'bigcommerce'    => array( 'BigCommerce',         'page-integration-platform.php', 'integrations' ),
        'api'            => array( 'Custom API',          'page-integration-platform.php', 'integrations' ),
        // WooCommerce shop page
        'marketplace'    => array( 'Marketplace',         '' ),
    );
}

/* ---------- Resolve a parent page ID from its slug ---------- */
function sdn_seed_parent_id( $parent_slug ) {
    if ( ! $parent_slug ) return 0;
    $parent = get_page_by_path( $parent_slug, OBJECT, 'page' );
    return $parent ? $parent->ID : 0;
}

/* ---------- Create or repair a single page ---------- */
function sdn_seed_one_page( $slug, $title, $template, $parent_slug ) {
    $existing = get_page_by_path( $slug, OBJECT, 'page' );
    $parent_id = sdn_seed_parent_id( $parent_slug );

    if ( $existing ) {
        // Repair: fix title, slug, parent, and template if they drifted.
        $needs_update = false;
        $update_args  = array( 'ID' => $existing->ID );

        if ( $existing->post_title !== $title ) {
            $update_args['post_title'] = $title;
            $needs_update = true;
        }
        if ( $existing->post_name !== $slug ) {
            $update_args['post_name'] = $slug;
            $needs_update = true;
        }
        if ( $parent_slug && $existing->post_parent != $parent_id ) {
            $update_args['post_parent'] = $parent_id;
            $needs_update = true;
        }
        if ( $needs_update ) {
            wp_update_post( $update_args );
        }
        // Always ensure the template is set correctly.
        $current_template = get_post_meta( $existing->ID, '_wp_page_template', true );
        if ( $template && $current_template !== $template ) {
            update_post_meta( $existing->ID, '_wp_page_template', $template );
        }
        return $existing->ID;
    }

    // Create new.
    $post_id = wp_insert_post( array(
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_title'   => $title,
        'post_name'    => $slug,
        'post_parent'  => $parent_id,
        'post_content' => '',
        'comment_status' => 'closed',
        'ping_status'  => 'closed',
    ) );

    if ( $post_id && ! is_wp_error( $post_id ) && $template ) {
        update_post_meta( $post_id, '_wp_page_template', $template );
    }
    return $post_id;
}

/* ---------- Run the seed once (gated by an option) ---------- */
add_action( 'init', 'sdn_seed_bespoke_pages', 40 );
function sdn_seed_bespoke_pages() {
    if ( get_option( 'sdn_pages_seeded' ) === '5' ) return;
    if ( ! post_type_exists( 'page' ) ) return;

    foreach ( sdn_seed_pages_list() as $slug => $spec ) {
        list( $title, $template ) = $spec;
        $parent = isset( $spec[2] ) ? $spec[2] : '';
        sdn_seed_one_page( $slug, $title, $template, $parent );
    }

    // Trash the obsolete Compare page (replaced by /advertise/).
    $compare = get_page_by_path( 'compare', OBJECT, 'page' );
    if ( $compare && $compare->post_status !== 'trash' ) {
        wp_trash_post( $compare->ID );
    }

    // Trash the old /search/ page (WP reserves 'search' for native search;
    // the marketplace search now lives at /marketplace-search/).
    $old_search = get_page_by_path( 'search', OBJECT, 'page' );
    if ( $old_search && $old_search->post_status !== 'trash' ) {
        wp_trash_post( $old_search->ID );
    }

    // Trash the misspelled /recomend-tools-for-ecommerce/ page (note the
    // missing 'm'). Its content is superseded by the canonical
    // /recommend-tools-for-ecommerce/ page, recreated in the new design.
    $misspelled = get_page_by_path( 'recomend-tools-for-ecommerce', OBJECT, 'page' );
    if ( $misspelled && $misspelled->post_status !== 'trash' ) {
        wp_trash_post( $misspelled->ID );
    }

    // Point the WooCommerce shop page at the Marketplace page.
    $marketplace = get_page_by_path( 'marketplace', OBJECT, 'page' );
    if ( $marketplace ) {
        update_option( 'woocommerce_shop_page_id', $marketplace->ID );
    }

    // Make sure the homepage is set to a static page (front-page.php).
    $front = get_page_by_path( 'home', OBJECT, 'page' );
    if ( $front ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front->ID );
    }

    update_option( 'sdn_pages_seeded', '5' );
    flush_rewrite_rules();
}
