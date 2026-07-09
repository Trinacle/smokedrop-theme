<?php
/**
 * Template Name: Platform Overview
 * Template Post Type: page
 *
 * Platform overview — how it works (light), features, integrations, CTA.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$retail_url = home_url( '/retailers' );
$contact_url = home_url( '/contact' );
$sdu = function ( $path ) { return home_url( '/wp-content/uploads/2024/01/' . $path ); };
?>

<main>

    <!-- HERO -->
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">The Platform</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">The industry leading<br><span class="italic gradient-text">dropship marketplace.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:640px;margin:0 auto;">One platform to import over 20,000 smoke shop products, sync inventory in real time, and automate order fulfillment with your suppliers.</p>
        <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:36px;">
          <a href="https://apps.shopify.com/smoke-drop" class="btn btn-lime btn-lg">Install on Shopify</a>
          <a href="<?php echo esc_url( $retail_url ); ?>" class="btn btn-outline btn-lg">For retailers</a>
        </div>
      </div>
    </section>

    <!-- WHITE SECTION: How it works -->
    <section class="sec" style="background:#fff;color:#1d1d1f;">
      <div class="wrap" style="color:#1d1d1f;">
        <div class="center" style="max-width:760px;margin:0 auto 64px;">
          <p class="eyebrow reveal" style="justify-content:center;color:#0a6b3f;">How it works</p>
          <h2 class="display reveal reveal-d1" style="margin-top:20px;color:#1d1d1f;">Start selling in <span style="color:#0a6b3f;">a few clicks.</span></h2>
        </div>
        <div class="getting-started">
          <div class="gs-card reveal" style="background:#f5f5f7;border-color:#e8e8ed;">
            <span class="gs-num" style="-webkit-text-stroke:1px rgba(0,0,0,.1);">01</span>
            <div class="gs-ico" style="background:rgba(0,65,34,.1);color:#0a6b3f;border-color:rgba(0,65,34,.2);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 5-3.5 8-9 10-5.5-2-9-5-9-10V6l9-4 9 4z"/></svg></div>
            <h4 style="color:#1d1d1f;">Create your account</h4>
            <p style="color:#6e6e73;">Create a SmokeDrop account to get started. No credit card required.</p>
          </div>
          <div class="gs-card reveal reveal-d1" style="background:#f5f5f7;border-color:#e8e8ed;">
            <span class="gs-num" style="-webkit-text-stroke:1px rgba(0,0,0,.1);">02</span>
            <div class="gs-ico" style="background:rgba(0,65,34,.1);color:#0a6b3f;border-color:rgba(0,65,34,.2);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div>
            <h4 style="color:#1d1d1f;">Connect your store</h4>
            <p style="color:#6e6e73;">Install the Shopify, WooCommerce, or BigCommerce app and link your account.</p>
          </div>
          <div class="gs-card reveal reveal-d2" style="background:#f5f5f7;border-color:#e8e8ed;">
            <span class="gs-num" style="-webkit-text-stroke:1px rgba(0,0,0,.1);">03</span>
            <div class="gs-ico" style="background:rgba(0,65,34,.1);color:#0a6b3f;border-color:rgba(0,65,34,.2);"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div>
            <h4 style="color:#1d1d1f;">Import and sell</h4>
            <p style="color:#6e6e73;">Import products in a few clicks, set your prices, and start selling.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- PLATFORM FEATURES -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="max-width:760px;margin:0 auto 64px;">
          <p class="eyebrow reveal" style="justify-content:center;">Platform features</p>
          <h2 class="display reveal reveal-d1" style="margin-top:20px;">Everything you need to<br><span class="italic gradient-text">sell more, work less.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg></div><h4>Import in a few clicks</h4><p>Add products to your online store in just a few clicks. We carry all the latest items from the top brands.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Automatic order syncing</h4><p>Automatic order syncing with suppliers. Never sell what you don't have with real-time inventory sync.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><polyline points="21 4 21 9 16 9"/></svg></div><h4>Automatic order fulfillment</h4><p>Easily manage orders in your Shopify or WooCommerce. Tracking numbers sync across suppliers, retailers &amp; customers.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div><h4>Shopping cart integrations</h4><p>Native apps for Shopify, WooCommerce, and BigCommerce. One-click install.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Stock up local inventory</h4><p>Purchase products at wholesale prices with no minimum order amount. Buy in bulk or as needed.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div><h4>20,000+ products</h4><p>Water pipes, vaporizers, CBD, and accessories &mdash; all from 300+ of the biggest brands in the smoke industry.</p></div>
        </div>
      </div>
    </section>

    <!-- STATS BAND -->
    <section class="sec-sm" style="background:#13c27b;">
      <div class="wrap">
        <div class="scale-stats">
          <div class="ss reveal"><div class="n" style="color:#000;font-weight:800;"><span data-count="20000" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Products</div></div>
          <div class="ss reveal reveal-d1"><div class="n" style="color:#000;font-weight:800;"><span data-count="300" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Brands</div></div>
          <div class="ss reveal reveal-d2"><div class="n" style="color:#000;font-weight:800;"><span data-count="3" data-suffix="">0</span></div><div class="l" style="color:#000;font-weight:600;">Platform integrations</div></div>
          <div class="ss reveal reveal-d3"><div class="n" style="color:#000;font-weight:800;">$0</div><div class="l" style="color:#000;font-weight:600;">Transaction fees</div></div>
        </div>
      </div>
    </section>

    <!-- BUILT FOR EVERY WORKFLOW -->
    <section class="sec">
      <div class="wrap">
        <div class="tool-row reveal">
          <div class="tool-media">
            <div class="tool-card-tag">For Retailers</div>
            <h2 class="tool-name" style="font-size:2.2rem;">Dropship or buy wholesale.</h2>
          </div>
          <div class="tool-body">
            <p class="lede" style="font-size:1.05rem;color:var(--ink);">Whether you want to dropship with zero inventory or buy wholesale to stock your shelves, SmokeDrop handles both from one platform. No switching tools, no separate accounts.</p>
            <div class="tool-checks">
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span><strong>Dropship:</strong> Import products, set prices, suppliers ship under your brand</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span><strong>Wholesale:</strong> Buy at wholesale pricing with no minimum order</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span><strong>Both:</strong> Dropship slow movers, stock your bestsellers locally</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span><strong>No transaction fees</strong> on anything you buy or sell</span></div>
            </div>
            <a href="<?php echo esc_url( $retail_url ); ?>" class="btn btn-lime btn-lg" style="margin-top:8px;">Start dropshipping</a>
          </div>
        </div>
      </div>
    </section>

    <!-- FOR SUPPLIERS -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="tool-row reverse reveal">
          <div class="tool-media">
            <div class="tool-card-tag">For Suppliers &amp; Brands</div>
            <h2 class="tool-name" style="font-size:2.2rem;">Reach hundreds of retailers.</h2>
          </div>
          <div class="tool-body">
            <p class="lede" style="font-size:1.05rem;color:var(--ink);">List your catalog once and instantly reach hundreds of vetted smoke shop retailers. Automated order routing, real-time inventory sync, and no per-listing fees.</p>
            <div class="tool-grid">
              <div class="tool-tile"><strong>List once</strong><span>Reach every retailer in the network</span></div>
              <div class="tool-tile"><strong>Automated orders</strong><span>Orders route straight to your fulfillment</span></div>
              <div class="tool-tile"><strong>Demand analytics</strong><span>See sell-through by retailer &amp; region</span></div>
              <div class="tool-tile"><strong>100% free to start</strong><span>$49.99/mo only when you scale</span></div>
            </div>
            <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>" class="btn btn-outline btn-lg" style="margin-top:8px;">Become a supplier</a>
          </div>
        </div>
      </div>
    </section>

    <!-- WHITE SECTION: Integrations -->
    <section class="sec" style="background:#fff;color:#1d1d1f;">
      <div class="wrap center" style="color:#1d1d1f;">
        <p class="eyebrow reveal" style="justify-content:center;color:#0a6b3f;">Shopping Cart Integrations</p>
        <h2 class="display reveal reveal-d1" style="margin-top:20px;color:#1d1d1f;">Import over 20,000 smoke shop<br>products to <span style="color:#0a6b3f;">your online store.</span></h2>
        <div class="integrations-row reveal reveal-d2" style="margin-top:56px;">
          <?php sdn_integration_bubbles(); ?>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <?php sdn_cta(); ?>

</main>

<?php
get_footer();
