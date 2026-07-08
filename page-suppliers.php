<?php
/**
 * Template Name: For Suppliers
 * Template Post Type: page
 *
 * Supplier/brand landing page — distribution benefits, stats, onboarding, CTA.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_url = home_url( '/contact' );
$demo_url    = home_url( '/demo' );
?>

<main>
    <section class="hero" style="min-height:auto;padding-top:180px;padding-bottom:40px;">
      <div class="hero-inner">
        <p class="eyebrow reveal">For Suppliers &amp; Brands</p>
        <h1 class="display-mega reveal reveal-d1" style="margin:24px 0;font-size:clamp(2.6rem,8vw,7rem);">
          <span class="line-mask"><span>Distribute to</span></span>
          <span class="line-mask line-mask-d1"><span>hundreds of <em class="italic gradient-text">smoke</em></span></span>
          <span class="line-mask line-mask-d2"><span>shops &amp; retailers.</span></span>
        </h1>
        <p class="lede reveal reveal-d3" style="max-width:640px;">Unlock the power of dropshipping and distribute your products to hundreds of smoke shops &amp; online retailers. Fully automated order management. Easy &amp; fast catalog import. <strong style="color:var(--ink);">From $49.99/mo &mdash; no transaction fees, no commissions, ever.</strong></p>
        <div class="hero-actions reveal reveal-d4">
          <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg">Become a supplier</a>
          <a href="<?php echo esc_url( $demo_url ); ?>" class="btn btn-outline btn-lg">Get a Demo</a>
        </div>
      </div>
    </section>

    <!-- Free banner -->
    <section class="sec-sm" style="border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--bg-2);">
      <div class="wrap center">
        <p class="reveal" style="font-family:var(--display);font-size:clamp(1.4rem,3vw,2.2rem);font-weight:600;letter-spacing:-.02em;">Supplier plans start at <span class="gradient-text">$49.99/mo.</span> No transaction fees. No commissions. Unlimited retailers.</p>
      </div>
    </section>

    <!-- Benefits -->
    <section class="sec">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:64px;">
          <p class="eyebrow reveal">Why suppliers win</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">The fastest path to<br><span class="italic gradient-text">thousands of stores.</span></h2>
        </div>
        <div class="bento">
          <div class="bento-cell wide emerald reveal">
            <div class="inner"><p class="bento-eyebrow">Distribution</p><h3>One catalog, thousands of retailers.</h3><p>Upload once. We syndicate to Shopify, WooCommerce, BigCommerce and API retailers automatically. No per-store setup.</p></div>
          </div>
          <div class="bento-cell lime reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">Free forever</p><h3>No fees. No catch.</h3><p>Suppliers pay nothing. No listing fees, no transaction fees, no per-order fees. Unlimited retailers, unlimited products.</p></div>
          </div>
          <div class="bento-cell dark reveal">
            <div class="inner"><p class="bento-eyebrow">Automated payments</p><h3>Get paid on autopilot.</h3><p>Escrow-based payouts, batch invoicing, Net Terms, credit memos. Funds hit your account on schedule.</p></div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">Demand analytics</p><h3>See what sells, where.</h3><p>Track sell-through by retailer, region, and SKU. Forecast demand and stock up before you run out.</p></div>
          </div>
          <div class="bento-cell dark reveal">
            <div class="inner"><p class="bento-eyebrow">MAP protection</p><h3>Brand integrity, enforced.</h3><p>Set minimum advertised pricing once. We block underpriced listings automatically across every retailer.</p></div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">Vetted buyers</p><h3>Wholesale pricing stays wholesale.</h3><p>Every retailer is vetted. Your B2B pricing never leaks to the public.</p></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <section class="sec-sm" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="scale-stats">
          <div class="ss reveal"><div class="n"><span data-count="300" data-suffix="+">0</span></div><div class="l">Brands on the network</div></div>
          <div class="ss reveal reveal-d1"><div class="n"><span data-count="20000" data-suffix="+">0</span></div><div class="l">Products in catalog</div></div>
          <div class="ss reveal reveal-d2"><div class="n">100%</div><div class="l">Automated order sync</div></div>
          <div class="ss reveal reveal-d3"><div class="n">Free</div><div class="l">No transaction fees</div></div>
        </div>
      </div>
    </section>

    <!-- WHY BECOME A SUPPLIER -->
    <section class="sec">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:48px;">
          <p class="eyebrow reveal">Why become a supplier?</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">The fastest, lowest-cost path<br><span class="italic gradient-text">to retail distribution.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><h4>Hundreds of retailers, one integration</h4><p>List once and reach hundreds of vetted smoke shop retailers. No per-store setup, no per-account management.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div><h4>100% free to start</h4><p>No listing fees, no transaction fees, no commissions. The Supplier plan ($49.99/mo) only unlocks advanced automation when you're ready to scale.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Fully automated orders</h4><p>Customer orders route straight to your fulfillment. Tracking numbers sync back to retailers and end customers automatically.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l3-3 3 2 4-5"/></svg></div><h4>Demand analytics</h4><p>See sell-through by retailer, region, and SKU. Forecast demand and restock before you run out.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Automated payouts</h4><p>Escrow-based supplier payments on autopilot, with batch invoicing, Net Terms, and credit memos.</p></div>
        </div>
      </div>
    </section>

    <!-- BRANDS MARQUEE -->
    <?php sdn_brands_marquee_section(); ?>

    <!-- Onboarding steps -->
    <section class="sec">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:64px;">
          <p class="eyebrow reveal">Onboarding</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Live in <span class="italic gradient-text">48 hours.</span></h2>
        </div>
        <div class="getting-started">
          <div class="gs-card reveal">
            <span class="gs-num">01</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 5-3.5 8-9 10-5.5-2-9-5-9-10V6l9-4 9 4z"/></svg></div>
            <h4>Apply</h4><p>Submit your business and product catalog for vetting and onboarding.</p>
          </div>
          <div class="gs-card reveal reveal-d1">
            <span class="gs-num">02</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div>
            <h4>Onboard</h4><p>Our team maps your SKUs, pricing, and inventory feed. Free, white-glove, no developer required.</p>
          </div>
          <div class="gs-card reveal reveal-d2">
            <span class="gs-num">03</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div>
            <h4>Go live &amp; scale</h4><p>Your catalog appears across thousands of storefronts. Use analytics to forecast and grow.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Supplier CTA -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="bento-cell full reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));border:1px solid var(--green-l);min-height:auto;">
          <div class="inner" style="padding:clamp(48px,7vw,80px);align-items:center;text-align:center;">
            <p class="bento-eyebrow" style="color:rgba(255,255,255,.8);">Get started</p>
            <p class="reveal reveal-d1" style="font-family:var(--display);font-size:clamp(1.8rem,3.5vw,2.8rem);font-weight:600;color:#fff;line-height:1.2;margin-top:20px;max-width:780px;">Distribute your products to hundreds of smoke shops &amp; online retailers.</p>
            <p class="lede reveal reveal-d2" style="color:rgba(255,255,255,.82);max-width:560px;margin:24px auto 0;">Fully automated order management. Easy &amp; fast catalog import. Seamless product import &amp; order fulfillment. Sync inventory with Shopify &amp; WooCommerce.</p>
            <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg reveal reveal-d3" style="background:#fff;color:var(--green);margin-top:36px;">Fill out the form to get started</a>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
