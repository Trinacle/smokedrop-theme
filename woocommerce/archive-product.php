<?php
/**
 * The template for displaying the WooCommerce shop / product category archive.
 *
 * Bespoke SmokeDrop Noir marketplace: dark page hero, recent-products sidebar
 * with Shopify + WooCommerce plugin promo cards, and a product card grid using
 * WooCommerce's own loop (so pagination, ordering and result counts still work).
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$shopify_app  = 'https://apps.shopify.com/smoke-drop';
$woo_plugin   = home_url( '/download-smokedrop-plugin' );
$brands_url   = home_url( '/brands' );
?>

<main>
  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">The Marketplace</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">20,000+ smoke shop products.<br><span class="italic gradient-text">One integration.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Water pipes, vaporizers, CBD, glass and accessories from 300+ brands. Dropship or buy wholesale, with real-time inventory sync.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg">Start Free Trial</a>
        <a href="<?php echo esc_url( $brands_url ); ?>" class="btn btn-outline btn-lg">Browse brands</a>
      </div>
    </div>
  </section>

  <section class="sec">
    <div class="wrap">
      <div class="post-layout">

        <!-- MAIN: WooCommerce product loop -->
        <div class="post-content shop-loop-wrap reveal">
          <?php
          // Result count + ordering (WooCommerce's own hooks).
          woocommerce_result_count();
          woocommerce_catalog_ordering();

          if ( woocommerce_product_loop() ) {
              woocommerce_product_loop_start();
              while ( have_posts() ) {
                  the_post();
                  /**
                   * Render each product with our own card markup instead of
                   * WooCommerce's content-product.php, so it matches the design
                   * system (dark cards, brand eyebrow, hover lift).
                   */
                  global $product;
                  $product = wc_get_product( get_the_ID() );
                  if ( ! $product ) continue;

                  $brand_terms = get_the_terms( get_the_ID(), 'product_brand' );
                  $pbrand      = ( $brand_terms && ! is_wp_error( $brand_terms ) ) ? $brand_terms[0]->name : '';
                  ?>
                  <a href="<?php the_permalink(); ?>" class="market-card" style="text-decoration:none;color:inherit;">
                    <div class="mimg">
                      <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'woocommerce_thumbnail', array( 'loading' => 'lazy', 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                      <?php else : ?>
                        <img src="<?php echo esc_url( 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=400&q=80' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                      <?php endif; ?>
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
              echo '<p>No products found.</p>';
          }

          // Pagination.
          woocommerce_pagination();
          ?>
        </div>

        <!-- SIDEBAR -->
        <aside class="post-sidebar">
          <a href="<?php echo esc_url( $shopify_app ); ?>" class="shopify-cta" style="display:flex;">
            <svg viewBox="0 0 24 24" fill="#95bf47" width="24" height="24"><path d="M15.337 4.13a4.36 4.36 0 0 0-2.69 1.43 4.07 4.07 0 0 0-3.34-1.42c-2.41.12-3.96 2.13-3.96 4.4 0 4.04 3.86 7.04 5.95 8.34l.04.02.04-.02c2.09-1.3 5.95-4.3 5.95-8.34 0-2.27-1.55-4.28-3.96-4.4z"/></svg>
            <div><strong>Install on Shopify</strong><small>One-click from the App Store</small></div>
          </a>

          <a href="<?php echo esc_url( $woo_plugin ); ?>" class="shopify-cta" style="display:flex;">
            <svg viewBox="0 0 24 24" fill="#7f54b3" width="24" height="24"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h4a3 3 0 0 1 0 6h-1l3 4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <div><strong>Download WooCommerce Plugin</strong><small>Self-hosted WordPress stores</small></div>
          </a>

          <?php
          // Recent products block.
          $recent = wc_get_products( array(
              'status'  => 'publish',
              'limit'   => 5,
              'orderby' => 'date',
              'order'   => 'DESC',
          ) );
          if ( ! empty( $recent ) ) :
              ?>
              <div class="sidebar-block">
                <h5>Recent products</h5>
                <div class="related-list">
                  <?php foreach ( $recent as $r ) :
                      $rb = get_the_terms( $r->get_id(), 'product_brand' );
                      $rbname = ( $rb && ! is_wp_error( $rb ) ) ? $rb[0]->name : '';
                      ?>
                      <a href="<?php echo esc_url( $r->get_permalink() ); ?>" class="related-item">
                        <span class="ri-thumb"><?php echo $r->get_image( 'thumbnail', array( 'loading' => 'lazy' ), true ); // phpcs:ignore ?></span>
                        <span class="ri-title"><?php echo esc_html( $r->get_name() ); ?></span>
                      </a>
                  <?php endforeach; ?>
                </div>
              </div>
          <?php endif; ?>

          <div class="sidebar-block">
            <h5>Browse by brand</h5>
            <a href="<?php echo esc_url( $brands_url ); ?>" class="btn btn-outline btn-block" style="margin-top:8px;">All 300+ brands</a>
          </div>
        </aside>

      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
