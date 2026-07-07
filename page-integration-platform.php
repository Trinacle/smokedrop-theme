<?php
/**
 * Template Name: Integration Platform
 * Template Post Type: page
 *
 * Reusable per-platform detail page. Detects the platform from the WP page
 * slug (shopify / woocommerce / bigcommerce / api) and loads its data from
 * sdn_platforms(). Renders a hero, features grid, 3-step setup, and
 * cross-links to the other platforms.
 *
 * Assign to WP Pages with slugs matching the platform key, nested under
 * /integrations/ — e.g. /integrations/shopify/, /integrations/woocommerce/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Resolve the platform from the page slug.
$sdn_slug      = get_post_field( 'post_name', get_the_ID() );
$sdn_platforms = sdn_platforms();
$sdn_p         = isset( $sdn_platforms[ $sdn_slug ] ) ? $sdn_platforms[ $sdn_slug ] : null;

// If the slug doesn't match a known platform, fall back to shopify.
if ( ! $sdn_p ) {
    $sdn_p = $sdn_platforms['shopify'];
}

// Other platforms for the cross-link row.
$sdn_others = array();
foreach ( $sdn_platforms as $key => $op ) {
    if ( $key !== $sdn_p['slug'] ) $sdn_others[] = $key;
}
$check_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>

<main>
  <!-- HERO -->
  <section class="brand-hero" style="padding-top:140px;">
    <div class="wrap brand-hero-inner">
      <div class="brand-hero-logo reveal" style="background:#fff;">
        <?php if ( ! empty( $sdn_p['logo'] ) ) : ?>
          <img src="<?php echo esc_url( $sdn_p['logo'] ); ?>" alt="<?php echo esc_attr( $sdn_p['name'] ); ?>" onerror="this.style.display='none'">
        <?php else : ?>
          <span class="brand-hero-mark">&lt;/&gt;</span>
        <?php endif; ?>
      </div>
      <div class="brand-hero-text reveal reveal-d1">
        <p class="eyebrow">SmokeDrop integration</p>
        <h1 class="display"><?php echo esc_html( $sdn_p['name'] ); ?></h1>
        <p class="lede"><?php echo esc_html( $sdn_p['tagline'] ); ?></p>
        <p class="brand-hero-desc"><?php echo esc_html( $sdn_p['desc'] ); ?></p>
        <div class="hero-actions">
          <a href="<?php echo esc_url( $sdn_p['install_url'] ); ?>" class="btn btn-lime btn-lg"><?php echo esc_html( $sdn_p['install_label'] ); ?></a>
          <a href="<?php echo esc_url( home_url( '/integrations' ) ); ?>" class="btn btn-outline btn-lg">All integrations</a>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="sec">
    <div class="wrap">
      <div class="center" style="max-width:760px;margin:0 auto 56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Why <?php echo esc_html( $sdn_p['name'] ); ?>?</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Everything you need<br><span class="italic gradient-text">to start selling.</span></h2>
      </div>
      <div class="feat-grid">
        <?php foreach ( $sdn_p['features'] as $i => $f ) : ?>
          <div class="feat-card reveal<?php echo $i % 3 === 1 ? ' reveal-d1' : ''; ?><?php echo $i % 3 === 2 ? ' reveal-d2' : ''; ?>">
            <div class="fc-ico" <?php echo ! empty( $sdn_p['color'] ) ? 'style="color:' . esc_attr( $sdn_p['color'] ) . ';"' : ''; ?>><?php echo $check_svg; // phpcs:ignore ?></div>
            <h4><?php echo esc_html( $f[0] ); ?></h4>
            <p><?php echo esc_html( $f[1] ); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- 3-STEP SETUP -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div style="max-width:780px;margin-bottom:56px;">
        <p class="eyebrow reveal">Getting started</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Live in <span class="italic gradient-text">three steps.</span></h2>
      </div>
      <div class="getting-started">
        <?php foreach ( $sdn_p['steps'] as $i => $s ) : ?>
          <div class="gs-card reveal<?php echo $i === 1 ? ' reveal-d1' : ''; ?><?php echo $i === 2 ? ' reveal-d2' : ''; ?>">
            <span class="gs-num">0<?php echo (int) $i + 1; ?></span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></div>
            <h4><?php echo esc_html( $s[0] ); ?></h4>
            <p><?php echo esc_html( $s[1] ); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="center reveal reveal-d3" style="margin-top:48px;">
        <a href="<?php echo esc_url( $sdn_p['install_url'] ); ?>" class="btn btn-lime btn-lg"><?php echo esc_html( $sdn_p['install_label'] ); ?> <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </div>
  </section>

  <!-- OTHER INTEGRATIONS -->
  <section class="sec">
    <div class="wrap center">
      <p class="eyebrow reveal" style="justify-content:center;">Other integrations</p>
      <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;margin-bottom:40px;">Explore more platforms</h2>
      <div class="reveal reveal-d2">
        <?php sdn_integration_bubbles( $sdn_others ); ?>
      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
