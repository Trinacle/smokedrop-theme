<?php
/**
 * Template Name: Brands We Carry
 * Template Post Type: page
 *
 * Dynamic showcase of the brands on the SmokeDrop marketplace. Assign
 * this template to the WordPress Page mapped to /brands/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url = home_url( '/suppliers' );
$sdn_brands = sdn_real_brand_logos();

$row_a = array_slice( $sdn_brands, 0, 6 );
$row_b = array_slice( $sdn_brands, 6, 5 );
$row_c = array_slice( $sdn_brands, 11 );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Brands We Carry</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">300+ brands.<br><span class="italic gradient-text">One integration.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">The deepest smoke, vape &amp; hemp catalog in the industry &mdash; the brands your customers already ask for, ready to dropship or buy wholesale.</p>
      </div>
    </section>

    <!-- MULTI-ROW LOGO MARQUEE -->
    <section class="logo-wall-white reveal">
      <div class="lw-wall">
        <div class="lw-row">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_a as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
        <div class="lw-row rev" style="margin-top:40px;">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_b as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
        <div class="lw-row" style="margin-top:40px;">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_c as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
      </div>
    </section>

    <!-- BRAND GRID -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Featured brands</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">A few of the 300+ brands<br>on the marketplace.</h2>
        </div>
        <div class="brand-grid reveal reveal-d2">
          <?php foreach ( $sdn_brands as $b ) : ?>
            <div class="brand-card" id="brand-<?php echo esc_attr( $b['slug'] ); ?>">
              <img src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="sec-sm">
      <div class="wrap">
        <div class="cta-bg reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));">
          <div class="inner">
            <h2 class="display" style="color:#fff;">Don't see your brand?</h2>
            <p class="lede">Suppliers and brands can join the marketplace and reach hundreds of retailers &mdash; from $49.99/mo, no transaction fees.</p>
            <div class="hero-actions">
              <a href="<?php echo esc_url( $supply_url ); ?>" class="btn btn-lime btn-lg">Become a Wholesaler</a>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
