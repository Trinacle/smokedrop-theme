<?php
/**
 * Template Name: Advertise
 * Template Post Type: page
 *
 * Landing page selling ad inventory to suppliers/brands: featured listings,
 * homepage takeovers, newsletter sponsorship, sponsored content, retargeting.
 * Replaces the old /compare/ page. Assign to the Page at /advertise/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_url = home_url( '/contact' );
$register    = 'https://wholesale.thesmokedrop.com/register';

// Ad format data.
$sdn_ad_formats = array(
    array(
        'id'    => 'featured',
        'name'  => 'Featured Listings',
        'price' => 'From $199/mo',
        'desc'  => 'Pin your products to the top of search results and category pages. The highest-intent placement — buyers searching for your category see you first.',
        'bullets' => array( 'Top of search &amp; category', 'Up to 12 featured SKUs', 'Click-through analytics', 'Swap products monthly' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    ),
    array(
        'id'    => 'homepage',
        'name'  => 'Homepage Takeovers',
        'price' => 'From $499/mo',
        'desc'  => 'Own the SmokeDrop homepage. Logo wall placement, hero feature, and a branded bento card — the first thing every visitor sees.',
        'bullets' => array( 'Logo wall placement', 'Hero feature slot', 'Branded bento card', 'Premium visibility' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
    ),
    array(
        'id'    => 'newsletter',
        'name'  => 'Newsletter Sponsorship',
        'price' => 'From $299/send',
        'desc'  => 'Reach 1,000+ active smoke shop retailers directly in their inbox. Dedicated sends or featured slots in our weekly dropshipping digest.',
        'bullets' => array( '1,000+ retailer subscribers', 'Dedicated or featured send', 'Open rate 38%+', 'List-segment options' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
    ),
    array(
        'id'    => 'sponsored',
        'name'  => 'Sponsored Content',
        'price' => 'From $399/article',
        'desc'  => 'Brand spotlights, product launches, and educational guides published on the SmokeDrop blog — permanent, SEO-indexed content that ranks.',
        'bullets' => array( 'Brand spotlight article', 'Product launch feature', 'Educational guide', 'Permanent + SEO-indexed' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/></svg>',
    ),
    array(
        'id'    => 'retargeting',
        'name'  => 'Retargeting &amp; Display',
        'price' => 'From $399/mo',
        'desc'  => 'Follow buyers across the web. Retarget retailers who viewed your products with display ads on our partner network.',
        'bullets' => array( 'Retarget product viewers', 'Display network reach', 'Frequency capping', 'Conversion tracking' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>',
    ),
    array(
        'id'    => 'bundle',
        'name'  => 'Custom Bundles',
        'price' => 'Talk to sales',
        'desc'  => 'Combine formats into a quarterly or annual campaign. Our team builds a custom package around your launch calendar and budget.',
        'bullets' => array( 'Multi-format campaign', 'Quarterly/annual pricing', 'Dedicated account manager', 'Custom creative' ),
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
    ),
);
?>

<main>
  <!-- HERO -->
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Advertise with SmokeDrop</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">Reach 1,000+ active<br><span class="italic gradient-text">smoke shop retailers.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:640px;margin:0 auto;">Put your brand in front of the buyers actively sourcing products to stock and dropship. Featured listings, homepage takeovers, newsletter sponsorship, sponsored content, and retargeting &mdash; from $199/mo, no long-term contract.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg">Talk to Sales</a>
        <a href="#formats" class="btn btn-outline btn-lg">See ad formats</a>
      </div>
    </div>
  </section>

  <!-- AUDIENCE STATS -->
  <section class="sec-sm" style="background:#13c27b;">
    <div class="wrap">
      <div class="scale-stats">
        <div class="ss reveal"><div class="n" style="color:#000;font-weight:800;">1,000+</div><div class="l" style="color:#000;font-weight:600;">Active retailers</div></div>
        <div class="ss reveal reveal-d1"><div class="n" style="color:#000;font-weight:800;">20K+</div><div class="l" style="color:#000;font-weight:600;">Monthly product views</div></div>
        <div class="ss reveal reveal-d2"><div class="n" style="color:#000;font-weight:800;">38%</div><div class="l" style="color:#000;font-weight:600;">Newsletter open rate</div></div>
        <div class="ss reveal reveal-d3"><div class="n" style="color:#000;font-weight:800;">300+</div><div class="l" style="color:#000;font-weight:600;">Brands on network</div></div>
      </div>
    </div>
  </section>

  <!-- AD FORMATS -->
  <section class="sec" id="formats">
    <div class="wrap">
      <div class="center" style="max-width:760px;margin:0 auto 56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Ad formats</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Choose your placement</h2>
        <p class="lede reveal reveal-d2" style="margin-top:16px;">Mix and match formats to fit your launch. Every placement includes impression and click-through analytics.</p>
      </div>
      <div class="feat-grid">
        <?php foreach ( $sdn_ad_formats as $i => $ad ) : ?>
          <div class="feat-card reveal<?php echo $i % 3 === 1 ? ' reveal-d1' : ''; ?><?php echo $i % 3 === 2 ? ' reveal-d2' : ''; ?>" id="<?php echo esc_attr( $ad['id'] ); ?>">
            <div class="fc-ico"><?php echo $ad['icon']; // phpcs:ignore ?></div>
            <h4><?php echo $ad['name']; // contains an entity in one entry ?></h4>
            <p style="color:var(--green-xl);font-family:var(--display);font-weight:600;font-size:.95rem;margin-bottom:10px;"><?php echo esc_html( $ad['price'] ); ?></p>
            <p><?php echo esc_html( $ad['desc'] ); ?></p>
            <ul style="list-style:none;padding:0;margin:14px 0 0;display:flex;flex-direction:column;gap:6px;">
              <?php foreach ( $ad['bullets'] as $bl ) : ?>
                <li style="font-size:.85rem;color:var(--ink-dim);display:flex;gap:8px;align-items:flex-start;">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;color:var(--green-xl);flex-shrink:0;margin-top:3px;"><polyline points="20 6 9 17 4 12"/></svg>
                  <span><?php echo $bl; // contains an entity ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- WHY ADVERTISE -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap">
      <div style="max-width:780px;margin-bottom:56px;">
        <p class="eyebrow reveal">Why advertise on SmokeDrop</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">The audience is<br><span class="italic gradient-text">already buying.</span></h2>
      </div>
      <div class="bento">
        <div class="bento-cell wide emerald reveal">
          <div class="inner"><p class="bento-eyebrow">High-intent audience</p><h3>Buyers, not browsers.</h3><p>Every SmokeDrop visitor is a retailer or wholesaler actively sourcing products to stock or dropship. You're not paying for tire-kickers &mdash; you're paying for purchase-ready eyes.</p></div>
        </div>
        <div class="bento-cell lime reveal reveal-d1">
          <div class="inner"><p class="bento-eyebrow">Niche reach</p><h3>Smoke, vape &amp; hemp only.</h3><p>No wasted spend on generic marketplaces. 100% of our audience is in your category.</p></div>
        </div>
        <div class="bento-cell dark reveal">
          <div class="inner"><p class="bento-eyebrow">Transparent</p><h3>Analytics on every placement.</h3><p>Impressions, clicks, and conversions for every ad. Know exactly what your spend delivered.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="sec">
    <div class="wrap">
      <div class="bento-cell full reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));border:1px solid var(--green-l);min-height:auto;">
        <div class="inner" style="padding:clamp(48px,7vw,80px);align-items:center;text-align:center;">
          <h2 class="display" style="font-size:clamp(2rem,4vw,3.4rem);color:#fff;">Ready to reach 1,000+ retailers?</h2>
          <p class="lede" style="max-width:560px;margin:24px auto 0;color:rgba(255,255,255,.82);">Talk to our team and build a custom ad package around your launch. From $199/mo, no long-term contract.</p>
          <div class="hero-actions" style="justify-content:center;margin-top:36px;">
            <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg" style="background:#fff;color:var(--green);">Talk to Sales</a>
            <a href="<?php echo esc_url( $register ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,.3);color:#fff;">Become a supplier</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
