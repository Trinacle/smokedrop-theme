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
$sdn_slug      = '';
$sdn_name      = '';
$sdn_logo_url  = '';
$sdn_desc      = '';
$sdn_register  = 'https://wholesale.thesmokedrop.com/register';
$sdn_brands_pg = home_url( '/brands' );

if ( have_posts() ) {
    the_post();
    if ( get_post_type() === 'brand' ) {
        // Real CPT post.
        $sdn_is_cpt   = true;
        $sdn_slug     = get_post_field( 'post_name', get_the_ID() );
        $sdn_name     = get_the_title();
        $sdn_logo_url = sdn_brand_logo_url( get_the_ID() );
        $sdn_desc     = apply_filters( 'the_content', get_the_content() );
    }
}

// Fall back to virtual brand data from the directory array.
if ( ! $sdn_name ) {
    // Virtual brands arrive via the sdn_brand_slug query var (set by the
    // rewrite rule in cpt-brands.php). Real CPT posts arrive via have_posts().
    $requested = get_query_var( 'sdn_brand_slug' );
    if ( ! $requested && isset( $GLOBALS['wp']->query_vars['name'] ) ) {
        $requested = $GLOBALS['wp']->query_vars['name'];
    }
    if ( ! $requested && isset( $GLOBALS['wp']->query_vars['brand'] ) ) {
        $requested = $GLOBALS['wp']->query_vars['brand'];
    }
    foreach ( sdn_brand_directory() as $b ) {
        $bslug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
        if ( $bslug === $requested ) {
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

get_header();
?>

<main>
  <!-- BRAND HERO -->
  <section class="brand-hero">
    <div class="wrap brand-hero-inner">
      <div class="brand-hero-logo reveal">
        <?php if ( $sdn_logo_url ) : ?>
          <img src="<?php echo esc_url( $sdn_logo_url ); ?>" alt="<?php echo esc_attr( $sdn_name ); ?>">
        <?php else : ?>
          <span class="brand-hero-mark"><?php echo esc_html( strtoupper( substr( $sdn_name, 0, 2 ) ) ); ?></span>
        <?php endif; ?>
      </div>
      <div class="brand-hero-text reveal reveal-d1">
        <p class="eyebrow">Brand on the SmokeDrop marketplace</p>
        <h1 class="display"><?php echo esc_html( $sdn_name ); ?></h1>
        <?php if ( $sdn_desc ) : ?>
          <div class="brand-hero-desc"><?php echo $sdn_desc; // phpcs:ignore ?></div>
        <?php else : ?>
          <p class="lede"><?php echo esc_html( $sdn_name ); ?> products are available for dropship and wholesale on SmokeDrop. Import to your store in a few clicks, with automatic inventory sync and blind dropshipping.</p>
        <?php endif; ?>
        <div class="hero-actions">
          <a href="<?php echo esc_url( $sdn_register ); ?>" class="btn btn-lime btn-lg">Dropship <?php echo esc_html( $sdn_name ); ?> products</a>
          <a href="<?php echo esc_url( $sdn_brands_pg ); ?>" class="btn btn-outline btn-lg">All brands</a>
        </div>
      </div>
    </div>
  </section>

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
        <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg></div><h4>Blind dropshipping</h4><p>Ships under your brand within 24 hours. Your customer never sees our name.</p></div>
        <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time sync</h4><p>Inventory, price, and tracking updates flow into your store the instant they change.</p></div>
      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
