<?php
/**
 * Template Name: For Retailers
 * Template Post Type: page
 *
 * Retailer landing page — benefits bento, getting started, testimonial, CTA.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$pricing_url = home_url( '/pricing' );
$brands_url  = get_post_type_archive_link( 'brand' );
?>

<main>

    <!-- HERO -->
    <section class="page-hero">
      <div class="ph-smoke">
        <div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div>
      </div>
      <div class="ph-inner">
        <p class="eyebrow reveal">For Retailers</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Become the next<br><span class="italic gradient-text">online success story.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;">Control everything from your shopping cart &mdash; inventory, order management, and pricing. Stock 20,000+ SKUs from 300+ brands with zero inventory, zero minimums.</p>
        <div class="hero-actions reveal reveal-d3">
          <a href="https://apps.shopify.com/smoke-drop" class="btn btn-lime btn-lg">Install on Shopify</a>
          <a href="#how" class="btn btn-outline btn-lg">See how it works</a>
        </div>
      </div>
    </section>

    <!-- TRUST BAR -->
    <div class="trust-bar reveal">
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg><div><strong>14-day free trial</strong><span>No credit card</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg><div><strong>Automatic sync</strong><span>Orders &amp; tracking</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg><div><strong>No PO fees</strong><span>Keep your margin</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg><div><strong>300+ brands</strong><span>20,000+ products</span></div></div>
    </div>

    <!-- BENEFITS -->
    <section class="sec">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:64px;">
          <p class="eyebrow reveal">Why retailers win</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Run a full smoke shop<br><span class="italic gradient-text">without a warehouse.</span></h2>
        </div>
        <div class="bento">
          <div class="bento-cell wide emerald reveal">
            <div class="inner"><p class="bento-eyebrow">Real-time sync</p><h3>Never oversell. Never refund out-of-stock.</h3><p>Every supplier's stock, price, and detail flows into your store the instant it changes. Sub-minute updates across every channel, 24/7.</p></div>
          </div>
          <div class="bento-cell lime reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">300+ brands</p><h3>The catalog competitors wish they had.</h3><p>PAX, Puffco, Cookies, GRAV, RAW, Dr. Dabber and hundreds more. Import curated collections in one click.</p></div>
          </div>
          <div class="bento-cell dark reveal">
            <div class="inner"><p class="bento-eyebrow">Blind dropship</p><h3>Ships under your brand.</h3><p>Orders route to the nearest supplier and ship blind within 24 hours. Your customer never sees our name.</p></div>
          </div>
          <div class="bento-cell wide dark reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">Transparent margins</p><h3>See wholesale cost before you import.</h3><p>You set the final price. The difference is all yours. No PO fees, no hidden margin tax, no per-SKU charges.</p></div>
          </div>
        </div>
      </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="sec" id="how" style="background:var(--bg-2);">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:64px;">
          <p class="eyebrow reveal">Getting started</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Live in <span class="italic gradient-text">three steps.</span></h2>
        </div>
        <div class="getting-started">
          <div class="gs-card reveal"><span class="gs-num">01</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 5-3.5 8-9 10-5.5-2-9-5-9-10V6l9-4 9 4z"/></svg></div>
            <h4>Create your account</h4><p>Free signup. Create your account in minutes. No credit card to start.</p>
          </div>
          <div class="gs-card reveal reveal-d1"><span class="gs-num">02</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div>
            <h4>Connect your store</h4><p>Install the Shopify, WooCommerce, or BigCommerce app and link your account in one click.</p>
          </div>
          <div class="gs-card reveal reveal-d2"><span class="gs-num">03</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div>
            <h4>Import and sell</h4><p>Browse 20,000+ products. Import curated collections, set your prices, and start selling.</p>
          </div>
        </div>
        <div class="center reveal reveal-d3" style="margin-top:48px;">
          <a href="https://apps.shopify.com/smoke-drop" class="btn btn-lime btn-lg">Install on Shopify <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="sec">
      <div class="wrap wrap-tight center">
        <svg viewBox="0 0 24 24" width="48" height="48" class="reveal" style="color:var(--green-xl);margin:0 auto 32px;"><path fill="currentColor" d="M10 7L8 11v6h6v-6h-3l2-4zm8 0l-2 4v6h6v-6h-3l2-4z"/></svg>
        <p class="reveal reveal-d1" style="font-family:var(--display);font-size:clamp(1.5rem,3vw,2.4rem);font-weight:500;line-height:1.3;letter-spacing:-.02em;color:var(--ink);">"We added 2,000 SKUs in a weekend and tripled our vape category revenue in 90 days. The auto-sync means we never oversell."</p>
        <div class="reveal reveal-d2" style="display:flex;align-items:center;gap:16px;justify-content:center;margin-top:36px;">
          <div style="width:52px;height:52px;border-radius:50%;background:var(--green);color:#fff;display:grid;place-items:center;font-family:var(--display);font-weight:600;">JR</div>
          <div style="text-align:left;"><strong style="font-size:1.1rem;display:block;">Jess Ramirez</strong><span style="color:var(--ink-mute);">Owner, Cloud Peak Vapes</span></div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="bento-cell full reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));border:1px solid var(--green-l);min-height:auto;">
          <div class="inner" style="padding:clamp(48px,7vw,80px);text-align:center;align-items:center;">
            <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:#fff;">Stock every brand.<br><span class="italic">Hold zero inventory.</span></h2>
            <p class="lede" style="max-width:560px;margin:24px auto 0;">Join hundreds of retailers dropshipping the biggest smoke, vape &amp; hemp brands.</p>
            <div class="hero-actions" style="justify-content:center;margin-top:36px;">
              <a href="https://app.thesmokedrop.com" class="btn btn-lime btn-lg" style="background:#fff;color:var(--green);">Start free trial</a>
              <a href="<?php echo esc_url( $pricing_url ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.3);color:#fff;">View pricing</a>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
