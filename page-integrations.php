<?php
/**
 * Template Name: Integrations
 * Template Post Type: page
 *
 * Hub page for all SmokeDrop shopping-cart integrations. Shows the 4 platform
 * bubbles (Shopify, WooCommerce, BigCommerce, Custom API), each linking to its
 * own detail page at /integrations/{platform}/.
 *
 * Assign to the WordPress Page at /integrations/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$sdn_platforms = sdn_platforms();
$register      = 'https://wholesale.thesmokedrop.com/register';
?>

<main>
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Shopping Cart Integrations</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">Import 20,000+ products<br><span class="italic gradient-text">to your store.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Native apps for Shopify, WooCommerce, and BigCommerce, plus a full REST API for custom stacks. One integration, every platform.</p>
    </div>
  </section>

  <!-- PLATFORM BUBBLES -->
  <section class="sec">
    <div class="wrap center">
      <div class="reveal reveal-d1" style="margin-bottom:16px;">
        <?php sdn_integration_bubbles(); ?>
      </div>
      <p class="reveal reveal-d2" style="color:var(--ink-mute);font-size:.9rem;margin-top:32px;">Click a platform to see setup steps, features, and install links.</p>
    </div>
  </section>

  <!-- PER-PLATFORM VALUE PROPS -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div class="center" style="margin-bottom:56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Why integrate</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">One platform. <span class="italic gradient-text">Every workflow.</span></h2>
      </div>
      <div class="feat-grid">
        <?php foreach ( $sdn_platforms as $p ) : ?>
          <div class="feat-card reveal">
            <div class="fc-ico">
              <?php if ( ! empty( $p['logo'] ) ) : ?>
                <img src="<?php echo esc_url( $p['logo'] ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" style="width:32px;height:32px;object-fit:contain;" onerror="this.style.display='none'">
              <?php else : ?>
                <span style="font-family:var(--display);font-weight:700;color:var(--green-xl);">&lt;/&gt;</span>
              <?php endif; ?>
            </div>
            <h4><?php echo esc_html( $p['name'] ); ?></h4>
            <p><?php echo esc_html( $p['tagline'] ); ?></p>
            <a href="<?php echo esc_url( home_url( '/integrations/' . $p['slug'] . '/' ) ); ?>" class="link-arrow" style="margin-top:14px;font-size:.85rem;">Learn more <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- UNIFIED BENEFITS -->
  <section class="sec">
    <div class="wrap wrap-tight center">
      <p class="eyebrow reveal" style="justify-content:center;">Every integration includes</p>
      <h2 class="display reveal reveal-d1" style="margin-top:24px;">Real-time sync.<br><span class="italic gradient-text">Automatic fulfillment.</span></h2>
      <div class="bento-tag-row reveal reveal-d2" style="justify-content:center;margin-top:40px;">
        <span class="bento-tag">&#10003; Real-time inventory sync</span>
        <span class="bento-tag">&#10003; Automatic order routing</span>
        <span class="bento-tag">&#10003; Tracking sync</span>
        <span class="bento-tag">&#10003; Blind dropshipping</span>
        <span class="bento-tag">&#10003; 300+ brands</span>
        <span class="bento-tag">&#10003; No transaction fees</span>
      </div>
      <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg reveal reveal-d3" style="margin-top:40px;">Start Free Trial</a>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
