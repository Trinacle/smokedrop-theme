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

    <!-- WHITE SECTION: Integrations -->
    <section class="sec" style="background:#fff;color:#1d1d1f;">
      <div class="wrap center" style="color:#1d1d1f;">
        <p class="eyebrow reveal" style="justify-content:center;color:#0a6b3f;">Shopping Cart Integrations</p>
        <h2 class="display reveal reveal-d1" style="margin-top:20px;color:#1d1d1f;">Import over 20,000 smoke shop<br>products to <span style="color:#0a6b3f;">your online store.</span></h2>
        <div class="integrations-row reveal reveal-d2" style="margin-top:56px;">
          <a href="https://apps.shopify.com/smoke-drop" class="int-logo" style="background:#f5f5f7;border-color:#e8e8ed;">
            <img src="<?php echo esc_url( $sdu( '5f1a58272cd5b8c219db0ba4_shopify-logo.svg' ) ); ?>" alt="Shopify" style="height:42px;width:auto;opacity:.85;" onerror="this.style.display='none'">
            <span style="color:#1d1d1f;">Shopify</span>
          </a>
          <a href="#" class="int-logo" style="background:#f5f5f7;border-color:#e8e8ed;">
            <img src="<?php echo esc_url( $sdu( '5f1a59d6f884854a22b65124_woocommerce-logo.svg' ) ); ?>" alt="WooCommerce" style="height:42px;width:auto;opacity:.85;" onerror="this.style.display='none'">
            <span style="color:#1d1d1f;">WooCommerce</span>
          </a>
          <a href="#" class="int-logo" style="background:#f5f5f7;border-color:#e8e8ed;">
            <img src="<?php echo esc_url( $sdu( '5f1a5a542662b9b5006821de_bigcommerce-logo.svg' ) ); ?>" alt="BigCommerce" style="height:42px;width:auto;opacity:.85;" onerror="this.style.display='none'">
            <span style="color:#1d1d1f;">BigCommerce</span>
          </a>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <?php sdn_cta(); ?>

</main>

<?php
get_footer();
