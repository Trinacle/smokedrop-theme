<?php
/**
 * Template Name: Solutions
 * Template Post Type: page
 *
 * Features breakdown — every SmokeDrop capability organized by category.
 * The "Solutions" nav item points here.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$register = 'https://wholesale.thesmokedrop.com/register';
$demo     = home_url( '/demo' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Solutions</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Everything you need<br><span class="italic gradient-text">to sell more.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:600px;margin:0 auto;">From real-time inventory sync to automatic order fulfillment &mdash; SmokeDrop handles the operational heavy lifting so you can focus on growing your store.</p>
        <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
          <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Start Free Trial</a>
          <a href="<?php echo esc_url( $demo ); ?>" class="btn btn-outline btn-lg">Get a Demo</a>
        </div>
      </div>
    </section>

    <!-- INVENTORY & SYNC -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Inventory &amp; Sync</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Always in sync. <span class="italic gradient-text">Never oversell.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time inventory sync</h4><p>Sub-minute stock &amp; price updates flow from suppliers to your store across every channel.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h4>1-click catalog import</h4><p>Add curated brand collections or individual products to your store in a single click.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div><h4>Branded packing slips</h4><p>White-label every order with your logo and insert cards. Your customer never sees the supplier.</p></div>
        </div>
      </div>
    </section>

    <!-- ORDER FULFILLMENT -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Order Fulfillment</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Orders route themselves. <span class="italic gradient-text">Tracking syncs back.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Automatic order fulfillment</h4><p>Customer orders route straight to the right supplier. No manual forwarding, no copy-paste.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg></div><h4>Tracking sync</h4><p>Tracking numbers flow from supplier to your store to your customer automatically.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg></div><h4>Blind dropshipping</h4><p>Every order ships under your brand. Suppliers are invisible to your customers.</p></div>
        </div>
      </div>
    </section>

    <!-- SUPPLIER MANAGEMENT -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Supplier Management</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">A network of <span class="italic gradient-text">vetted suppliers.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><h4>Supplier onboarding</h4><p>Invite and vet suppliers through a self-serve portal. Expand your catalog on your terms.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l3-3 3 2 4-5"/></svg></div><h4>Analytics &amp; reporting</h4><p>Profit per SKU, supplier performance, and sell-through data. Export raw data anytime.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11a8 8 0 0 1-12 7l-5 1 1-5a8 8 0 1 1 16-3z"/></svg></div><h4>In-app support &amp; live chat</h4><p>Reach our support team with live chat, right inside the platform.</p></div>
        </div>
      </div>
    </section>

    <!-- INTEGRATIONS -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Integrations</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Connect once. <span class="italic gradient-text">Sell everywhere.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg></div><h4>Shopify, WooCommerce &amp; BigCommerce</h4><p>Native plugins sync products, orders, and inventory across every major platform.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div><h4>REST API &amp; EDI</h4><p>Custom integrations via API, CSV/FTP, and EDI-X12 for enterprise stacks.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>300+ brands, 20,000+ products</h4><p>The deepest catalog in smoke, vape, hemp, and glass &mdash; all dropship-ready.</p></div>
        </div>
        <div class="center" style="margin-top:48px;">
          <a href="<?php echo esc_url( home_url( '/integrations' ) ); ?>" class="btn btn-outline btn-lg reveal reveal-d2">Explore integrations</a>
        </div>
      </div>
    </section>

    <?php sdn_cta(); ?>
</main>

<?php
get_footer();
