<?php
/**
 * Template Name: Pricing
 * Template Post Type: page
 *
 * SmokeDrop pricing page — three tiers + supplier free banner + FAQ.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url  = home_url( '/suppliers' );
$contact_url = home_url( '/contact' );
$check_svg   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>

<main>

    <!-- HERO -->
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Pricing</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Pricing that scales<br><span class="italic gradient-text">with your sales.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Start free. No contracts, no hidden fees, no PO fees. You only pay more as you sell more &mdash; and you'll always know your margin upfront.</p>
      </div>
    </section>

    <!-- SUPPLIER FREE BANNER -->
    <section class="sec-sm">
      <div class="wrap">
        <div class="free-banner reveal">
          <div>
            <h3>Suppliers &amp; Brands: 100% free.</h3>
            <p>No listing fees. No transaction fees. Unlimited retailers.</p>
          </div>
          <a href="<?php echo esc_url( $supply_url ); ?>" class="btn btn-lime btn-lg" style="background:#fff;color:var(--green);">Become a supplier</a>
        </div>
      </div>
    </section>

    <!-- PRICING TIERS -->
    <section class="sec" style="padding-top:0;">
      <div class="wrap">
        <div class="price-grid">
          <div class="price-card reveal">
            <div class="p-tier">Free Trial</div>
            <div class="p-amt">14 days<small> free</small></div>
            <div class="p-desc">Full access to SmokeDrop. No credit card required. Cancel anytime.</div>
            <ul class="p-feats">
              <li><?php echo $check_svg; // phpcs:ignore ?>Full catalog access &mdash; 20,000+ products</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Shopify, WooCommerce &amp; BigCommerce</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Real-time inventory sync</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Blind dropshipping</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Automatic order fulfillment</li>
            </ul>
            <a href="https://app.thesmokedrop.com" class="btn btn-outline btn-block">Start free trial</a>
          </div>

          <div class="price-card featured reveal reveal-d1">
            <div class="p-badge">Most popular</div>
            <div class="p-tier">SmokeDrop</div>
            <div class="p-amt">$99<small>/mo</small></div>
            <div class="p-desc">Everything you need to run a full smoke shop dropshipping business.</div>
            <ul class="p-feats">
              <li><?php echo $check_svg; // phpcs:ignore ?>20,000+ products from 300+ brands</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Everything in the free trial</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Import to your store in a few clicks</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Automatic order syncing with suppliers</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Tracking numbers sync across suppliers &amp; customers</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>We carry all the latest items from the top brands</li>
            </ul>
            <a href="https://apps.shopify.com/smoke-drop" class="btn btn-lime btn-block">Install on Shopify &mdash; $99/mo</a>
          </div>

          <div class="price-card reveal reveal-d2">
            <div class="p-tier">Yearly</div>
            <div class="p-amt">Save<small> big</small></div>
            <div class="p-desc">Pre-pay yearly and lock in a better rate. Same features, lower monthly cost.</div>
            <ul class="p-feats">
              <li><?php echo $check_svg; // phpcs:ignore ?>Everything in the monthly plan</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Discounted yearly billing</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>No PO fees, no transaction fees</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Priority support</li>
            </ul>
            <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-outline btn-block">Get yearly pricing</a>
          </div>
        </div>

        <p class="center reveal reveal-d3" style="color:var(--ink-mute);font-size:.92rem;margin-top:36px;">All plans include real-time inventory sync, automatic order fulfillment, and tracking sync. No PO fees, ever.</p>
      </div>
    </section>

    <!-- INCLUDED BANNER -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap center">
        <p class="eyebrow reveal" style="justify-content:center;">Included in every plan</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;font-size:clamp(2rem,4vw,3.4rem);">No nickel-and-diming.</h2>
        <div class="bento-tag-row reveal reveal-d2" style="justify-content:center;margin-top:40px;">
          <span class="bento-tag">No contracts</span>
          <span class="bento-tag">No per-SKU fees</span>
          <span class="bento-tag">No PO fees</span>
          <span class="bento-tag">No transaction fees</span>
          <span class="bento-tag">Cancel anytime</span>
          <span class="bento-tag">14-day free trial</span>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="sec">
      <div class="wrap wrap-tight">
        <div class="center" style="margin-bottom:56px;">
          <p class="eyebrow reveal" style="justify-content:center;">Pricing FAQ</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Questions, answered.</h2>
        </div>
        <div class="faq-list reveal">
          <div class="faq-item open">
            <button class="faq-q">Is there really a free plan? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>Yes. The 14-day free trial gives you full access &mdash; real-time sync, integrations, and blind dropshipping for the whole catalog. You only add a card when you're ready to go live.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">Are there per-transaction or PO fees? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>No. Unlike some platforms that charge a percentage of every supplier cost (a hidden margin tax), SmokeDrop has no PO fees, no per-order fees, and no transaction fees. You pay the wholesale cost plus your monthly plan.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">I'm a supplier or brand &mdash; what does it cost? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>Suppliers and brands are 100% free &mdash; no listing fees, no transaction fees, unlimited retailers. <a href="<?php echo esc_url( $supply_url ); ?>" style="color:var(--green-xl);">Learn about becoming a supplier</a>.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">Can I switch plans later? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>Anytime. Upgrades take effect immediately; downgrades take effect at the next billing cycle. No penalties, no contracts.</p></div>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
