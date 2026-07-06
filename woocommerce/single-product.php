<?php
/**
 * The template for displaying a single WooCommerce product.
 *
 * Bespoke SmokeDrop Noir product page — 2-col gallery + info,
 * dropship/wholesale actions, specs, related products, retailer sell section.
 * Replaces WooCommerce's default single-product template entirely while still
 * firing the core summary hooks (so the cart form + add-to-cart still work).
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

while ( have_posts() ) :
    the_post();
    $product = wc_get_product( get_the_ID() );
    if ( ! $product ) {
        break;
    }

    // Brand name from the WooCommerce product_brand taxonomy (graceful fallback).
    $brand_terms = get_the_terms( get_the_ID(), 'product_brand' );
    $brand_name  = ( $brand_terms && ! is_wp_error( $brand_terms ) ) ? $brand_terms[0]->name : '';

    // Categories (version-safe: get_the_terms instead of the removed wc_get_product_cat_list).
    $cat_terms = get_the_terms( get_the_ID(), 'product_cat' );
    $cat_names = ( $cat_terms && ! is_wp_error( $cat_terms ) )
        ? implode( ', ', wp_list_pluck( $cat_terms, 'name' ) )
        : '';

    $gallery_ids = $product->get_gallery_image_ids();
    $short_desc  = $product->get_short_description() ?: wp_trim_words( wp_strip_all_tags( $product->get_description() ), 28 );
    $register    = 'https://wholesale.thesmokedrop.com/register';
    $sku         = $product->get_sku();
    $weight      = $product->get_weight();
    ?>

    <main>
      <!-- PRODUCT SECTION -->
      <section class="sec" style="padding-top:120px;">
        <div class="wrap">
          <div class="product-layout">

            <!-- GALLERY -->
            <div class="product-gallery reveal">
              <div class="main-img">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                <?php else : ?>
                  <img src="<?php echo esc_url( 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=800&q=80' ); ?>" alt="<?php the_title_attribute(); ?>">
                <?php endif; ?>
              </div>
              <?php if ( ! empty( $gallery_ids ) ) : ?>
                <div class="thumbs">
                  <?php
                  $shown = 0;
                  foreach ( $gallery_ids as $gid ) {
                      if ( $shown >= 4 ) break;
                      echo wp_get_attachment_image( $gid, 'medium', false, array( 'loading' => 'lazy' ) );
                      $shown++;
                  }
                  ?>
                </div>
              <?php endif; ?>
            </div>

            <!-- INFO -->
            <div class="product-info reveal reveal-d1">
              <?php if ( $brand_name ) : ?>
                <span class="p-brand"><?php echo esc_html( $brand_name ); ?></span>
              <?php endif; ?>
              <h1 class="entry-title"><?php the_title(); ?></h1>

              <?php if ( $short_desc ) : ?>
                <div class="p-desc"><?php echo wp_kses_post( wpautop( $short_desc ) ); ?></div>
              <?php endif; ?>

              <?php if ( $product->get_price_html() ) : ?>
                <p class="p-price"><?php echo $product->get_price_html(); // phpcs:ignore ?></p>
              <?php endif; ?>

              <!-- Core WooCommerce summary: variation forms, add-to-cart, etc. -->
              <div class="woo-summary">
                <?php woocommerce_template_single_add_to_cart(); ?>
              </div>

              <!-- Dropship + Wholesale CTAs -->
              <div class="action-buttons">
                <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lg btn-dropship">Dropship this product</a>
                <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lg btn-wholesale">Buy wholesale</a>
              </div>

              <!-- Specs -->
              <table class="spec-table">
                <?php if ( $brand_name ) : ?><tr><td>Brand</td><td><?php echo esc_html( $brand_name ); ?></td></tr><?php endif; ?>
                <?php if ( $cat_names ) : ?><tr><td>Category</td><td><?php echo esc_html( $cat_names ); ?></td></tr><?php endif; ?>
                <?php if ( $sku ) : ?><tr><td>SKU</td><td><?php echo esc_html( $sku ); ?></td></tr><?php endif; ?>
                <?php if ( $weight ) : ?><tr><td>Weight</td><td><?php echo esc_html( $weight . ' ' . get_option( 'woocommerce_weight_unit' ) ); ?></td></tr><?php endif; ?>
                <tr><td>Availability</td><td><?php echo $product->is_in_stock() ? 'In stock' : 'Out of stock'; ?></td></tr>
              </table>

              <!-- Features -->
              <div class="feature-list">
                <div class="fl-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg><div><strong>Dropship or buy wholesale</strong><span>Import to your store with zero inventory, or stock up at wholesale pricing.</span></div></div>
                <div class="fl-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg><div><strong>Automatic order sync</strong><span>Orders sync with suppliers automatically. Tracking numbers update across everyone.</span></div></div>
                <div class="fl-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg><div><strong>Blind dropshipping</strong><span>Ships under your brand within 24 hours. Your customer never sees our name.</span></div></div>
              </div>
            </div>

          </div>
        </div>
      </section>

      <?php
      // More from this brand — query related products in the same brand term.
      if ( $brand_name && $brand_terms ) {
          $related = wc_get_products( array(
              'status'         => 'publish',
              'limit'          => 4,
              'orderby'        => 'rand',
              'exclude'        => array( get_the_ID() ),
              'product_brand' => $brand_terms[0]->slug,
          ) );

          if ( ! empty( $related ) ) {
              ?>
              <section class="sec" style="background:var(--bg-2);">
                <div class="wrap">
                  <h2 class="h-sec reveal" style="font-size:clamp(1.6rem,3vw,2.4rem);margin-bottom:32px;">More from <?php echo esc_html( $brand_name ); ?></h2>
                  <div class="related-grid">
                    <?php
                    $d = array( '', ' reveal-d1', ' reveal-d2', ' reveal-d3' );
                    foreach ( $related as $i => $rel ) {
                        $rel_brand = '';
                        $rb = get_the_terms( $rel->get_id(), 'product_brand' );
                        if ( $rb && ! is_wp_error( $rb ) ) $rel_brand = $rb[0]->name;
                        ?>
                        <a href="<?php echo esc_url( $rel->get_permalink() ); ?>" class="related-card reveal<?php echo esc_attr( $d[ $i % 4 ] ); ?>">
                          <?php echo $rel->get_image( 'medium', array( 'loading' => 'lazy' ), true ); // phpcs:ignore ?>
                          <div class="rc-body">
                            <?php if ( $rel_brand ) : ?><span class="rc-brand"><?php echo esc_html( $rel_brand ); ?></span><?php endif; ?>
                            <h4><?php echo esc_html( $rel->get_name() ); ?></h4>
                          </div>
                        </a>
                        <?php
                    }
                    ?>
                  </div>
                </div>
              </section>
              <?php
          }
      }
      ?>

      <!-- RETAILER SELL: Why dropship with SmokeDrop -->
      <section class="sec">
        <div class="wrap">
          <div class="center" style="max-width:760px;margin:0 auto 56px;">
            <p class="eyebrow reveal" style="justify-content:center;">Sell this product with zero inventory</p>
            <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Add this to your store<br>in <span class="italic gradient-text">a few clicks.</span></h2>
          </div>
          <div class="feat-grid">
            <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg></div><h4>Import in a few clicks</h4><p>Add this product and 20,000+ more to your online store in just a few clicks.</p></div>
            <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Automatic order sync</h4><p>Automatic order syncing with suppliers. Tracking numbers sync across everyone.</p></div>
            <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div><h4>Shopify, WooCommerce &amp; BigCommerce</h4><p>Native apps for the platforms you already use. One-click install.</p></div>
          </div>
        </div>
      </section>

      <?php sdn_cta(); ?>
    </main>

    <?php
endwhile;

get_footer();
