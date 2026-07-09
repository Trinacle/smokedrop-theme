<?php
/**
 * Template Name: Download Plugin
 * Template Post Type: page
 *
 * WooCommerce plugin download page — what it does, system requirements,
 * install steps, and the download CTA.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$register = 'https://wholesale.thesmokedrop.com/register';
$help_url = home_url( '/help' );
$uploads  = home_url( '/wp-content/uploads/' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">WordPress Plugin</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Dropship 20,000+ products<br><span class="italic gradient-text">on WooCommerce.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:600px;margin:0 auto;">The SmokeDrop WooCommerce plugin connects your store to the full marketplace &mdash; import products, sync inventory, and automate order fulfillment with no transaction fees.</p>
        <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
          <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Download the Plugin</a>
          <a href="<?php echo esc_url( $help_url ); ?>" class="btn btn-outline btn-lg">Setup Guide</a>
        </div>
      </div>
    </section>

    <!-- WHAT IT DOES -->
    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">What the plugin does</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">WordPress native. <span class="italic gradient-text">No code required.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h4>1-click product import</h4><p>Browse 20,000+ products from 300+ brands and add them to your WooCommerce store instantly.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time inventory sync</h4><p>Stock and price updates flow from suppliers into WooCommerce in under a minute.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Automatic order sync</h4><p>Orders sync with suppliers automatically; tracking numbers flow back to WooCommerce.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1v22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div><h4>No transaction fees</h4><p>One flat plan fee. Keep your full margin on every sale.</p></div>
        </div>
      </div>
    </section>

    <!-- INSTALL STEPS -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap wrap-tight">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Get started</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Up and running <span class="italic gradient-text">in 3 steps.</span></h2>
        </div>
        <div class="bento" style="grid-template-columns:repeat(3,1fr);gap:24px;">
          <div class="bento-cell dark reveal">
            <div class="inner" style="text-align:center;">
              <div style="font-family:var(--display);font-size:2.5rem;font-weight:700;color:var(--green-xl);">1</div>
              <h3 style="margin-top:12px;">Download &amp; install</h3>
              <p>Download the plugin ZIP and install it via <strong>Plugins &rarr; Add New &rarr; Upload</strong> in your WordPress admin.</p>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner" style="text-align:center;">
              <div style="font-family:var(--display);font-size:2.5rem;font-weight:700;color:var(--green-xl);">2</div>
              <h3 style="margin-top:12px;">Connect your store</h3>
              <p>Enter your SmokeDrop API key to link your WooCommerce store to the marketplace.</p>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d2">
            <div class="inner" style="text-align:center;">
              <div style="font-family:var(--display);font-size:2.5rem;font-weight:700;color:var(--green-xl);">3</div>
              <h3 style="margin-top:12px;">Import &amp; sell</h3>
              <p>Browse the catalog, import products, set your prices, and start selling. Orders sync automatically.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- REQUIREMENTS + CTA -->
    <section class="sec">
      <div class="wrap">
        <div class="tool-row reveal">
          <div class="tool-media">
            <div class="tool-card-tag">System Requirements</div>
            <h2 class="tool-name" style="font-size:2.2rem;">Before you install</h2>
          </div>
          <div class="tool-body">
            <div class="tool-checks">
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>WordPress 5.8 or higher</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>WooCommerce 5.0 or higher</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>PHP 7.4 or higher</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>An active SmokeDrop account (free trial available)</span></div>
            </div>
            <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Download the Plugin</a>
          </div>
        </div>
      </div>
    </section>

    <?php sdn_cta(); ?>
</main>

<?php
get_footer();
