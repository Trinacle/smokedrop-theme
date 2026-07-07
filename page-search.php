<?php
/**
 * Template Name: Search Results
 * Template Post Type: page
 *
 * Bespoke search results page for product + brand searches. Reads the ?s=
 * query param, queries WooCommerce products (title + content match) and
 * brand CPT posts, then renders themed result cards.
 *
 * Assign to the WordPress Page at /search/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$sdn_query = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
$sdn_q     = trim( $sdn_query );

// Product results (WooCommerce).
$sdn_products = array();
if ( $sdn_q && class_exists( 'WooCommerce' ) ) {
    $sdn_products = wc_get_products( array(
        'status'  => 'publish',
        'limit'   => 24,
        's'       => $sdn_q,
        'orderby' => 'relevance',
    ) );
}

// Brand results (brand CPT + directory array).
$sdn_brands = array();
if ( $sdn_q ) {
    $sdn_brand_posts = get_posts( array(
        'post_type'      => 'brand',
        'posts_per_page' => 8,
        's'              => $sdn_q,
        'post_status'    => 'publish',
    ) );
    foreach ( $sdn_brand_posts as $bp ) {
        $sdn_brands[] = array(
            'name' => get_the_title( $bp ),
            'slug' => $bp->post_name,
        );
    }
    // Also match the directory array (catches brands without a matching CPT post).
    if ( function_exists( 'sdn_brand_directory' ) ) {
        foreach ( sdn_brand_directory() as $b ) {
            if ( count( $sdn_brands ) >= 8 ) break;
            if ( stripos( $b['name'], $sdn_q ) !== false ) {
                $exists = false;
                foreach ( $sdn_brands as $eb ) {
                    if ( $eb['slug'] === $b['slug'] ) { $exists = true; break; }
                }
                if ( ! $exists ) $sdn_brands[] = $b;
            }
        }
    }
}

$sdn_total = count( $sdn_products ) + count( $sdn_brands );
$register  = 'https://wholesale.thesmokedrop.com/register';
?>

<main>
  <section class="sec" style="padding-top:120px;">
    <div class="wrap">

      <!-- SEARCH HEADER -->
      <div class="search-head">
        <p class="eyebrow reveal">Search</p>
        <h1 class="h-sec reveal reveal-d1" style="margin-top:14px;">
          <?php if ( $sdn_q ) : ?>
            Results for &ldquo;<?php echo esc_html( $sdn_q ); ?>&rdquo;
          <?php else : ?>
            Search the marketplace
          <?php endif; ?>
        </h1>
        <?php if ( $sdn_q ) : ?>
          <p class="reveal reveal-d2" style="color:var(--ink-mute);margin-top:8px;"><?php echo (int) $sdn_total; ?> result<?php echo $sdn_total === 1 ? '' : 's'; ?></p>
        <?php endif; ?>

        <form role="search" method="get" action="<?php echo esc_url( home_url( '/marketplace-search' ) ); ?>" class="search-page-form reveal reveal-d2">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="search" name="s" value="<?php echo esc_attr( $sdn_q ); ?>" placeholder="Search products, brands, categories…" autocomplete="off">
          <button type="submit" class="btn btn-lime">Search</button>
        </form>
      </div>

      <?php if ( $sdn_q && $sdn_total === 0 ) : ?>
        <!-- NO RESULTS -->
        <div class="search-empty reveal">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width:48px;height:48px;color:var(--ink-mute);margin:0 auto 20px;display:block;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <h2>No results for &ldquo;<?php echo esc_html( $sdn_q ); ?>&rdquo;</h2>
          <p style="color:var(--ink-mute);margin:12px 0 24px;">Try a different keyword, or browse the full marketplace.</p>
          <div class="hero-actions" style="justify-content:center;">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/marketplace' ) ); ?>" class="btn btn-lime btn-lg">Browse all products</a>
            <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>" class="btn btn-outline btn-lg">Browse brands</a>
          </div>
        </div>

      <?php else : ?>

        <!-- BRAND RESULTS -->
        <?php if ( ! empty( $sdn_brands ) ) : ?>
          <div class="search-section reveal">
            <h2 class="search-section-head">Brands <span>(<?php echo (int) count( $sdn_brands ); ?>)</span></h2>
            <div class="brand-grid">
              <?php foreach ( $sdn_brands as $b ) :
                  $slug = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $b['name'] );
                  $logo = ! empty( $b['logo'] ) ? home_url( '/wp-content/uploads/' . $b['logo'] ) : '';
                  $init = isset( $b['initials'] ) ? $b['initials'] : strtoupper( substr( $b['name'], 0, 2 ) );
                  ?>
                <a href="<?php echo esc_url( home_url( '/brand/' . $slug . '/' ) ); ?>" class="brand-card">
                  <?php if ( $logo ) : ?>
                    <img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy">
                  <?php else : ?>
                    <span class="brand-card-fallback"><?php echo esc_html( $init ); ?></span>
                  <?php endif; ?>
                  <span class="brand-card-name"><?php echo esc_html( $b['name'] ); ?></span>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <!-- PRODUCT RESULTS -->
        <?php if ( ! empty( $sdn_products ) ) : ?>
          <div class="search-section reveal">
            <h2 class="search-section-head">Products <span>(<?php echo (int) count( $sdn_products ); ?>)</span></h2>
            <div class="market">
              <?php
              $d = array( '', ' reveal-d1', ' reveal-d2', ' reveal-d3' );
              foreach ( $sdn_products as $i => $prod ) :
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
        <?php endif; ?>

      <?php endif; ?>

      <!-- CTA -->
      <?php if ( $sdn_total > 0 ) sdn_cta(); ?>

    </div>
  </section>
</main>

<?php
get_footer();
