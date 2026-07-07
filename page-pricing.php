<?php
/**
 * Template Name: Pricing
 * Template Post Type: page
 *
 * SmokeDrop pricing page — Retailer + Supplier plans with an inline
 * monthly/yearly billing toggle (no redirect), pricing visible above the fold.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url  = home_url( '/suppliers' );
$register    = 'https://wholesale.thesmokedrop.com/register';
$check_svg   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>

<main>

    <!-- COMPACT HERO + PRICING (single section, pricing visible above the fold) -->
    <section class="pricing-hero">
      <div class="pricing-hero-inner wrap">
        <p class="eyebrow reveal" style="justify-content:center;">Pricing</p>
        <h1 class="pricing-h1 reveal reveal-d1">Two plans.<br><span class="italic gradient-text">No nickel-and-diming.</span></h1>
        <p class="pricing-sub reveal reveal-d2">One flat fee. <strong style="color:var(--ink);">No transaction fees, no commissions, ever.</strong> Switch billing anytime.</p>

        <div class="pricing-toggle reveal reveal-d3">
          <span class="pt-label pt-label-monthly is-active">Monthly</span>
          <button type="button" id="billing-toggle" class="pt-switch" aria-pressed="false" aria-label="Toggle monthly or yearly billing"><span class="pt-knob"></span></button>
          <span class="pt-label pt-label-yearly">Yearly <span class="pt-badge">Save up to 24%</span></span>
        </div>

        <div class="price-grid-2 reveal reveal-d3" id="price-grid">
          <div class="price-card featured">
            <div class="p-tier">Retailer</div>
            <div class="p-amt billing-monthly">$99.99<small>/mo</small></div>
            <div class="p-amt billing-yearly">$66.67<small>/mo</small></div>
            <div class="p-yearly billing-monthly">or <strong>$799.99/yr</strong> &mdash; save 24%</div>
            <div class="p-yearly billing-yearly">$799.99 billed annually &mdash; save 24%</div>
            <div class="p-desc" style="margin-top:14px;">Import unlimited products and buy wholesale from hundreds of suppliers.</div>
            <ul class="p-feats">
              <li><?php echo $check_svg; // phpcs:ignore ?>Import unlimited products into your store</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Buy wholesale</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Access to hundreds of suppliers</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>No transaction fees &amp; no commissions</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Auto order fulfillment &amp; order tracking</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Priority e-mail support</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Onboarding call from an industry expert</li>
            </ul>
            <p style="font-size:.85rem;color:var(--ink-mute);margin-bottom:14px;">7-day free trial</p>
            <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-block">Start Free Trial</a>
          </div>

          <div class="price-card">
            <div class="p-tier">Supplier</div>
            <div class="p-amt billing-monthly">$49.99<small>/mo</small></div>
            <div class="p-amt billing-yearly">$41.67<small>/mo</small></div>
            <div class="p-yearly billing-monthly">or <strong>$499.99/yr</strong> &mdash; save 17%</div>
            <div class="p-yearly billing-yearly">$499.99 billed annually &mdash; save 17%</div>
            <div class="p-desc" style="margin-top:14px;">Supply unlimited products and sell wholesale to hundreds of retailers.</div>
            <ul class="p-feats">
              <li><?php echo $check_svg; // phpcs:ignore ?>Supply unlimited products</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Dropship &amp; sell your products wholesale</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Sell to hundreds of retailers</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>No transaction fees &amp; no commissions</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Auto order fulfillment &amp; order tracking</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Priority e-mail support</li>
              <li><?php echo $check_svg; // phpcs:ignore ?>Onboarding call from an industry expert</li>
            </ul>
            <p style="font-size:.85rem;color:var(--ink-mute);margin-bottom:14px;">7-day free trial</p>
            <a href="<?php echo esc_url( $register ); ?>" class="btn btn-outline btn-block">Start Free Trial</a>
          </div>
        </div>
      </div>
    </section>

    <!-- INCLUDED BANNER -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap center">
        <p class="eyebrow reveal" style="justify-content:center;">Included in every plan</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;font-size:clamp(2rem,4vw,3.4rem);">No Transaction Fees.<br>No Commissions.</h2>
        <div class="bento-tag-row reveal reveal-d2" style="justify-content:center;margin-top:40px;">
          <span class="bento-tag">7-day free trial</span>
          <span class="bento-tag">No transaction fees</span>
          <span class="bento-tag">No commissions</span>
          <span class="bento-tag">Auto order tracking</span>
          <span class="bento-tag">Priority support</span>
          <span class="bento-tag">Onboarding call</span>
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
            <button class="faq-q">Is there a free trial? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>Yes. Both the Retailer and Supplier plans include a 7-day free trial with full access &mdash; real-time order tracking, priority support, and the full catalog or retailer network.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">Are there transaction fees or commissions? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>No. SmokeDrop charges one flat monthly (or yearly) plan fee &mdash; no transaction fees and no commissions on anything you buy or sell.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">I'm a supplier or brand &mdash; what does it cost? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>The Supplier plan is $49.99/mo (or $499.99/yr, saving 17%), with no transaction fees or commissions on sales. <a href="<?php echo esc_url( $supply_url ); ?>" style="color:var(--green-xl);">Learn about becoming a supplier</a>.</p></div>
          </div>
          <div class="faq-item">
            <button class="faq-q">What's the difference between monthly and yearly billing? <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
            <div class="faq-a"><p>Same features either way. Paying yearly saves 24% on the Retailer plan and 17% on the Supplier plan compared to paying monthly. You can switch billing cycles anytime from your account.</p></div>
          </div>
        </div>
      </div>
    </section>

    <?php sdn_cta(); ?>

</main>

<script>
(function(){
  var toggle = document.getElementById('billing-toggle');
  var grid   = document.getElementById('price-grid');
  var mLabel = document.querySelector('.pt-label-monthly');
  var yLabel = document.querySelector('.pt-label-yearly');
  if (!toggle || !grid) return;
  function setYearly(yearly){
    grid.classList.toggle('is-yearly', yearly);
    toggle.classList.toggle('is-yearly', yearly);
    toggle.setAttribute('aria-pressed', yearly ? 'true' : 'false');
    if (mLabel) mLabel.classList.toggle('is-active', !yearly);
    if (yLabel) yLabel.classList.toggle('is-active', yearly);
  }
  toggle.addEventListener('click', function(){
    setYearly(!grid.classList.contains('is-yearly'));
  });
  // Keyboard a11y on the toggle.
  toggle.addEventListener('keydown', function(e){
    if (e.key === 'ArrowRight' || e.key === 'ArrowLeft'){ setYearly(e.key === 'ArrowRight'); e.preventDefault(); }
  });
})();
</script>

<?php
get_footer();
