<?php
/**
 * Template Name: Recommended Tools
 * Template Post Type: page
 *
 * Curated directory of partner tools that pair well with a SmokeDrop store:
 * merchant processing (OpenTransact), web design & marketing (Trinacle), and
 * shipping insurance (SavedBy). Recreated from the legacy /recomend-tools-for-
 * ecommerce/ page in the new design system.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$uploads = home_url( '/wp-content/uploads/' );
$call    = home_url( '/call' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Partner directory</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Recommended tools<br><span class="italic gradient-text">for your store.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:600px;margin:0 auto;">Vetted services that pair with SmokeDrop &mdash; merchant processing, web design, and shipping protection from partners we trust.</p>
      </div>
    </section>

    <!-- MERCHANT PROCESSING -->
    <section class="sec">
      <div class="wrap">
        <div class="tool-row reveal">
          <div class="tool-media">
            <div class="tool-card-tag">Merchant processing</div>
            <h2 class="h-sec" style="margin-top:12px;">Accept payments.<br><span class="italic gradient-text">100% domestic.</span></h2>
          </div>
          <div class="tool-body">
            <p class="lede" style="font-size:1.05rem;">Process Visa, Mastercard, Discover, and AMEX with OpenTransact &mdash; built for smoke, vape, and CBD merchants.</p>
            <div class="tool-checks">
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>100% domestic processing (Visa, Mastercard, Discover, AMEX)</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Credit, debit, and prepaid cards supported</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>3.75% discount rate (same as Square) with volume discounts</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Daily settlements via direct deposit / ACH</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Integrated fraud-reduction tools</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Works with Shopify, WooCommerce, and BigCommerce</span></div>
            </div>
            <div class="tool-meta">
              <p><strong>Qualification:</strong> Start-ups selling SmokeDrop products welcome. No minimum sales volume. Flat $150/mo for full-time OpenTransact support. Valid business documentation required.</p>
              <p><strong>Setup:</strong> Minimal paperwork, approval within 1&ndash;2 business days, 24/7 merchant support, and full-service online account reporting.</p>
            </div>
            <a href="<?php echo esc_url( $call ); ?>" class="btn btn-lime btn-lg" style="margin-top:8px;">Complete online application</a>
          </div>
        </div>
      </div>
    </section>

    <!-- WEB DESIGN & MARKETING -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="tool-row reverse reveal">
          <div class="tool-media">
            <div class="tool-card-tag">Web design &amp; marketing</div>
            <h2 class="h-sec" style="margin-top:12px;">A store that<br><span class="italic gradient-text">converts.</span></h2>
          </div>
          <div class="tool-body">
            <p class="lede" style="font-size:1.05rem;">Trinacle is a family-owned online marketing agency with a passion for creating highly converting marketing channels &mdash; over 25 years of experience.</p>
            <div class="tool-grid">
              <div class="tool-tile"><strong>Web design &amp; development</strong><span>Store builds that sell</span></div>
              <div class="tool-tile"><strong>Search engine optimization</strong><span>Rank and get found</span></div>
              <div class="tool-tile"><strong>Paid advertising</strong><span>Google, Meta, and more</span></div>
              <div class="tool-tile"><strong>App development</strong><span>Custom Shopify &amp; Woo apps</span></div>
              <div class="tool-tile"><strong>Social media marketing</strong><span>Content that engages</span></div>
              <div class="tool-tile"><strong>Video production</strong><span>Product and brand films</span></div>
              <div class="tool-tile"><strong>Email marketing &amp; list building</strong><span>Retention on autopilot</span></div>
              <div class="tool-tile"><strong>Affiliate management</strong><span>Grow via partners</span></div>
            </div>
            <a href="<?php echo esc_url( $call ); ?>" class="btn btn-outline btn-lg" style="margin-top:8px;">Schedule a call to get started</a>
          </div>
        </div>
      </div>
    </section>

    <!-- SHIPPING INSURANCE -->
    <section class="sec">
      <div class="wrap">
        <div class="tool-row reveal">
          <div class="tool-media">
            <div class="tool-card-tag">Shipping protection</div>
            <h2 class="h-sec" style="margin-top:12px;">Protect every<br><span class="italic gradient-text">package.</span></h2>
          </div>
          <div class="tool-body">
            <p class="lede" style="font-size:1.05rem;">With SavedBy, customers can protect their package in case it&rsquo;s lost, stolen, or damaged &mdash; added peace of mind at checkout.</p>
            <div class="tool-checks">
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Covers lost, stolen, and damaged packages</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Customer opts in at checkout &mdash; no extra work for you</span></div>
              <div class="tool-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Faster, hassle-free resolutions</span></div>
            </div>
            <a href="<?php echo esc_url( $call ); ?>" class="btn btn-lime btn-lg" style="margin-top:8px;">Complete online application</a>
          </div>
        </div>
      </div>
    </section>

    <?php sdn_cta(); ?>
</main>

<?php
get_footer();
