<?php
/**
 * Template Name: Sitemap
 * Template Post Type: page
 *
 * Human-readable HTML sitemap. Assign this template to the WordPress
 * Page mapped to /sitemap/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$sdn_sitemap = array(
    'Platform' => array(
        'Home'          => home_url( '/' ),
        'Pricing'       => home_url( '/pricing' ),
        'For Retailers' => home_url( '/retailers' ),
        'For Wholesalers' => home_url( '/suppliers' ),
        'Brands We Carry' => home_url( '/brands' ),
    ),
    'Resources' => array(
        'Blog'          => get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/dropshipping-blog' ),
        'Help Center'   => home_url( '/help' ),
        'Get a Demo'    => home_url( '/demo' ),
        'Schedule Call' => home_url( '/call' ),
        'Contact'       => home_url( '/contact' ),
        'About'         => home_url( '/about' ),
    ),
    'Legal' => array(
        'Privacy Policy'            => home_url( '/privacy-policy' ),
        'Terms of Use'              => home_url( '/terms-of-use' ),
        'Retailer Agreement'        => home_url( '/retailer-terms-of-use-agreement' ),
        'Supplier Agreement'        => home_url( '/terms-of-use-for-suppliers' ),
    ),
);
?>

<main>
    <section class="page-hero" style="min-height:auto;padding-bottom:60px;">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Sitemap</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Find your way<br><span class="italic gradient-text">around SmokeDrop.</span></h1>
      </div>
    </section>

    <section class="sec" style="padding-top:0;">
      <div class="wrap wrap-tight">
        <div class="sitemap-grid reveal">
          <?php foreach ( $sdn_sitemap as $sdn_group => $sdn_links ) : ?>
            <div class="foot-col">
              <h5><?php echo esc_html( $sdn_group ); ?></h5>
              <?php foreach ( $sdn_links as $sdn_label => $sdn_url ) : ?>
                <a href="<?php echo esc_url( $sdn_url ); ?>"><?php echo esc_html( $sdn_label ); ?></a>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
