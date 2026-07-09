<?php
/**
 * SmokeDrop Noir — child theme functions
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SDN_VERSION', '2.4.0' );
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

/* ---------- SEO: Open Graph + meta ---------- */
add_action( 'wp_head', 'sdn_meta_tags', 5 );
function sdn_meta_tags() {
    if ( is_front_page() ) {
        echo '<meta name="description" content="SmokeDrop — the #1 online smoke shop dropshipping app. Import over 20,000 smoke shop products. Shopify, WooCommerce & BigCommerce.">' . "\n";
        echo '<meta property="og:title" content="SmokeDrop — #1 Online Smoke Shop Dropshipping App">' . "\n";
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:url" content="' . esc_url( home_url( '/' ) ) . '">' . "\n";
        echo '<meta property="og:image" content="' . esc_url( home_url( '/wp-content/uploads/2023/07/drop-shipping-smoke-products-2.png' ) ) . '">' . "\n";
    }
    // Structured data
    if ( is_front_page() ) {
        echo '<script type="application/ld+json">{"@context":"https://schema.org","@type":"Organization","name":"SmokeDrop","url":"' . esc_url( home_url( '/' ) ) . '","logo":"' . esc_url( home_url( '/wp-content/uploads/2023/07/logo.png' ) ) . '"}</script>' . "\n";
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
