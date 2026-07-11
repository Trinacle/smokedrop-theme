<?php
/**
 * Helper functions for the SmokeDrop theme
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Real brand logos (verified working files, used until the Brand CPT is populated) ---------- */
function sdn_real_brand_logos() {
    return array(
        array( 'name' => 'PAX', 'slug' => 'pax', 'file' => '2023/07/pax-1-300x162.png' ),
        array( 'name' => 'Puffco', 'slug' => 'puffco', 'file' => '2023/07/puffco-300x162.png' ),
        array( 'name' => 'RAW', 'slug' => 'raw', 'file' => '2023/07/raw-300x162.png' ),
        array( 'name' => 'Cookies', 'slug' => 'cookies', 'file' => '2023/07/brand-cookies-2-300x162.png' ),
        array( 'name' => 'GRAV', 'slug' => 'grav', 'file' => '2023/07/gravb-300x162.png' ),
        array( 'name' => 'Dr. Dabber', 'slug' => 'dr-dabber', 'file' => '2023/07/drdabber-300x162.png' ),
        array( 'name' => 'Vessel', 'slug' => 'vessel', 'file' => '2024/08/vessel0-300x162.jpg' ),
        array( 'name' => 'Pulsar', 'slug' => 'pulsar', 'file' => '2023/07/pulsar-300x162.png' ),
        array( 'name' => 'Hemper', 'slug' => 'hemper', 'file' => '2023/07/hemper-300x162.png' ),
        array( 'name' => 'Marley Natural', 'slug' => 'marley-natural', 'file' => '2023/07/marley-300x162.png' ),
        array( 'name' => 'Eyce', 'slug' => 'eyce', 'file' => '2023/07/eyce-300x162.png' ),
        array( 'name' => 'Wax Maid', 'slug' => 'wax-maid', 'file' => '2023/07/wax-maid-300x162.png' ),
        array( 'name' => 'Alchemy Naturals', 'slug' => 'alchemy-naturals', 'file' => '2024/08/alchemy-naturals-300x162.jpg' ),
        array( 'name' => 'AFG Distribution', 'slug' => 'afg-distribution', 'file' => '2024/08/afg-logo-hd-300x162.png' ),
        array( 'name' => 'O.pen', 'slug' => 'o-pen', 'file' => '2024/08/o.pen_-300x162.jpg' ),
    );
}

/* ---------- Master brand directory ----------
 * Now lives in inc/brand-directory.php (366 active + 14 new brands, generated
 * from the Headshop Brands Master List spreadsheet). See sdn_brand_directory()
 * and sdn_new_brands() there.
 */

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

/* ---------- Check if a URL looks like a real logo (not a product photo) ----
 * The migration stored production featured_media (product photos) into the
 * brand_logo meta for ~70% of brands. This heuristic rejects those so they
 * fall through to the initials fallback instead of showing a wrong image.
 *
 * POSITIVE model: a URL is only accepted as a logo if it matches one of the
 * verified logo conventions. Everything else is treated as a product photo.
 *   - '-300x162' crop suffix (the verified brand-logo banner size), OR
 *   - '-300x' any-height crop at the logo width, OR
 *   - 'logo' appears in the filename, OR
 *   - an explicit override via the sdn_is_logo_url filter.
 */
function sdn_is_logo_url( $url ) {
    if ( ! $url ) return false;
    $base = basename( parse_url( $url, PHP_URL_PATH ) );
    $base_l = strtolower( $base );
    // The -300x162 crop is the verified brand-logo banner size -> always a logo.
    if ( preg_match( '/-300x162\./i', $base ) ) return true;
    // Other -300x.. crops at logo width are also logos.
    if ( preg_match( '/-300x\d+\./i', $base ) ) return true;
    // 'logo' anywhere in the filename is a strong signal.
    if ( stripos( $base_l, 'logo' ) !== false ) return true;
    // Allow extensions to override (e.g. directory data marks a file as a logo).
    $override = apply_filters( 'sdn_is_logo_url', null, $url );
    if ( null !== $override ) return (bool) $override;
    // Default: reject. Bare names like arizer.jpg, Blazy-Susan.jpg, DynaVap1.jpg,
    // UUID imports, and large crops are all product photos.
    return false;
}

/* ---------- Get the brand logo URL ----------
 * Resolution priority (directory data is AUTHORITATIVE over migration meta,
 * which often contains a product photo instead of a logo):
 *   1) Directory 'images.logo' map (explicit per-brand override)
 *   2) Directory 'logo' field
 *   3) Migration 'brand_logo' meta (unreliable — may be a product photo)
 *   4) ucfirst(slug).png convention guess
 */
function sdn_brand_logo_url( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $slug    = get_post_field( 'post_name', $post_id );

    // 1) + 2) Directory overrides (images.logo, then logo field).
    if ( $slug && function_exists( 'sdn_brand_logo_for_slug' ) ) {
        $dir_logo = sdn_brand_logo_for_slug( $slug );
        if ( $dir_logo ) return $dir_logo;
    }

    // 3) Migration 'brand_logo' meta — guarded (reject product photos).
    $logo = sdn_get_brand_field( 'brand_logo', $post_id );
    if ( $logo && sdn_is_logo_url( $logo ) ) return sdn_normalize_upload_url( $logo );

    // 4) ucfirst(slug).png convention guess.
    $capitalized = ucfirst( $slug );
    return home_url( '/wp-content/uploads/' . $capitalized . '.png' );
}

/* ---------- Resolve a logo for a brand SLUG (not post ID) ----------
 * Used by /brands/ page + featured grids. Priority order:
 *   1) Directory 'images.logo' map (explicit per-brand, e.g. CCell, Storz-Bickel)
 *   2) Directory 'logo' field (the 16 known -300x162 logos)
 *   3) Migration 'brand_logo' meta — LAST because the migration stored the
 *      production featured_media (a product PHOTO, not a logo) here for many
 *      brands. Only used as a fallback for brands with CPT posts that have no
 *      directory override.
 * Returns '' if none found.
 */
function sdn_brand_logo_for_slug( $slug ) {
    $slug = sanitize_title( $slug );
    if ( ! $slug ) return '';

    // 1) Directory 'images' map logo (explicit per-brand override — authoritative).
    $images = sdn_brand_directory_images( $slug );
    if ( ! empty( $images['logo'] ) ) {
        return sdn_normalize_upload_url( $images['logo'] );
    }

    // 2) Directory array 'logo' field (relative path under uploads).
    if ( function_exists( 'sdn_brand_directory' ) ) {
        foreach ( sdn_brand_directory() as $b ) {
            $bslug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
            if ( $bslug === $slug && ! empty( $b['logo'] ) ) {
                return home_url( '/wp-content/uploads/' . $b['logo'] );
            }
        }
    }

    // 3) Migration 'brand_logo' meta — guarded (reject product photos so they
    //    fall through to initials instead of showing wrong images).
    $cpt = get_page_by_path( $slug, OBJECT, 'brand' );
    if ( $cpt && $cpt->post_status === 'publish' ) {
        $logo = get_post_meta( $cpt->ID, 'brand_logo', true );
        if ( $logo && sdn_is_logo_url( $logo ) ) return sdn_normalize_upload_url( $logo );
    }

    return '';
}

/* ---------- Get explicit per-brand images from the directory map ----------
 * Reads the optional 'images' field added to brand-directory.php entries
 * (e.g. CCell). Returns an associative array: ['logo'=>..., 'img1'=>...,
 * 'img2'=>..., 'img3'=>...] or empty array if not set.
 */
function sdn_brand_directory_images( $slug ) {
    $slug = sanitize_title( $slug );
    if ( ! $slug || ! function_exists( 'sdn_brand_directory' ) ) return array();

    $all = array_merge( sdn_brand_directory(), ( function_exists( 'sdn_new_brands' ) ? sdn_new_brands() : array() ) );
    foreach ( $all as $b ) {
        $bslug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
        if ( $bslug === $slug && ! empty( $b['images'] ) && is_array( $b['images'] ) ) {
            // Prefix bare filenames with the uploads path so they resolve.
            $out = array();
            foreach ( $b['images'] as $key => $val ) {
                if ( empty( $val ) ) continue;
                if ( preg_match( '#^https?://#i', $val ) || strpos( $val, '/' ) !== false ) {
                    $out[ $key ] = $val; // already a path/URL
                } else {
                    $out[ $key ] = home_url( '/wp-content/uploads/' . $val );
                }
            }
            return $out;
        }
    }
    return array();
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

/* ---------- Get gallery image URLs or IDs ----------
 * The migration stored brand_gallery as a comma-separated string of REMOTE
 * URLs (e.g. "https://thesmokedrop.com/wp-content/uploads/x.jpg,..."), but
 * the ACF field is configured to return IDs. We handle BOTH: if an entry
 * looks like a URL (contains http or /), keep it as a URL string; if it's
 * numeric, resolve it to an attachment image URL. Always returns an array
 * of resolvable image URL strings.
 */
function sdn_brand_gallery_ids( $post_id = null ) {
    $post_id = $post_id ?: get_the_ID();
    $gallery = sdn_get_brand_field( 'brand_gallery', $post_id );
    if ( ! $gallery ) return array();

    // ACF may return an array (of IDs or URLs).
    if ( is_array( $gallery ) ) {
        $items = $gallery;
    } else {
        $items = explode( ',', $gallery );
    }

    $urls = array();
    foreach ( $items as $item ) {
        $item = trim( $item );
        if ( '' === $item ) continue;
        if ( is_numeric( $item ) ) {
            // Numeric -> attachment ID
            $url = wp_get_attachment_image_url( intval( $item ), 'large' );
            if ( $url ) $urls[] = $url;
        } elseif ( preg_match( '#^https?://#i', $item ) || strpos( $item, '/' ) !== false ) {
            // It's a URL or path -> normalize staging/prod to current host
            $urls[] = sdn_normalize_upload_url( $item );
        }
    }
    return $urls;
}

/* ---------- Normalize a thesmokedrop.com upload URL to the current host ----------
 * The migration stored production URLs (thesmokedrop.com/wp-content/uploads/...).
 * On staging we need thesmokedrop.com/staging/5411/... and vice-versa. This
 * rewrites the host + path prefix so images resolve on whichever environment
 * we're running on.
 */
function sdn_normalize_upload_url( $url ) {
    if ( ! $url ) return $url;
    // Match any thesmokedrop.com host (prod or staging path) + /wp-content/uploads/
    if ( preg_match( '#https?://thesmokedrop\.com(/staging/[0-9]+)?(/wp-content/uploads/.+)#i', $url, $m ) ) {
        return home_url( $m[2] );
    }
    // Already a relative path or local URL
    return $url;
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

/* ---------- Get products by brand NAME in the title (fallback when no taxonomy) ----------
 * The user's spec: brand products have the brand name in the WooCommerce
 * product title. This matches products whose title contains the brand name,
 * used on single-brand pages and for the "test with Vessel" case.
 */
function sdn_get_brand_products_by_title( $brand_name, $limit = 4 ) {
    if ( ! class_exists( 'WooCommerce' ) || ! $brand_name ) return array();

    global $wpdb;
    $like  = '%' . $wpdb->esc_like( $brand_name ) . '%';
    $sql   = $wpdb->prepare(
        "SELECT ID FROM $wpdb->posts
         WHERE post_type = 'product'
           AND post_status = 'publish'
           AND post_title LIKE %s
         ORDER BY post_date DESC
         LIMIT %d",
        $like, $limit
    );
    $ids   = $wpdb->get_col( $sql );
    if ( empty( $ids ) ) return array();

    return array_filter( array_map( function ( $id ) {
        $p = wc_get_product( $id );
        return $p ?: null;
    }, $ids ) );
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

/* ---------- Numeric pagination (blog, category, search) ----------
 * Renders styled page numbers using paginate_links(). Use on any archive
 * with a paged main query. Styled by the .sdn-pagination rules in styles.css.
 */
function sdn_pagination() {
    global $wp_query;
    if ( $wp_query->max_num_pages <= 1 ) return;

    $big   = 999999999; // need an unlikely integer for the base
    $links = paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>',
        'next_text' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>',
        'type'      => 'array',
        'mid_size'  => 1,
        'end_size'  => 1,
    ) );
    if ( empty( $links ) ) return;
    ?>
    <nav class="sdn-pagination" aria-label="<?php esc_attr_e( 'Articles', 'smokedrop-noir' ); ?>">
      <ul>
        <?php foreach ( $links as $link ) : ?>
          <li><?php echo $link; // phpcs:ignore — paginate_links output is escaped internally ?></li>
        <?php endforeach; ?>
      </ul>
      <p class="sdn-page-info"><?php
        printf(
          esc_html__( 'Page %1$s of %2$s', 'smokedrop-noir' ),
          max( 1, get_query_var( 'paged' ) ),
          number_format_i18n( $wp_query->max_num_pages )
        );
      ?></p>
    </nav>
    <?php
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
                        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg">Start Free Trial</a>
                        <a href="<?php echo esc_url( home_url( '/demo' ) ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.3);color:#fff;">Get a Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}

/* ---------- Platform integration data (Shopify/Woo/BigComm/API) ----------
 * Single source of truth for the integration bubbles AND the per-platform
 * detail pages. Logo paths are the verified Webflow-uploaded SVGs.
 */
function sdn_platforms() {
    $uploads = home_url( '/wp-content/uploads/2024/01/' );
    return array(
        'shopify' => array(
            'slug'      => 'shopify',
            'name'      => 'Shopify',
            'logo'      => $uploads . '5f1a58272cd5b8c219db0ba4_shopify-logo.svg',
            'color'     => '#95bf47',
            'tagline'   => 'One-click install from the Shopify App Store',
            'install_url'   => 'https://apps.shopify.com/smoke-drop',
            'install_label' => 'Install on Shopify',
            'desc'      => 'The SmokeDrop Shopify app gives you everything you need to run a smoke shop dropshipping business. Import 20,000+ products in a few clicks, with automatic inventory sync, blind dropshipping, and order routing to suppliers.',
            'features'  => array(
                array( 'Import in a few clicks', 'Add curated collections or individual products to your Shopify store instantly.' ),
                array( 'Real-time inventory sync', 'Stock and price updates flow from suppliers into Shopify in under a minute.' ),
                array( 'Automatic order fulfillment', 'Customer orders route to the right supplier and ship blind under your brand.' ),
                array( 'Tracking sync', 'Tracking numbers update across suppliers, your store, and your customer automatically.' ),
            ),
            'steps' => array(
                array( 'Install the app', 'Add SmokeDrop from the Shopify App Store.' ),
                array( 'Import products', 'Browse 20,000+ SKUs and import what you want to sell.' ),
                array( 'Set prices & sell', 'Orders sync automatically — suppliers ship under your brand.' ),
            ),
        ),
        'woocommerce' => array(
            'slug'      => 'woocommerce',
            'name'      => 'WooCommerce',
            'logo'      => $uploads . '5f1a59d6f884854a22b65124_woocommerce-logo.svg',
            'color'     => '#7f54b3',
            'tagline'   => 'Self-hosted WordPress stores',
            'install_url'   => home_url( '/download-smokedrop-plugin' ),
            'install_label' => 'Download the plugin',
            'desc'      => 'The SmokeDrop WooCommerce plugin brings dropshipping to self-hosted WordPress stores. Designed to make dropshipping easy and hassle-free — sell more, work less, with no warehouse required.',
            'features'  => array(
                array( 'WordPress native', 'Install as a plugin on your existing WooCommerce store.' ),
                array( 'Full catalog access', 'Import any of 20,000+ products from 300+ brands.' ),
                array( 'Automatic order sync', 'Orders sync with suppliers; tracking updates flow back to WooCommerce.' ),
                array( 'No transaction fees', 'One flat plan fee. Keep your full margin.' ),
            ),
            'steps' => array(
                array( 'Download the plugin', 'Get the SmokeDrop WooCommerce plugin.' ),
                array( 'Connect your store', 'Install and link your WooCommerce account.' ),
                array( 'Import and sell', 'Add products, set prices, and start dropshipping.' ),
            ),
        ),
        'bigcommerce' => array(
            'slug'      => 'bigcommerce',
            'name'      => 'BigCommerce',
            'logo'      => $uploads . '5f1a5a542662b9b5006821de_bigcommerce-logo.svg',
            'color'     => '#0d7377',
            'tagline'   => 'Native BigCommerce marketplace integration',
            'install_url'   => 'https://www.bigcommerce.com/apps/smokedrop',
            'install_label' => 'Install on BigCommerce',
            'desc'      => 'Our industry-leading dropshipping app lets you list products from the SmokeDrop marketplace directly from the BigCommerce control panel. Sync inventory, automate orders, and ship blind under your brand.',
            'features'  => array(
                array( 'Native BigCommerce app', 'Install from the BigCommerce marketplace.' ),
                array( 'Direct catalog import', 'List SmokeDrop products from your control panel.' ),
                array( 'Inventory automation', 'Real-time stock and price sync across every channel.' ),
                array( 'Blind dropshipping', 'Ships under your brand with white-label packing slips.' ),
            ),
            'steps' => array(
                array( 'Install the app', 'Add SmokeDrop from the BigCommerce marketplace.' ),
                array( 'Import products', 'Browse and list from 20,000+ SKUs.' ),
                array( 'Automate & sell', 'Orders route to suppliers automatically.' ),
            ),
        ),
        'api' => array(
            'slug'      => 'api',
            'name'      => 'Custom API',
            'logo'      => '',
            'color'     => '#13c27b',
            'tagline'   => 'REST API, CSV/FTP, and EDI for custom stacks',
            'install_url'   => home_url( '/contact' ),
            'install_label' => 'Talk to our team',
            'desc'      => 'Running a custom storefront or a bespoke fulfillment stack? SmokeDrop exposes a full REST API plus CSV/FTP and EDI-X12 options so you can integrate dropshipping into any architecture.',
            'features'  => array(
                array( 'REST API', 'Full programmatic access to catalog, orders, inventory, and tracking.' ),
                array( 'CSV / FTP', 'Bulk product and order feeds for legacy or scheduled workflows.' ),
                array( 'EDI-X12', 'Enterprise electronic data interchange for large operations.' ),
                array( 'Webhooks', 'Real-time event hooks for order status, stock changes, and shipments.' ),
            ),
            'steps' => array(
                array( 'Get API credentials', 'Request access from our team.' ),
                array( 'Read the docs', 'Explore catalog, order, and inventory endpoints.' ),
                array( 'Build & launch', 'Integrate dropshipping into your custom stack.' ),
            ),
        ),
    );
}

/* ---------- Render a row of integration bubbles ---------- */
/* $platforms: array of platform keys (shopify/woocommerce/bigcommerce/api)
 * $variant: '' for default (88px tile) or 'sm' for the compact hero row (56px) */
function sdn_integration_bubbles( $platforms = array(), $variant = '' ) {
    $all    = sdn_platforms();
    $list   = empty( $platforms ) ? array_keys( $all ) : $platforms;
    $base   = home_url( '/integrations/' );
    $class  = 'int-bubble' . ( $variant === 'sm' ? ' int-bubble--sm' : '' );
    echo '<div class="int-bubbles">';
    foreach ( $list as $key ) {
        if ( ! isset( $all[ $key ] ) ) continue;
        $p = $all[ $key ];
        $href = $base . $key . '/';
        echo '<a href="' . esc_url( $href ) . '" class="' . esc_attr( $class ) . '">';
        if ( ! empty( $p['logo'] ) ) {
            echo '<span class="ib-mark"><img src="' . esc_url( $p['logo'] ) . '" alt="' . esc_attr( $p['name'] ) . '" onerror="this.style.display=\'none\'"></span>';
        } else {
            echo '<span class="ib-mark api">&lt;/&gt;</span>';
        }
        echo '<span>' . esc_html( $p['name'] ) . '</span>';
        echo '</a>';
    }
    echo '</div>';
}

/* ---------- Render a brands logo marquee (reusable section) ---------- */
/* Uses the logo'd brands from sdn_brand_directory() — same look as the
 * homepage logo wall. Optional $limit caps how many logos appear. */
function sdn_brands_marquee_section( $limit = 12 ) {
    $all = array_filter( sdn_brand_directory(), function ( $b ) { return ! empty( $b['logo'] ); } );
    if ( $limit ) $all = array_slice( $all, 0, $limit );
    if ( empty( $all ) ) return;
    $row_a = array_slice( $all, 0, ceil( count( $all ) / 2 ) );
    $row_b = array_slice( $all, ceil( count( $all ) / 2 ) );
    ?>
    <section class="logo-wall-white reveal">
      <div class="lw-wall">
        <div class="lw-row">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_a as $b ) : ?>
            <a class="lgo" href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['logo'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></a>
          <?php endforeach; endfor; ?>
        </div>
        <?php if ( ! empty( $row_b ) ) : ?>
        <div class="lw-row rev" style="margin-top:40px;">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_b as $b ) : ?>
            <a class="lgo" href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['logo'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></a>
          <?php endforeach; endfor; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php
}

/* ---------- Render a products section with bubble category filters ---------- */
/* Pulls real WooCommerce products (latest), grouped by category bubble. The
 * bubbles are non-functional filter chips (visual) — clicking scrolls to the
 * marketplace. $limit controls how many product cards show. */
function sdn_products_section( $limit = 8, $heading = 'Featured products' ) {
    if ( ! class_exists( 'WooCommerce' ) ) return;

    $products = wc_get_products( array(
        'status'  => 'publish',
        'limit'   => $limit,
        'orderby' => 'date',
        'order'   => 'DESC',
    ) );
    if ( empty( $products ) ) return;

    $shop_url = get_post_type_archive_link( 'product' ) ?: home_url( '/marketplace' );
    $cats     = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 8 ) );
    ?>
    <section class="sec">
      <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px;margin-bottom:36px;">
          <div>
            <p class="eyebrow reveal">From the marketplace</p>
            <h2 class="h-sec reveal reveal-d1" style="margin-top:14px;"><?php echo esc_html( $heading ); ?></h2>
          </div>
          <a href="<?php echo esc_url( $shop_url ); ?>" class="link-arrow reveal reveal-d2">Browse all <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>

        <?php if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) : ?>
          <div class="filter-bubbles reveal reveal-d1" style="margin-bottom:32px;">
            <?php foreach ( $cats as $c ) : ?>
              <a href="<?php echo esc_url( get_term_link( $c ) ); ?>" class="filter-bubble"><?php echo esc_html( $c->name ); ?> <span><?php echo (int) $c->count; ?></span></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <div class="market">
          <?php
          $d = array( '', ' reveal-d1', ' reveal-d2', ' reveal-d3' );
          foreach ( $products as $i => $prod ) :
              $pid   = $prod->get_id();
              $img   = wp_get_attachment_image_url( $prod->get_image_id(), 'woocommerce_thumbnail' ) ?: 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=400&q=80';
              $bt    = get_the_terms( $pid, 'product_brand' );
              $bname = ( $bt && ! is_wp_error( $bt ) ) ? $bt[0]->name : '';
              ?>
            <a href="<?php echo esc_url( $prod->get_permalink() ); ?>" class="market-card reveal<?php echo esc_attr( $d[ $i % 4 ] ); ?>" style="text-decoration:none;color:inherit;">
              <div class="mimg"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $prod->get_name() ); ?>" loading="lazy"></div>
              <div class="mbody">
                <?php if ( $bname ) : ?><span class="mbrand"><?php echo esc_html( $bname ); ?></span><?php endif; ?>
                <h4><?php echo esc_html( $prod->get_name() ); ?></h4>
                <?php if ( $prod->get_price_html() ) : ?><span class="mprice-text"><?php echo $prod->get_price_html(); // phpcs:ignore ?></span><?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php
}
