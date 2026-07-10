<?php
/**
 * Enqueue all CSS and JS
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'sdn_enqueue', 20 );
function sdn_enqueue() {
    // Google Fonts: Inter + Inter Tight (with swap for non-blocking)
    wp_enqueue_style(
        'sdn-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Inter+Tight:wght@500;600;700&display=swap',
        array(),
        null
    );

    // Main stylesheet (the full design system) — no WC dependency
    wp_enqueue_style(
        'sdn-styles',
        get_stylesheet_directory_uri() . '/assets/css/styles.css',
        array(),
        SDN_VERSION
    );

    // Main JS (vanilla — no jQuery dependency)
    wp_enqueue_script(
        'sdn-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        SDN_VERSION,
        true // load in footer
    );

    // Calendly scheduler widget — only on the Schedule Call page
    if ( is_page_template( 'page-call.php' ) ) {
        wp_enqueue_script(
            'sdn-calendly',
            'https://assets.calendly.com/assets/external/widget.js',
            array(),
            null,
            true
        );
    }
}

/* ---------- Preconnect to third-party origins for faster font/image loads ---------- */
add_action( 'wp_head', 'sdn_preconnect', 1 );
function sdn_preconnect() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/* ---------- Add <html> class for theme-color (helps mobile browsers) ---------- */
add_filter( 'language_attributes', 'sdn_html_attrs' );
function sdn_html_attrs( $output ) {
    // The theme toggle JS adds/removes .light on <html>. Preload the saved theme
    // to avoid a flash of dark when user prefers light.
    $saved = isset( $_COOKIE['sd-theme'] ) ? $_COOKIE['sd-theme'] : '';
    if ( $saved === 'light' ) {
        $output .= ' class="light"';
    }
    return $output;
}
