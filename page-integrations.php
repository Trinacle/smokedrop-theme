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
$call          = home_url( '/call' );
?>

<main>
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Shopping Cart Integrations</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">Import 20,000+ products<br><span class="italic gradient-text">to your store.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Native apps for Shopify, WooCommerce, and BigCommerce, plus a full REST API for custom stacks. Connect once and your inventory, orders, and tracking stay in sync automatically.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Start Free Trial</a>
        <a href="<?php echo esc_url( $call ); ?>" class="btn btn-outline btn-lg">Talk to our team</a>
      </div>
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

  <!-- PER-PLATFORM RICH CARDS -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div class="center" style="margin-bottom:56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Built for your platform</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Every integration, <span class="italic gradient-text">all the features.</span></h2>
      </div>
      <div class="int-platforms">
        <?php foreach ( $sdn_platforms as $p ) : $d = ( $p['slug'] === 'api' ) ? ' reveal-d2' : ''; ?>
          <div class="int-platform reveal<?php echo esc_attr( $d ); ?>">
            <div class="int-platform-head">
              <span class="int-logo">
                <?php if ( ! empty( $p['logo'] ) ) : ?>
                  <img src="<?php echo esc_url( $p['logo'] ); ?>" alt="<?php echo esc_attr( $p['name'] ); ?>" onerror="this.style.display='none'">
                <?php else : ?>
                  <span class="int-logo-glyph">&lt;/&gt;</span>
                <?php endif; ?>
              </span>
              <div>
                <h3><?php echo esc_html( $p['name'] ); ?></h3>
                <p class="int-tag"><?php echo esc_html( $p['tagline'] ); ?></p>
              </div>
            </div>
            <p class="int-desc"><?php echo esc_html( $p['desc'] ); ?></p>
            <?php if ( ! empty( $p['features'] ) ) : ?>
              <ul class="int-feats">
                <?php foreach ( array_slice( $p['features'], 0, 4 ) as $f ) : ?>
                  <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span><strong><?php echo esc_html( $f[0] ); ?></strong> &mdash; <?php echo esc_html( $f[1] ); ?></span></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
            <div class="int-platform-actions">
              <?php if ( ! empty( $p['install_url'] ) ) : ?>
                <a href="<?php echo esc_url( $p['install_url'] ); ?>" class="btn btn-lime" target="_blank" rel="noopener"><?php echo esc_html( $p['install_label'] ); ?></a>
              <?php endif; ?>
              <a href="<?php echo esc_url( home_url( '/integrations/' . $p['slug'] . '/' ) ); ?>" class="link-arrow">Learn more <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
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
      <p class="lede reveal reveal-d2" style="max-width:580px;margin:20px auto 0;">No matter which platform you sell on, you get the same retailer-focused toolset &mdash; designed to grow your store without growing your workload.</p>
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
