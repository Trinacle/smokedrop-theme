<?php
/**
 * Single Brand template.
 *
 * Renders one brand's marketplace page: hero + logo, brand story (if any),
 * and the brand's WooCommerce products. Products are matched by:
 *   1. The product_brand taxonomy term matching the brand slug, OR
 *   2. The brand name appearing in the product title (fallback).
 *
 * Works two ways:
 *   - Real CPT post at /brand/{slug}/ (preferred, editable in wp-admin).
 *   - Virtual brand resolved from sdn_brand_directory() when no CPT post
 *     exists yet, so the page works immediately for testing (e.g. Vessel).
 *
 * The "Brand products" section is hidden entirely when no products match.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Resolve the brand being requested.
$sdn_brand     = null;
$sdn_is_cpt    = false;
$sdn_cpt_id    = 0;
$sdn_slug      = '';
$sdn_name      = '';
$sdn_logo_url  = '';
$sdn_desc      = '';
$sdn_register  = 'https://wholesale.thesmokedrop.com/register';
$sdn_brands_pg = home_url( '/brands' );

// The slug we're rendering — either from the main query, the rewrite query var,
// or the request filter's sdn_brand_slug.
$sdn_requested = '';
if ( get_query_var( 'sdn_brand_slug' ) ) {
    $sdn_requested = get_query_var( 'sdn_brand_slug' );
} elseif ( isset( $GLOBALS['wp']->query_vars['name'] ) ) {
    $sdn_requested = $GLOBALS['wp']->query_vars['name'];
} elseif ( isset( $GLOBALS['wp']->query_vars['brand'] ) ) {
    $sdn_requested = $GLOBALS['wp']->query_vars['brand'];
}

// Normalize legacy/alternate slugs (e.g. storz-bickel -> storz-and-bickel)
// so the canonical CPT post + directory entry resolve instead of 404ing.
if ( $sdn_requested ) {
    $sdn_requested = sdn_resolve_brand_slug( $sdn_requested );
}

// Try a real CPT brand post by slug FIRST (the migration writes content here).
if ( $sdn_requested ) {
    $cpt_post = get_page_by_path( $sdn_requested, OBJECT, 'brand' );
    if ( $cpt_post && $cpt_post->post_status === 'publish' ) {
        $sdn_is_cpt = true;
        $sdn_cpt_id = $cpt_post->ID;
        $sdn_slug   = $cpt_post->post_name;
        $sdn_name   = get_the_title( $cpt_post );
        // Logo: sdn_brand_logo_url() now resolves directory images.logo -> directory
        // logo -> migration meta -> ucfirst(slug).png (in that priority order), so
        // directory overrides (CCell, Storz-Bickel) win over the unreliable meta.
        $sdn_logo_url = sdn_brand_logo_url( $cpt_post->ID );
        // Directory 'images' map for hero/gallery (CCell, Storz-Bickel, etc.).
        $sdn_dir_images = function_exists( 'sdn_brand_directory_images' ) ? sdn_brand_directory_images( $sdn_requested ) : array();
        // Use the migrated post content, BUT detect the broken boilerplate
        // the migration wrote (a generic "Welcome to SmokeDrop..." template
        // that hardcodes "Cookies branded items" regardless of the actual
        // brand). When detected, fall back to the generated brand-specific
        // description so the page reads correctly.
        $raw_content = $cpt_post->post_content;
        $has_real    = trim( wp_strip_all_tags( $raw_content ) ) ? true : false;
        $is_boilerplate = $has_real && (
            stripos( $raw_content, 'Cookies branded' ) !== false ||
            stripos( $raw_content, 'Cookies products into your' ) !== false ||
            ( stripos( $raw_content, 'Welcome to SmokeDrop, where innovation meets convenience' ) !== false
              && stripos( $raw_content, 'Cookies' ) !== false )
        );
        if ( $has_real && ! $is_boilerplate ) {
            $sdn_desc = apply_filters( 'the_content', $raw_content );
        } elseif ( function_exists( 'sdn_brand_description' ) ) {
            $sdn_desc = '<p>' . esc_html( sdn_brand_description( $sdn_name ) ) . '</p>';
        } else {
            $sdn_desc = '';
        }
    }
}

// Directory array fallback (for brands not yet in the CPT, or to fill a logo).
if ( ! $sdn_name ) {
    foreach ( sdn_brand_directory() as $b ) {
        $bslug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
        if ( $bslug === $sdn_requested ) {
            $sdn_slug     = $bslug;
            $sdn_name     = str_replace( '\\u2019', "'", $b['name'] );
            $sdn_logo_url = ! empty( $b['logo'] ) ? home_url( '/wp-content/uploads/' . $b['logo'] ) : '';
            break;
        }
    }
}

// If we still have nothing, treat as 404.
if ( ! $sdn_name ) {
    global $wp_query;
    $wp_query->set_404();
    status_header( 404 );
    nocache_headers();
    get_header();
    echo '<main><section class="sec"><div class="wrap center"><h1 class="display">Brand not found</h1><p style="color:var(--ink-mute);margin:16px 0 24px;">This brand isn\'t on the marketplace yet.</p><a href="' . esc_url( $sdn_brands_pg ) . '" class="btn btn-lime">Browse all brands</a></div></section></main>';
    get_footer();
    return;
}

// Fetch this brand's products: taxonomy term first, then title match.
$sdn_products = sdn_get_brand_products( $sdn_slug, 12 );
if ( empty( $sdn_products ) ) {
    $sdn_products = sdn_get_brand_products_by_title( $sdn_name, 12 );
}

// Generate unique descriptive copy ONLY when the CPT post has no real content
// (the migration writes real brand copy into post_content; don't clobber it).
if ( ! $sdn_desc ) {
    $sdn_desc = sdn_brand_description( $sdn_name );
}
$sdn_niche = sdn_brand_niche( $sdn_name );

// Gallery: prefer migrated CPT meta (real brand photos). Only backfill from
// Woo products when there ARE Woo products (no Unsplash fallbacks — those
// make the gallery look fake). Uses $sdn_cpt_id (resolved above) since
// get_the_ID() is empty in the virtual-brand routing path.
$sdn_gallery_urls = $sdn_cpt_id ? sdn_brand_gallery_ids( $sdn_cpt_id ) : array();
$sdn_hero_img     = $sdn_cpt_id ? sdn_brand_hero_image_url( $sdn_cpt_id ) : '';

// Directory 'images' map (explicit per-brand, e.g. CCell, Storz-Bickel) takes
// priority for hero + gallery — it's the verified-correct image set.
if ( ! empty( $sdn_dir_images ) ) {
    $sdn_hero_img = ! empty( $sdn_dir_images['img1'] )
        ? sdn_normalize_upload_url( $sdn_dir_images['img1'] )
        : $sdn_hero_img;
    $dir_gallery = array();
    foreach ( array( 'img1', 'img2', 'img3' ) as $key ) {
        if ( ! empty( $sdn_dir_images[ $key ] ) ) {
            $dir_gallery[] = sdn_normalize_upload_url( $sdn_dir_images[ $key ] );
        }
    }
    if ( ! empty( $dir_gallery ) ) {
        $sdn_gallery_urls = $dir_gallery;
    }
} elseif ( empty( $sdn_gallery_urls ) && function_exists( 'sdn_brand_directory_images' ) ) {
    $sdn_gallery_urls = sdn_brand_directory_images( $sdn_slug ?: $sdn_requested );
}

$sdn_gallery = array();

// 1) Migrated/gallery meta (now always an array of URL strings).
if ( ! empty( $sdn_gallery_urls ) ) {
    foreach ( $sdn_gallery_urls as $u ) {
        if ( $u ) $sdn_gallery[] = $u;
    }
}

// 2) Backfill to 3 from Woo products ONLY (real brand products, no Unsplash).
//    sdn_brand_gallery_images() falls back to Unsplash internally, so filter
//    those out — we'd rather show fewer real photos than fake ones.
if ( count( $sdn_gallery ) < 3 ) {
    $woo_imgs = sdn_brand_gallery_images( $sdn_name, 3 );
    foreach ( $woo_imgs as $wi ) {
        if ( strpos( $wi, 'unsplash.com' ) === false ) $sdn_gallery[] = $wi;
    }
    $sdn_gallery = array_slice( array_unique( $sdn_gallery ), 0, 3 );
}

// If we have gallery images but no dedicated hero, use the first gallery image.
if ( ! $sdn_hero_img && ! empty( $sdn_gallery ) ) {
    $sdn_hero_img = $sdn_gallery[0];
}

get_header();
?>

<main>
  <!-- BRAND HERO (always 2-column: logo+CTA left, image right) -->
  <section class="brand-hero brand-hero--split">
    <div class="wrap brand-hero-grid">
      <div class="brand-hero-left">
        <div class="brand-hero-logo reveal">
          <?php if ( $sdn_logo_url ) : ?>
            <img src="<?php echo esc_url( $sdn_logo_url ); ?>" alt="<?php echo esc_attr( $sdn_name ); ?>" onerror="this.style.display='none';this.nextElementSibling.style.display='grid'">
            <span class="brand-hero-mark" style="display:none"><?php echo esc_html( strtoupper( substr( $sdn_name, 0, 2 ) ) ); ?></span>
          <?php else : ?>
            <span class="brand-hero-mark"><?php echo esc_html( strtoupper( substr( $sdn_name, 0, 2 ) ) ); ?></span>
          <?php endif; ?>
        </div>
        <div class="brand-hero-text reveal reveal-d1">
          <p class="eyebrow">Brand on the SmokeDrop marketplace &middot; <?php echo esc_html( ucfirst( $sdn_niche ) ); ?></p>
          <h1 class="display"><?php echo esc_html( $sdn_name ); ?></h1>
          <div class="brand-hero-desc"><?php echo $sdn_desc ? wp_kses_post( $sdn_desc ) : wp_kses_post( wpautop( sdn_brand_description( $sdn_name ) ) ); ?></div>
          <div class="hero-actions">
            <a href="<?php echo esc_url( $sdn_register ); ?>" class="btn btn-lime btn-lg">Dropship <?php echo esc_html( $sdn_name ); ?> products</a>
            <a href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>" class="btn btn-outline btn-lg">View Wholesale Prices</a>
          </div>
        </div>
      </div>
      <div class="bhg-img reveal reveal-d2">
        <?php if ( $sdn_hero_img ) : ?>
          <img src="<?php echo esc_url( $sdn_hero_img ); ?>" alt="<?php echo esc_attr( $sdn_name ); ?> product">
        <?php else : ?>
          <div class="bhg-fallback"><span><?php echo esc_html( strtoupper( substr( $sdn_name, 0, 2 ) ) ); ?></span></div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- BRAND GALLERY (product photos) — only when real photos exist -->
  <?php $sdn_has_real_gallery = ! empty( $sdn_gallery ); ?>
  <?php if ( $sdn_has_real_gallery ) : ?>
  <section class="sec brand-gallery-sec">
    <div class="wrap">
      <p class="eyebrow reveal">From the catalog</p>
      <h2 class="h-sec reveal reveal-d1" style="margin-top:14px;margin-bottom:32px;">Featured <?php echo esc_html( $sdn_name ); ?> products</h2>
      <div class="brand-gallery reveal reveal-d2">
        <?php foreach ( $sdn_gallery as $i => $img ) : ?>
          <div class="bg-cell">
            <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $sdn_name ); ?> product" loading="lazy">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ( ! empty( $sdn_products ) ) : ?>
    <!-- BRAND PRODUCTS -->
    <section class="sec brand-products-sec">
      <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:16px;margin-bottom:40px;">
          <div>
            <p class="eyebrow reveal">Available for dropship</p>
            <h2 class="h-sec reveal reveal-d1" style="margin-top:14px;"><?php echo esc_html( $sdn_name ); ?> products</h2>
          </div>
          <a href="<?php echo esc_url( $sdn_register ); ?>" class="link-arrow reveal reveal-d2">Start dropshipping <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
        <div class="market">
          <?php
          $d = array( '', ' reveal-d1', ' reveal-d2', ' reveal-d3' );
          foreach ( $sdn_products as $i => $p ) {
              $pid = ( $p instanceof WC_Product ) ? $p->get_id() : ( is_object( $p ) ? $p->ID : $p );
              $prod = wc_get_product( $pid );
              if ( ! $prod ) continue;
              $img = wp_get_attachment_image_url( $prod->get_image_id(), 'woocommerce_thumbnail' ) ?: 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=400&q=80';
              ?>
              <a href="<?php echo esc_url( $prod->get_permalink() ); ?>" class="market-card reveal<?php echo esc_attr( $d[ $i % 4 ] ); ?>" style="text-decoration:none;color:inherit;">
                <div class="mimg"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $prod->get_name() ); ?>" loading="lazy"></div>
                <div class="mbody">
                  <span class="mbrand"><?php echo esc_html( $sdn_name ); ?></span>
                  <h4><?php echo esc_html( $prod->get_name() ); ?></h4>
                  <?php if ( $prod->get_price_html() ) : ?>
                    <span class="mprice-text"><?php echo $prod->get_price_html(); // phpcs:ignore ?></span>
                  <?php endif; ?>
                </div>
              </a>
              <?php
          }
          ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- WHY DROPSHIP THIS BRAND -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div class="center" style="max-width:760px;margin:0 auto 56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Why dropship <?php echo esc_html( $sdn_name ); ?>?</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">The catalog customers ask for.<br><span class="italic gradient-text">Without the inventory.</span></h2>
      </div>
      <div class="feat-grid">
        <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg></div><h4>Import in a few clicks</h4><p>Add <?php echo esc_html( $sdn_name ); ?> products to your store with one click. Automatic inventory sync, no warehouse.</p></div>
        <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg></div><h4>Blind dropshipping</h4><p>Every order ships under your brand with white-label packing slips. Your customer never sees the supplier.</p></div>
        <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time sync</h4><p>Inventory, price, and tracking updates flow into your store the instant they change.</p></div>
        <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div><h4>Wholesale or dropship</h4><p>Buy <?php echo esc_html( $sdn_name ); ?> at wholesale pricing to stock your shelves, or dropship with zero inventory.</p></div>
        <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg></div><h4>Automatic tracking sync</h4><p>Tracking numbers update across your store and your customer automatically as soon as orders ship.</p></div>
        <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l3-3 3 2 4-5"/></svg></div><h4>No transaction fees</h4><p>One flat plan fee. Keep your full margin on every <?php echo esc_html( $sdn_name ); ?> sale.</p></div>
      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
