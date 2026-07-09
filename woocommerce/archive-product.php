<?php
/**
 * The template for displaying the WooCommerce shop / product category archive.
 *
 * Bespoke SmokeDrop Noir marketplace: dark hero, product card grid on WC's
 * native loop (so pagination/ordering/filters work), with a sidebar of
 * platform promo cards and recent products.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$shopify_app = 'https://apps.shopify.com/smoke-drop';
$woo_plugin  = home_url( '/download-smokedrop-plugin' );
$brands_url  = home_url( '/brands' );
$register    = 'https://wholesale.thesmokedrop.com/register';
// Top 10 high-value brands from the directory (ranked by 'value').
$sdn_dir_brands = function_exists( 'sdn_brand_directory' ) ? sdn_brand_directory() : array();
$sdn_top_brands = array();
foreach ( $sdn_dir_brands as $b ) {
    if ( isset( $b['value'] ) && $b['value'] >= 8 ) $sdn_top_brands[] = $b;
}
$sdn_top_brands = array_slice( $sdn_top_brands, 0, 10 );
?>

<main>
  <!-- HERO -->
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">The Marketplace</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">Featured New Products<br><span class="italic gradient-text">&amp; Brands.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:680px;margin:0 auto;">A curated selection of products from our top brands. <strong>Create a free account</strong> to unlock the full marketplace &mdash; 20,000+ products across 300+ brands.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Create Free Account</a>
        <a href="<?php echo esc_url( $brands_url ); ?>" class="btn btn-outline btn-lg">Browse all brands</a>
      </div>
    </div>
  </section>

  <section class="sec shop-sec">
    <div class="wrap">
      <div class="shop-layout">

        <!-- SIDEBAR: top brands + create account CTA -->
        <aside class="shop-sidebar reveal">
          <div class="shop-filter-block">
            <h5>Top Brands</h5>
            <ul class="shop-filter-list brand-list">
              <?php foreach ( $sdn_top_brands as $b ) :
                  $slug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
                  ?>
                  <li><a href="<?php echo esc_url( home_url( '/brand/' . $slug . '/' ) ); ?>"><?php echo esc_html( $b['name'] ); ?></a></li>
              <?php endforeach; ?>
            </ul>
            <a href="<?php echo esc_url( $brands_url ); ?>" class="filter-more">View all 300+ brands &rarr;</a>
          </div>

          <!-- Create account CTA -->
          <div class="shop-account-cta">
            <h5>Unlock the full catalog</h5>
            <p>Create a free account to see every brand and product on the marketplace.</p>
            <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime" style="width:100%;text-align:center;box-sizing:border-box;">Create Free Account</a>
          </div>

          <a href="<?php echo esc_url( $shopify_app ); ?>" class="shopify-cta" style="display:flex;">
            <svg viewBox="0 0 24 24" fill="#95bf47" width="22" height="22"><path d="M15.337 4.13a4.36 4.36 0 0 0-2.69 1.43 4.07 4.07 0 0 0-3.34-1.42c-2.41.12-3.96 2.13-3.96 4.4 0 4.04 3.86 7.04 5.95 8.34l.04.02.04-.02c2.09-1.3 5.95-4.3 5.95-8.34 0-2.27-1.55-4.28-3.96-4.4z"/></svg>
            <div><strong>Install on Shopify</strong><small>One-click from App Store</small></div>
          </a>

          <a href="<?php echo esc_url( $woo_plugin ); ?>" class="shopify-cta" style="display:flex;">
            <svg viewBox="0 0 24 24" fill="#7f54b3" width="22" height="22"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h4a3 3 0 0 1 0 6h-1l3 4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div><strong>WooCommerce Plugin</strong><small>Self-hosted WordPress</small></div>
          </a>
        </aside>

        <!-- MAIN: product grid -->
        <div class="shop-main">
          <div class="shop-toolbar reveal">
            <?php woocommerce_result_count(); ?>
            <?php woocommerce_catalog_ordering(); ?>
          </div>

          <?php
          if ( woocommerce_product_loop() ) {
              woocommerce_product_loop_start();
              while ( have_posts() ) {
                  the_post();
                  global $product;
                  $product = wc_get_product( get_the_ID() );
                  if ( ! $product ) continue;

                  $brand_terms_p = get_the_terms( get_the_ID(), 'product_brand' );
                  $pbrand = ( $brand_terms_p && ! is_wp_error( $brand_terms_p ) ) ? $brand_terms_p[0]->name : '';
                  ?>
                  <a href="<?php the_permalink(); ?>" class="market-card shop-card" style="text-decoration:none;color:inherit;">
                    <div class="mimg">
                      <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                      <?php else : ?>
                        <img src="<?php echo esc_url( 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=400&q=80' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <?php endif; ?>
                      <?php if ( ! $product->is_in_stock() ) : ?><span class="mstock-out">Sold out</span><?php endif; ?>
                    </div>
                    <div class="mbody">
                      <?php if ( $pbrand ) : ?><span class="mbrand"><?php echo esc_html( $pbrand ); ?></span><?php endif; ?>
                      <h4><?php the_title(); ?></h4>
                      <?php if ( $product->get_price_html() ) : ?>
                        <div class="mprice-row"><div class="mprice"><div class="lbl">Price</div><div class="val"><?php echo $product->get_price_html(); // phpcs:ignore ?></div></div></div>
                      <?php endif; ?>
                      <span class="add">View details <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                    </div>
                  </a>
                  <?php
              }
              woocommerce_product_loop_end();
          } else {
              echo '<div class="shop-empty"><p>No products found.</p><a href="' . esc_url( $register ) . '" class="btn btn-lime">Start dropshipping</a></div>';
          }

          woocommerce_pagination();
          ?>
        </div>

      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
