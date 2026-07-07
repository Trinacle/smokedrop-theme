<?php
/**
 * Template Name: For Wholesalers
 * Template Post Type: page
 *
 * B2B wholesale-buyer landing page — for smoke shops stocking local
 * inventory at wholesale pricing. Distinct from /suppliers (the
 * dropship supplier page). Assign to the Page mapped to /wholesalers/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$register   = 'https://wholesale.thesmokedrop.com/register';
$brands_url = home_url( '/brands' );
$contact_url = home_url( '/contact' );
$pricing_url = home_url( '/pricing' );
$check_svg  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>

<main>
  <section class="hero" style="min-height:auto;padding-top:180px;padding-bottom:40px;">
    <div class="hero-inner">
      <p class="eyebrow reveal">For Wholesalers</p>
      <h1 class="display-mega reveal reveal-d1" style="margin:24px 0;font-size:clamp(2.6rem,8vw,7rem);">
        <span class="line-mask"><span>Buy wholesale.</span></span>
        <span class="line-mask line-mask-d1"><span>Stock your <em class="italic gradient-text">shelves.</em></span></span>
      </h1>
      <p class="lede reveal reveal-d3" style="max-width:620px;">Purchase products at wholesale prices with <strong style="color:var(--ink);">no minimum order amount.</strong> Stock your smoke shop, vape store, or dispensary with 20,000+ products from 300+ brands &mdash; order exactly what you need, when you need it.</p>
      <div class="hero-actions reveal reveal-d4">
        <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg" data-magnetic>Start buying wholesale</a>
        <a href="<?php echo esc_url( $brands_url ); ?>" class="btn btn-outline btn-lg" data-magnetic>Browse the catalog</a>
      </div>
    </div>
  </section>

  <!-- TRUST BAR -->
  <div class="trust-bar reveal">
    <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg><div><strong>No minimums</strong><span>Order what you need</span></div></div>
    <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg><div><strong>Wholesale pricing</strong><span>Transparent margins</span></div></div>
    <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg><div><strong>300+ brands</strong><span>20,000+ products</span></div></div>
    <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg><div><strong>Fast shipping</strong><span>USA-based fulfillment</span></div></div>
  </div>

  <!-- BENEFITS -->
  <section class="sec">
    <div class="wrap">
      <div style="max-width:780px;margin-bottom:64px;">
        <p class="eyebrow reveal">Why wholesalers buy on SmokeDrop</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Wholesale pricing,<br><span class="italic gradient-text">no minimum order.</span></h2>
      </div>
      <div class="bento">
        <div class="bento-cell wide emerald reveal">
          <div class="inner"><p class="bento-eyebrow">No minimum order amount</p><h3>Buy one case or a pallet.</h3><p>Order exactly what your shelves need &mdash; no forced case-quantity minimums. Wholesale pricing applies from the first unit.</p></div>
        </div>
        <div class="bento-cell lime reveal reveal-d1">
          <div class="inner"><p class="bento-eyebrow">Transparent margins</p><h3>See wholesale cost upfront.</h3><p>Cost and suggested retail shown before you buy. Your markup, your call.</p></div>
        </div>
        <div class="bento-cell dark reveal">
          <div class="inner"><p class="bento-eyebrow">300+ brands</p><h3>The catalog customers ask for.</h3><p>PAX, Puffco, Cookies, GRAV, RAW, Dr. Dabber and hundreds more &mdash; in stock, ready to ship.</p></div>
        </div>
        <div class="bento-cell wide dark reveal reveal-d1">
          <div class="inner"><p class="bento-eyebrow">USA-based fulfillment</p><h3>Fast, reliable shipping.</h3><p>Orders ship from US warehouses with tracking. Reorder bestsellers in a click when stock runs low.</p>
            <div class="bento-tag-row"><span class="bento-tag">&#10003; No PO fees</span><span class="bento-tag">&#10003; Fast reorder</span><span class="bento-tag">&#10003; Real-time stock</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div style="max-width:780px;margin-bottom:64px;">
        <p class="eyebrow reveal">Getting started</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Buy wholesale in <span class="italic gradient-text">three steps.</span></h2>
      </div>
      <div class="getting-started">
        <div class="gs-card reveal"><span class="gs-num">01</span>
          <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 5-3.5 8-9 10-5.5-2-9-5-9-10V6l9-4 9 4z"/></svg></div>
          <h4>Create your wholesale account</h4><p>Sign up at wholesale.thesmokedrop.com. Get vetted for wholesale pricing &mdash; no minimum order amount.</p>
        </div>
        <div class="gs-card reveal reveal-d1"><span class="gs-num">02</span>
          <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div>
          <h4>Browse wholesale pricing</h4><p>See cost and suggested retail on 20,000+ products. Add exactly what your shelves need to the cart.</p>
        </div>
        <div class="gs-card reveal reveal-d2"><span class="gs-num">03</span>
          <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div>
          <h4>Order &amp; restock</h4><p>Checkout at wholesale pricing. Track the shipment, then reorder bestsellers in a single click when stock runs low.</p>
        </div>
      </div>
      <div class="center reveal reveal-d3" style="margin-top:48px;">
        <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Start buying wholesale <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </div>
  </section>

  <!-- BRANDS MARQUEE -->
  <?php sdn_brands_marquee_section(); ?>

  <!-- PRODUCTS WITH BUBBLE FILTERS -->
  <?php sdn_products_section( 8, 'Buy wholesale' ); ?>

  <!-- PRICING TEASER -->
  <section class="sec">
    <div class="wrap wrap-tight center">
      <p class="eyebrow reveal" style="justify-content:center;">Pricing</p>
      <h2 class="display reveal reveal-d1" style="margin-top:24px;">Flat fee.<br><span class="italic gradient-text">No transaction fees.</span></h2>
      <p class="lede reveal reveal-d2" style="margin-top:24px;max-width:560px;">One plan, no per-order fees, no commissions. Wholesale pricing on the full catalog.</p>
      <a href="<?php echo esc_url( $pricing_url ); ?>" class="btn btn-outline btn-lg reveal reveal-d3" style="margin-top:32px;">See pricing</a>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
