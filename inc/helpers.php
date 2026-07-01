<?php
/**
 * Helper functions for the SmokeDrop theme
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Get a brand field with fallback (works even without ACF) ---------- */
function sdn_get_brand_field( $field, $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    if ( function_exists( 'get_field' ) ) {
        $val = get_field( $field, $post_id );
        if ( $val ) return $val;
    }
    // Fallback to post meta (for when ACF isn't active)
    return get_post_meta( $post_id, $field, true );
}

/* ---------- Get the brand logo URL ---------- */
function sdn_brand_logo_url( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $logo = sdn_get_brand_field( 'brand_logo', $post_id );
    if ( $logo ) return $logo;
    // Fallback: try thesmokedrop.com standard logo path
    $slug = get_post_field( 'post_name', $post_id );
    $capitalized = ucfirst( $slug );
    return home_url( '/wp-content/uploads/' . $capitalized . '.png' );
}

/* ---------- Get the split-hero image URL ---------- */
function sdn_brand_hero_image_url( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $hero = sdn_get_brand_field( 'brand_hero_image', $post_id );
    if ( $hero ) return $hero;
    // Fallback to featured image
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail_url( $post_id, 'sdn-brand-hero' );
    }
    return '';
}

/* ---------- Get gallery image IDs ---------- */
function sdn_brand_gallery_ids( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $gallery = sdn_get_brand_field( 'brand_gallery', $post_id );
    if ( $gallery ) {
        if ( is_array( $gallery ) ) return $gallery;
        // Gallery field might return comma-separated IDs
        return array_map( 'intval', explode( ',', $gallery ) );
    }
    return array();
}

/* ---------- Render a video embed (YouTube/IG/FB/Vimeo) ---------- */
function sdn_render_video_embed( $url, $type = '' ) {
    if ( ! $url ) return '';
    // Try WP oEmbed first (handles YouTube + Vimeo natively)
    if ( function_exists( 'wp_oembed_get' ) ) {
        $embed = wp_oembed_get( $url );
        if ( $embed ) return '<div class="brand-video-embed">' . $embed . '</div>';
    }
    // Fallback per-type
    if ( ! $type ) {
        if ( strpos( $url, 'youtu' ) !== false ) $type = 'youtube';
        elseif ( strpos( $url, 'instagram' ) !== false ) $type = 'instagram';
        elseif ( strpos( $url, 'facebook' ) !== false ) $type = 'facebook';
    }
    switch ( $type ) {
        case 'youtube':
            $video_id = '';
            if ( preg_match( '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m ) ) $video_id = $m[1];
            if ( $video_id ) return '<div class="brand-video-embed"><iframe src="https://www.youtube.com/embed/' . $video_id . '" allowfullscreen loading="lazy"></iframe></div>';
            break;
        case 'instagram':
            return '<div class="brand-video-embed"><blockquote class="instagram-media" data-instgrm-permalink="' . esc_url( $url ) . '"><a href="' . esc_url( $url ) . '">View on Instagram</a></blockquote><script async src="//www.instagram.com/embed.js"></script></div>';
        case 'facebook':
            return '<div class="brand-video-embed"><iframe src="https://www.facebook.com/plugins/video.php?href=' . urlencode( $url ) . '&show_text=false" allowfullscreen loading="lazy"></iframe></div>';
    }
    // Last resort: just link it
    return '<a href="' . esc_url( $url ) . '" target="_blank" class="btn btn-outline">Watch video</a>';
}

/* ---------- Get WooCommerce products for a brand ---------- */
function sdn_get_brand_products( $brand_slug, $limit = 4 ) {
    if ( ! class_exists( 'WooCommerce' ) ) return array();

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_brand',
                'field'    => 'slug',
                'terms'    => $brand_slug,
            ),
        ),
    );

    // Also check if the brand CPT post slug matches the product_brand taxonomy slug
    $products = get_posts( $args );
    if ( empty( $products ) ) {
        // Try matching by the brand post name
        $term = get_term_by( 'slug', $brand_slug, 'product_brand' );
        if ( $term ) {
            $args['tax_query'][0]['terms'] = $term->term_id;
            $args['tax_query'][0]['field'] = 'term_id';
            $products = get_posts( $args );
        }
    }
    return $products;
}

/* ---------- Format a brand directory A-Z ---------- */
function sdn_brands_alphabetical( $featured_only = false ) {
    $args = array(
        'post_type'      => 'brand',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    );
    if ( $featured_only ) {
        $args['meta_query'] = array(
            array(
                'key'   => 'brand_featured',
                'value' => '1',
                'type'  => 'NUMERIC',
                'compare' => '=',
            ),
        );
    }

    // Fallback: if meta_query fails (no ACF), just get all
    $brands = get_posts( $args );
    if ( empty( $brands ) && $featured_only ) {
        unset( $args['meta_query'] );
        $brands = get_posts( $args );
    }

    $grouped = array();
    foreach ( $brands as $brand ) {
        $letter = strtoupper( substr( $brand->post_title, 0, 1 ) );
        if ( ! ctype_alpha( $letter ) ) $letter = '#';
        if ( ! isset( $grouped[ $letter ] ) ) $grouped[ $letter ] = array();
        $grouped[ $letter ][] = $brand;
    }
    ksort( $grouped );
    return $grouped;
}

/* ---------- Estimate reading time for a post (e.g. "8 min") ---------- */
function sdn_reading_time( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $content = get_post_field( 'post_content', $post_id );
    $words   = str_word_count( wp_strip_all_tags( $content ) );
    $minutes = max( 1, (int) ceil( $words / 200 ) );
    return $minutes . ' min';
}

/* ---------- Chevron icon (used in nav) ---------- */
function sdn_chevron() {
    return '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>';
}

/* ---------- Arrow icon (used in CTAs) ---------- */
function sdn_arrow() {
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
}

/* ---------- Reusable CTA component ---------- */
function sdn_cta( $title = 'Ready to take your drop shipping to the next level?', $desc = 'Request a demo today & see how SmokeDrop can help boost your dropshipping revenue.' ) {
    ?>
    <section class="sec-sm">
        <div class="wrap">
            <div class="cta-bg reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));">
                <div class="inner">
                    <h2 class="display" style="color:#fff;"><?php echo esc_html( $title ); ?></h2>
                    <?php if ( $desc ) : ?>
                        <p class="lede"><?php echo esc_html( $desc ); ?></p>
                    <?php endif; ?>
                    <div class="hero-actions">
                        <a href="https://app.thesmokedrop.com" class="btn btn-lime btn-lg">Start dropshipping free</a>
                        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.3);color:#fff;">Request demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
