<?php
/**
 * SmokeDrop Noir — child theme functions
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SDN_VERSION', '2.9.10' );
define( 'SDN_DIR', get_stylesheet_directory() );
define( 'SDN_URI', get_stylesheet_directory_uri() );

/* ---------- Include modular files ---------- */
require_once SDN_DIR . '/inc/enqueue.php';
require_once SDN_DIR . '/inc/cpt-brands.php';
require_once SDN_DIR . '/inc/acf-fields.php';
require_once SDN_DIR . '/inc/helpers.php';
require_once SDN_DIR . '/inc/brand-directory.php';
require_once SDN_DIR . '/inc/brand-content.php';
require_once SDN_DIR . '/inc/seed-pages.php';
require_once SDN_DIR . '/inc/migrate-brands.php';

/* ---------- Theme setup ---------- */
add_action( 'after_setup_theme', 'sdn_theme_setup' );
function sdn_theme_setup() {
    // WooCommerce support
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // Core WordPress features
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

    // Image sizes for brand pages
    add_image_size( 'sdn-brand-hero', 1200, 800, true );
    add_image_size( 'sdn-brand-gallery', 600, 600, true );
    add_image_size( 'sdn-blog-thumb', 800, 500, true );

    // Register menu locations
    register_nav_menus( array(
        'solutions' => __( 'Mega Menu: Solutions', 'smokedrop-noir' ),
        'brands'    => __( 'Mega Menu: Brands', 'smokedrop-noir' ),
        'mobile'    => __( 'Mobile Menu', 'smokedrop-noir' ),
        'footer_platform' => __( 'Footer: Platform', 'smokedrop-noir' ),
        'footer_brands'   => __( 'Footer: Brands', 'smokedrop-noir' ),
        'footer_resources' => __( 'Footer: Resources', 'smokedrop-noir' ),
    ) );
}

/* ---------- Remove Astra header/footer entirely (we render our own) ---------- */
add_action( 'wp_loaded', 'sdn_kill_astra_hooks' );
function sdn_kill_astra_hooks() {
    // Remove Astra's header
    remove_action( 'astra_header', 'astra_header_markup' );
    remove_action( 'astra_header', 'astra_primary_header_markup' );
    // Remove Astra's footer
    remove_action( 'astra_footer', 'astra_footer_markup' );
    // Remove Astra's content wrappers that constrain width
    remove_action( 'astra_content_top', 'astra_content_top' );
    remove_action( 'astra_content_bottom', 'astra_content_bottom' );
}

/* ---------- Flag our bespoke templates (render 100% custom markup) ---------- */
/**
 * These templates reproduce the SmokeDrop Noir static prototype exactly and use
 * ZERO Astra widgets / Elementor widgets. On these views we strip all page-builder
 * CSS/JS so styles.css is the sole authority (the old homepage was an Elementor
 * page whose kit + widget CSS was loading AFTER ours and overriding the design).
 */
add_filter( 'template_include', 'sdn_flag_bespoke_template', 999 );
function sdn_flag_bespoke_template( $template ) {
    $bespoke = array(
        'front-page.php', 'page-pricing.php', 'page-retailers.php',
        'page-suppliers.php', 'page-platform.php', 'page-compare.php',
        'page-industries.php', 'page-demo.php', 'page-call.php',
        'page-brands.php', 'page-contact.php', 'page-about.php',
        'page-sitemap.php', 'page-help.php', 'page-testimonials.php',
        'page-wholesalers.php', 'page-integrations.php', 'page-integration-platform.php',
        'page-advertise.php', 'page-search.php',
        'page-legal.php', 'page-recommend-tools-for-ecommerce.php',
        'page-solutions.php', 'page-resources.php', 'page-download-smokedrop-plugin.php',
        'home.php', 'category.php', 'single.php', 'search.php', '404.php',
        'archive-brand.php', 'single-brand.php',
        // WooCommerce overrides live in /woocommerce/ but resolve to these
        // basenames and DO pass through template_include, so flag them bespoke.
        'single-product.php', 'archive-product.php',
    );
    if ( in_array( basename( $template ), $bespoke, true ) ) {
        $GLOBALS['sdn_bespoke'] = true;
    }
    return $template;
}

function sdn_is_bespoke_view() {
    return is_front_page() || ! empty( $GLOBALS['sdn_bespoke'] );
}

/* ---------- Strip Astra-addon + Elementor + ElementsKit + UAEL on our views ---------- */
add_action( 'wp_enqueue_scripts', 'sdn_strip_builder_assets', 100 );
function sdn_strip_builder_assets() {
    if ( ! sdn_is_bespoke_view() ) {
        return; // leave real Elementor-built pages (e.g. legacy About) untouched
    }

    // Handles (or substrings) to remove. Poppins is pulled in by astra-google-fonts.
    $kill = array( 'astra', 'elementor', 'e-animation', 'ekit', 'elementskit', 'uael', 'ultimate-elementor', 'widget-' );

    // On the Contact page we fully re-skin the Forminator form with the noir
    // theme, but Forminator's own material-design CSS loads AFTER styles.css
    // and overrides it. Dequeue Forminator's design/stylesheets here so our
    // scoped .contact-form-card overrides win. (Grid + icons stay — needed for
    // layout. Only the color/material theme sheets are removed.)
    if ( is_page( 'contact' ) ) {
        $kill[] = 'forminator-forms-material'; // material design theme (handles: forminator-forms-material-base, -accent, etc.)
        $kill[] = 'forminator-forms-flat';
        $kill[] = 'forminator-forms-bold';
        $kill[] = 'forminator-module-css'; // per-form generated stylesheet (blue/white colors)
        $kill[] = 'forminator-utilities';
    }

    // Never touch our own assets, the admin bar, or core icon fonts.
    $keep = array( 'sdn-', 'admin-bar', 'dashicons' );

    foreach ( array( 'styles', 'scripts' ) as $type ) {
        $dep = 'styles' === $type ? wp_styles() : wp_scripts();
        if ( ! ( $dep instanceof WP_Dependencies ) ) {
            continue;
        }
        foreach ( array_keys( $dep->registered ) as $handle ) {
            $h = strtolower( $handle );

            $protected = false;
            foreach ( $keep as $k ) {
                if ( 0 === strpos( $h, $k ) ) { $protected = true; break; }
            }
            if ( $protected ) {
                continue;
            }

            foreach ( $kill as $x ) {
                if ( false !== strpos( $h, $x ) ) {
                    if ( 'styles' === $type ) {
                        wp_dequeue_style( $handle );
                    } else {
                        wp_dequeue_script( $handle );
                    }
                    break;
                }
            }
        }
    }
}

/* ---------- Drop leftover Astra/Elementor body classes on bespoke views ---------- */
add_filter( 'body_class', 'sdn_clean_body_classes', 20 );

/* ---------- Performance: defer jQuery + WooCommerce JS to footer ---------- */
add_filter( 'script_loader_tag', 'sdn_defer_jquery', 10, 3 );
function sdn_defer_jquery( $tag, $handle, $src ) {
    // Don't defer jQuery on pages with Forminator forms (contact, call, or
    // any page with the footer newsletter form — which is every page).
    if ( is_page( 'contact' ) || is_page( 'call' ) || ! is_admin() ) {
        return $tag;
    }
    $defer_handles = array( 'jquery-core', 'jquery-migrate', 'jquery', 'sourcebuster',
        'wc-order-attribution', 'woocommerce', 'js-cookie', 'jquery-blockui' );
    if ( in_array( $handle, $defer_handles, true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}

/* ---------- Performance: only load WooCommerce CSS/JS on shop pages ---------- */
add_action( 'wp_enqueue_scripts', 'sdn_strip_wc_on_nonshop', 99 );
function sdn_strip_wc_on_nonshop() {
    if ( sdn_is_bespoke_view() && ! is_woocommerce() && ! is_shop() && ! is_product() && ! is_product_taxonomy() ) {
        wp_dequeue_style( 'woocommerce-general' );
        wp_dequeue_style( 'woocommerce-layout' );
        wp_dequeue_style( 'woocommerce-smallscreen' );
        wp_dequeue_script( 'woocommerce' );
        wp_dequeue_script( 'wc-cart-fragments' );
        wp_dequeue_script( 'wc-order-attribution' );
        wp_dequeue_script( 'sourcebuster' );
        wp_dequeue_script( 'js-cookie' );
    }
}

/* ---------- Performance: add preload hints for fonts + LCP image ---------- */
add_action( 'wp_head', 'sdn_preload_hints', 1 );
function sdn_preload_hints() {
    // Preload the logo (likely LCP element).
    echo '<link rel="preload" as="image" href="' . esc_url( home_url( '/wp-content/uploads/2023/07/logo.png' ) ) . '">' . "\n";
}

/* ---------- Default product sort to 'latest' on the shop/marketplace ---------- */
add_filter( 'woocommerce_default_catalog_orderby_options', 'sdn_default_orderby_latest' );
add_filter( 'woocommerce_default_catalog_orderby', 'sdn_default_orderby_latest' );
function sdn_default_orderby_latest() {
    return 'date';
}

/* ---------- Hide out-of-stock products from the shop/marketplace ---------- */
add_action( 'woocommerce_product_query', 'sdn_hide_out_of_stock' );
function sdn_hide_out_of_stock( $q ) {
    $meta_query = $q->get( 'meta_query' );
    $meta_query[] = array(
        'key'     => '_stock_status',
        'value'   => 'outofstock',
        'compare' => '!=',
    );
    $q->set( 'meta_query', $meta_query );
}

/* ---------- Hide products without a featured image on the marketplace -------
 * Products with no product photo look unfinished in the grid (they'd show the
 * Unsplash placeholder). Exclude them at the query level so pagination counts
 * stay correct.
 */
add_action( 'woocommerce_product_query', 'sdn_hide_no_image_products' );
function sdn_hide_no_image_products( $q ) {
    $meta_query   = $q->get( 'meta_query' );
    $meta_query[] = array(
        'key'     => '_thumbnail_id',
        'compare' => 'EXISTS',
    );
    $q->set( 'meta_query', $meta_query );
}

/* ---------- Inline Forminator overrides on the Contact page ----------
 * Dequeuing (above) can be fragile under page caches + load-order races.
 * This prints the re-skin CSS inline at the very end of <head> via wp_head
 * (priority 99, after all enqueued stylesheets) so the noir form styling
 * ALWAYS wins over Forminator's blue/white material theme.
 */
add_action( 'wp_footer', 'sdn_contact_forminator_overrides', 99 );
function sdn_contact_forminator_overrides() {
    if ( ! is_page( 'contact' ) ) return;
    ?>
<style>
.contact-form-card .forminator-custom-form,.contact-form-card .forminator-ui{background:transparent!important;border:none!important;box-shadow:none!important;padding:0!important}
.contact-form-card .forminator-row{margin-bottom:18px!important;background:transparent!important;border:none!important}
.contact-form-card .forminator-col{padding:0!important}
.contact-form-card .forminator-label{color:var(--ink-mute)!important;font-size:.78rem!important;font-weight:600!important;letter-spacing:.08em!important;text-transform:uppercase!important;margin-bottom:6px!important;font-family:inherit!important}
.contact-form-card .forminator-required{color:var(--green-xl)!important}
.contact-form-card .forminator-input,.contact-form-card textarea.forminator-input{background:var(--bg)!important;border:1px solid var(--line)!important;border-radius:var(--r-md)!important;color:var(--ink)!important;font-size:.95rem!important;font-family:inherit!important;padding:14px 16px!important;width:100%!important;box-sizing:border-box!important;height:auto!important;margin:0!important;box-shadow:none!important;transition:border-color .25s var(--ease)!important}
.contact-form-card .forminator-input:focus,.contact-form-card textarea.forminator-input:focus{border-color:var(--green-l)!important;outline:none!important}
.contact-form-card .forminator-input::placeholder,.contact-form-card textarea::placeholder{color:var(--ink-mute)!important}
.contact-form-card textarea.forminator-input{min-height:120px!important;resize:vertical!important}
.contact-form-card .forminator-button-submit{background:var(--green)!important;color:#fff!important;border:none!important;border-radius:var(--r-md)!important;padding:14px 32px!important;font-size:.95rem!important;font-weight:600!important;font-family:inherit!important;width:100%!important;text-transform:none!important;letter-spacing:normal!important;cursor:pointer!important;box-shadow:none!important;margin-top:8px!important;transition:background .2s var(--ease),transform .2s var(--ease)!important}
.contact-form-card .forminator-button-submit:hover{background:var(--green-d)!important;transform:translateY(-1px)!important}
.contact-form-card .forminator-response-message{border-radius:var(--r-md)!important;padding:14px 16px!important;font-size:.9rem!important}
.contact-form-card .forminator-error{background:rgba(255,99,99,.1)!important;border:1px solid rgba(255,99,99,.3)!important;color:#ff8585!important}
.contact-form-card .forminator-success{background:rgba(19,194,123,.1)!important;border:1px solid rgba(19,194,123,.3)!important;color:var(--green-xl)!important}
</style>
    <?php
}
function sdn_clean_body_classes( $classes ) {
    if ( ! sdn_is_bespoke_view() ) {
        return $classes;
    }
    return array_filter( $classes, function ( $c ) {
        return false === strpos( $c, 'elementor' )
            && false === strpos( $c, 'ast-theme-transparent-header' )
            && false === strpos( $c, 'ast-hfb-header' );
    } );
}

/* ---------- SEO: Yoast integration + enhanced schema ----------
 * Yoast SEO is active and handles meta titles, descriptions, and OG tags.
 * We DON'T duplicate those (duplicate og:image / og:title confused social
 * crawlers). Instead we FILTER Yoast to enforce correct values where the
 * DB-configured defaults are wrong or missing, and add schema types Yoast
 * doesn't generate (WebSite SearchAction, additional Organization data).
 */

// Default social share image — used as fallback OG image on every page.
define( 'SDN_OG_IMAGE', '/wp-content/uploads/2024/06/smokedrop-600x338.webp' );

/* Enforce the correct OG image when Yoast's per-page value is missing or
 * points to a wrong/old file. Runs late so Yoast's own filters apply first. */
add_filter( 'wpseo_opengraph_image', 'sdn_yoast_og_image' );
add_filter( 'wpseo_twitter_image',   'sdn_yoast_og_image' );
function sdn_yoast_og_image( $img ) {
    if ( $img && strpos( $img, 'shopifiy.png' ) === false && strpos( $img, 'drop-shipping-smoke-products' ) === false ) {
        return $img; // a real, correct image is already set — respect it
    }
    return home_url( SDN_OG_IMAGE );
}

/* Per-page meta descriptions — Yoast DB fields are empty for these bespoke
 * landing pages, so auto-generated descriptions pull page content (messy).
 * These targeted, keyword-rich descriptions are ~155 chars each. */
add_filter( 'wpseo_metadesc', 'sdn_yoast_metadesc' );
function sdn_yoast_metadesc( $desc ) {
    // If Yoast already has a hand-written description for this page, keep it.
    if ( $desc && strlen( $desc ) <= 160 ) return $desc;

    $map = array(
        // slug-path => meta description
        ''                           => 'SmokeDrop is the #1 smoke shop dropshipping platform. Import 20,000+ smoke, vape & CBD products to your Shopify or WooCommerce store. Start free.',
        'pricing'                    => 'SmokeDrop pricing starts at $49.99/mo with a 7-day free trial. Dropship 20,000+ smoke shop products. Shopify & WooCommerce integrations included. No transaction fees.',
        'marketplace'                => 'Browse the SmokeDrop marketplace: 20,000+ smoke, vape, glass & CBD products from 300+ brands. Create a free account to unlock wholesale pricing and dropship.',
        'brands'                     => 'Discover 300+ smoke shop brands available for dropshipping and wholesale on SmokeDrop: PAX, Puffco, Cookies, RAW, Storz & Bickel, DynaVap, GRAV and more.',
        'retailers'                  => 'Retailers: automate smoke shop dropshipping with SmokeDrop. Sync 20,000+ products, auto-fulfill orders, white-label shipping. Shopify & WooCommerce integration.',
        'suppliers'                  => 'Suppliers: launch a dropship channel on SmokeDrop from $49.99/mo. Reach thousands of retailers, automate order fulfillment, and grow distribution.',
        'wholesalers'                => 'Wholesalers: buy smoke, vape & CBD products at wholesale pricing through SmokeDrop. Browse 300+ brands, bulk ordering, no minimums on most items.',
        'help'                       => 'SmokeDrop Help Center: guides, FAQs, and docs for setting up your dropshipping store, syncing products, and managing orders on Shopify and WooCommerce.',
        'contact'                    => 'Contact SmokeDrop for smoke shop dropshipping support, supplier partnerships, or sales inquiries. Reach our team and start dropshipping 20,000+ products.',
        'about'                      => 'SmokeDrop is the industry-leading smoke shop dropshipping marketplace, connecting retailers with 300+ suppliers and 20,000+ products since 2023.',
        'advertise'                  => 'Advertise on SmokeDrop: featured listings, homepage placement, newsletter sponsorships, and sponsored content. Reach smoke shop retailers and suppliers.',
        'demo'                       => 'Get a personalized SmokeDrop demo. See how to dropship 20,000+ smoke shop products with automatic inventory sync and order fulfillment.',
        'integrations'               => 'SmokeDrop integrates with Shopify, WooCommerce, and BigCommerce. One-click product import, automatic inventory sync, and order fulfillment.',
        'industries'                 => 'SmokeDrop serves smoke shops, vape shops, CBD stores, dispensaries, and headshops. Dropship products across the entire smoke, vape & hemp industry.',
        'resources'                  => 'SmokeDrop resources: dropshipping guides, growth tactics, supplier spotlights, and industry insights for smoke shop retailers.',
        'testimonials'               => 'Read what smoke shop retailers say about SmokeDrop. Real reviews from Shopify and WooCommerce store owners growing with smoke shop dropshipping.',
    );

    // Match by page path.
    $path = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ), '/' );
    // Strip staging subpath if present (/staging/5411/...).
    $home_path = trim( wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
    if ( $home_path && strpos( $path, $home_path ) === 0 ) {
        $path = ltrim( substr( $path, strlen( $home_path ) ), '/' );
    }
    if ( isset( $map[ $path ] ) ) {
        return $map[ $path ];
    }

    // Brand pages: generate a description from the brand name.
    // Note: brand pages use virtual routing (sdn_brand_slug query var), so
    // is_singular('brand') is false. Detect by URL path instead.
    if ( preg_match( '#^brand/([a-z0-9-]+)/?$#i', $path, $bm ) ) {
        $bslug = $bm[1];
        // Resolve the brand name from the CPT post or directory.
        $bname = '';
        $cpt = get_page_by_path( $bslug, OBJECT, 'brand' );
        if ( $cpt ) {
            $bname = get_the_title( $cpt );
        } else {
            foreach ( sdn_brand_directory() as $b ) {
                if ( ( $b['slug'] ?? '' ) === $bslug ) { $bname = $b['name'] ?? ''; break; }
            }
        }
        if ( $bname && function_exists( 'sdn_brand_description' ) ) {
            $d = wp_strip_all_tags( sdn_brand_description( $bname ) );
            if ( strlen( $d ) > 155 ) $d = substr( $d, 0, 152 ) . '...';
            return $d;
        }
    }

    return $desc;
}

/* Homepage meta title — clean, no duplicated brand name. */
add_filter( 'wpseo_title', 'sdn_yoast_title', 10, 2 );
function sdn_yoast_title( $title ) {
    if ( is_front_page() ) {
        return 'SmokeDrop — #1 Smoke Shop Dropshipping App | Shopify & WooCommerce';
    }
    // Brand pages: build a proper SEO title from the brand name.
    $path = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ), '/' );
    $home_path = trim( wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
    if ( $home_path && strpos( $path, $home_path ) === 0 ) {
        $path = ltrim( substr( $path, strlen( $home_path ) ), '/' );
    }
    if ( preg_match( '#^brand/([a-z0-9-]+)/?$#i', $path, $bm ) ) {
        $bslug = $bm[1];
        $bname = '';
        $cpt = get_page_by_path( $bslug, OBJECT, 'brand' );
        if ( $cpt ) {
            $bname = get_the_title( $cpt );
        } else {
            foreach ( sdn_brand_directory() as $b ) {
                if ( ( $b['slug'] ?? '' ) === $bslug ) { $bname = $b['name'] ?? ''; break; }
            }
        }
        if ( $bname ) {
            return 'Dropship & Wholesale ' . $bname . ' Products | SmokeDrop';
        }
    }
    return $title;
}

/* Homepage OG title + description — match the clean values above. */
add_filter( 'wpseo_opengraph_title', 'sdn_yoast_homepage_og_title' );
function sdn_yoast_homepage_og_title( $title ) {
    if ( is_front_page() ) {
        return 'SmokeDrop — #1 Smoke Shop Dropshipping App';
    }
    return $title;
}
add_filter( 'wpseo_opengraph_desc', 'sdn_yoast_homepage_og_desc' );
function sdn_yoast_homepage_og_desc( $desc ) {
    if ( is_front_page() ) {
        return 'Import 20,000+ smoke, vape & CBD products to your store. Sync inventory, auto-fulfill orders. Shopify & WooCommerce. Start free.';
    }
    return $desc;
}

/* ---------- Enhanced JSON-LD schema (complements Yoast's graph) ----------
 * Yoast outputs Organization + WebSite + Breadcrumb schema already. We add
 * a richer Organization block (sameAs social profiles) + a WebSite
 * SearchAction so Google can show a sitelinks search box.
 */
add_action( 'wp_head', 'sdn_schema', 20 );
function sdn_schema() {
    if ( is_admin() ) return;
    $home = home_url( '/' );

    // Organization / Business — enriched with social profiles + contact.
    $org = array(
        '@context' => 'https://schema.org',
        '@type'    => 'Organization',
        '@id'      => $home . '#organization',
        'name'     => 'SmokeDrop',
        'url'      => $home,
        'logo'     => home_url( '/wp-content/uploads/2023/07/logo.png' ),
        'image'    => home_url( SDN_OG_IMAGE ),
        'description' => 'The #1 smoke shop dropshipping platform. Sync 20,000+ smoke, vape & CBD products to Shopify and WooCommerce stores.',
        'sameAs'   => array(
            'https://www.facebook.com/thesmokedrop/',
            'https://x.com/smokedropapp',
            'https://www.youtube.com/@thesmokedrop',
            'https://apps.shopify.com/smoke-drop',
        ),
        'contactPoint' => array(
            array(
                '@type'       => 'ContactPoint',
                'contactType' => 'customer support',
                'url'         => home_url( '/contact' ),
                'areaServed'  => 'US',
            ),
        ),
    );
    echo '<script type="application/ld+json">' . wp_json_encode( $org ) . '</script>' . "\n";

    // WebSite with SearchAction (enables Google sitelinks search box).
    if ( is_front_page() ) {
        $site = array(
            '@context'       => 'https://schema.org',
            '@type'          => 'WebSite',
            '@id'            => $home . '#website',
            'url'            => $home,
            'name'           => 'SmokeDrop',
            'publisher'      => array( '@id' => $home . '#organization' ),
            'potentialAction' => array(
                array(
                    '@type'       => 'SearchAction',
                    'target'      => array(
                        '@type'       => 'EntryPoint',
                        'urlTemplate' => home_url( '/marketplace-search?q={search_term_string}' ),
                    ),
                    'query-input' => 'required name=search_term_string',
                ),
            ),
        );
        echo '<script type="application/ld+json">' . wp_json_encode( $site ) . '</script>' . "\n";
    }
}

/* ---------- Custom body classes ---------- */
add_filter( 'body_class', 'sdn_body_classes' );
function sdn_body_classes( $classes ) {
    $classes[] = 'smokedrop-noir';
    return $classes;
}

/* ---------- WooCommerce: remove default wrappers, add our own ---------- */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'sdn_woo_wrapper_start', 10 );
function sdn_woo_wrapper_start() {
    echo '<main id="main" class="site-main"><div class="wrap">';
}

add_action( 'woocommerce_after_main_content', 'sdn_woo_wrapper_end', 10 );
function sdn_woo_wrapper_end() {
    echo '</div></main>';
}

/* ---------- Remove WooCommerce breadcrumbs (we have our own nav) ---------- */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/* ---------- Helper: get the logo ---------- */
function sdn_logo( $size = 34 ) {
    $dark_url  = home_url( '/wp-content/uploads/2024/06/sd-white-logo.png' ); // for dark backgrounds
    $light_url = home_url( '/wp-content/uploads/2023/07/logo.png' );          // for light backgrounds
    $h         = intval( $size );
    return '<img src="' . esc_url( $dark_url ) . '" alt="SmokeDrop" class="logo-dark" style="height:' . $h . 'px;width:auto;">'
        . '<img src="' . esc_url( $light_url ) . '" alt="SmokeDrop" class="logo-light" style="height:' . $h . 'px;width:auto;">';
}
