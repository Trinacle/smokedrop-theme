<?php
/**
 * Template Name: About
 * Template Post Type: page
 *
 * About page. Copy here is limited to verified facts (product/brand
 * counts, real testimonials, real address) -- no invented founding date
 * or team bios, since none exist on the live site to confirm against.
 * Assign this template to the WordPress Page mapped to /about/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url = home_url( '/suppliers' );
$retail_url = home_url( '/retailers' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">About SmokeDrop</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">One marketplace.<br><span class="italic gradient-text">Every smoke shop.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:640px;margin:0 auto;">SmokeDrop connects retailers and suppliers in the smoke, vape, and hemp industry &mdash; one integration, hundreds of brands, real-time order sync.</p>
      </div>
    </section>

    <!-- STATS -->
    <section class="sec-sm" style="background:#13c27b;">
      <div class="wrap">
        <div class="scale-stats">
          <div class="ss reveal"><div class="n" style="color:#000;font-weight:800;"><span data-count="20000" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Smoke shop products</div></div>
          <div class="ss reveal reveal-d1"><div class="n" style="color:#000;font-weight:800;"><span data-count="300" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Top brands</div></div>
          <div class="ss reveal reveal-d2"><div class="n" style="color:#000;font-weight:800;">Real Time</div><div class="l" style="color:#000;font-weight:600;">Order sync</div></div>
          <div class="ss reveal reveal-d3"><div class="n" style="color:#000;font-weight:800;">$0</div><div class="l" style="color:#000;font-weight:600;">Transaction fees</div></div>
        </div>
      </div>
    </section>

    <!-- WHAT WE DO -->
    <section class="sec">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:56px;">
          <p class="eyebrow reveal">What we do</p>
          <h2 class="display reveal reveal-d1" style="margin-top:20px;">The marketplace that connects<br>both sides of the shelf.</h2>
        </div>
        <div class="bento">
          <div class="bento-cell dark reveal">
            <div class="inner">
              <h3>For Retailers</h3>
              <p>Import unlimited products from hundreds of suppliers, sync inventory and order tracking automatically, and buy wholesale &mdash; no transaction fees, no commissions.</p>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner">
              <h3>For Suppliers &amp; Wholesalers</h3>
              <p>List your catalog once and reach hundreds of smoke shops and online retailers. Fully automated order management, easy catalog import.</p>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d2">
            <div class="inner">
              <h3>One integration</h3>
              <p>Shopify, WooCommerce, and BigCommerce &mdash; connect your store once and every order, tracking number, and inventory update syncs automatically.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap wrap-tight center">
        <p class="eyebrow reveal" style="justify-content:center;">What retailers say</p>
        <blockquote class="reveal reveal-d1" style="font-family:var(--display);font-size:clamp(1.4rem,3vw,2.1rem);font-weight:500;letter-spacing:-.02em;line-height:1.35;margin-top:24px;">
          &ldquo;I am new to the business and was a bit apprehensive until I found Smoke Drop. They have a great catalogue of quality products and an extremely user-friendly set-up. Maybe even better than that, is their customer service.&rdquo;
        </blockquote>
        <p class="reveal reveal-d2" style="margin-top:20px;color:var(--ink-mute);"><strong style="color:var(--ink);">Session Glass</strong> &mdash; Online Retailer</p>
      </div>
    </section>

    <!-- CTA -->
    <section class="sec-sm">
      <div class="wrap">
        <div class="cta-bg reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));">
          <div class="inner">
            <h2 class="display" style="color:#fff;">Ready to get started?</h2>
            <p class="lede">Join as a retailer or a wholesaler &mdash; both start with a 7-day free trial.</p>
            <div class="hero-actions">
              <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg">Start Free Trial</a>
              <a href="<?php echo esc_url( $retail_url ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.3);color:#fff;">For Retailers</a>
            </div>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
