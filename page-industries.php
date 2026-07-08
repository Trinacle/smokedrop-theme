<?php
/**
 * Template Name: Industries
 * Template Post Type: page
 *
 * Dropshipping by vertical — the industries SmokeDrop serves. Expanded to
 * cover every category the catalog touches, with real product photography
 * (no stock photos).
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$brands_url = home_url( '/brands' );
$uploads    = home_url( '/wp-content/uploads/' );

/**
 * Vertical cards. Each: [ tag, title, desc, image, [ stat => label, ... ] ]
 * Images are real /wp-content/uploads/ product photos (verified to resolve).
 */
$verticals = array(
    array(
        'tag'   => 'Headshop',
        'title' => 'Smoke shop &amp; headshop',
        'desc'  => 'Bongs, dab rigs, grinders, rolling papers, hand pipes, and storage. The deepest catalog in the category.',
        'img'   => $uploads . 'puffco.jpg',
        'stats' => array( '500+' => 'brands', '100+' => 'categories', '1,000+' => 'retailers' ),
    ),
    array(
        'tag'   => 'Vaporizers',
        'title' => 'Vapes &amp; vaporizers',
        'desc'  => 'Dry herb, concentrate, and e-liquid vaporizers, 510 batteries, disposables, coils, and replacement parts.',
        'img'   => $uploads . '4f7a4a09-90de-4cbd-805f-6a95736f3dbe.jpg',
        'stats' => array( '60+' => 'vape brands', '2,000+' => 'SKUs', 'USA' => 'warehoused' ),
    ),
    array(
        'tag'   => 'CBD &amp; Hemp',
        'title' => 'CBD, THCA &amp; hemp',
        'desc'  => 'Flower, prerolls, edibles, tinctures, topicals, and vape cartridges. Farm Bill compliant, hemp-derived.',
        'img'   => $uploads . '6000mg_front.jpg',
        'stats' => array( '1,000+' => 'SKUs', '50+' => 'brands', 'Farm Bill' => 'compliant' ),
    ),
    array(
        'tag'   => 'Glass &amp; Collectibles',
        'title' => 'Glass art &amp; collectibles',
        'desc'  => 'Heady glass, water pipes, quartz bangers, dab tools, and display-worthy collectible pieces.',
        'img'   => $uploads . 'f4c2b208-df8f-47a6-8c66-b9af80163520.jpg',
        'stats' => array( '40+' => 'glass artists', 'Hand-blown' => 'quality', 'Blind' => 'dropship' ),
    ),
    array(
        'tag'   => 'Lifestyle',
        'title' => 'Lifestyle &amp; accessories',
        'desc'  => 'Odor eliminators, candles, apparel, bags, and the accessories customers add to every order.',
        'img'   => $uploads . 'bcd1d5c2-47e4-496d-b338-fd4a78adfc3f.jpg',
        'stats' => array( '200+' => 'SKUs', 'High-margin' => 'add-ons', 'Fast' => 'movers' ),
    ),
    array(
        'tag'   => 'Adult',
        'title' => 'Adult novelty',
        'desc'  => 'Adult wellness and novelty products with discreet, blind dropshipping under your store&rsquo;s brand.',
        'img'   => $uploads . 'Snapinst.app_373306989_18384289906049392_5436773603243975300_n_1080-1024x1024.jpg',
        'stats' => array( 'Discreet' => 'packaging', 'Blind' => 'dropship', 'All 50' => 'states' ),
    ),
);
?>

<main>
    <section class="hero" style="min-height:auto;padding-top:180px;padding-bottom:60px;">
      <div class="hero-inner">
        <p class="eyebrow reveal">By industry</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Every category,<br><span class="italic gradient-text">one integration.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:640px;">From headshop staples to hemp, glass, and lifestyle &mdash; SmokeDrop covers the categories your customers already ask for, with vetted suppliers and blind dropshipping under your brand.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="industries">
          <?php foreach ( $verticals as $i => $v ) : ?>
            <a href="<?php echo esc_url( $brands_url ); ?>" class="ind-card reveal reveal-d<?php echo esc_attr( $i % 3 ); ?>" style="text-decoration:none;">
              <img src="<?php echo esc_url( $v['img'] ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $v['title'] ) ); ?>" loading="lazy">
              <div class="ind-inner">
                <span class="ind-tag"><?php echo $v['tag']; // contains an entity, ok to echo ?></span>
                <h3><?php echo $v['title']; // contains an entity ?></h3>
                <p><?php echo esc_html( $v['desc'] ); ?></p>
                <div class="ind-stats">
                  <?php foreach ( $v['stats'] as $n => $l ) : ?>
                    <div><div class="n"><?php echo esc_html( $n ); ?></div><div class="l"><?php echo esc_html( $l ); ?></div></div>
                  <?php endforeach; ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="center" style="max-width:760px;margin:0 auto 56px;">
          <p class="eyebrow reveal" style="justify-content:center;">Why suppliers choose SmokeDrop</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">One platform.<br><span class="italic gradient-text">Dropship and wholesale together.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time inventory sync</h4><p>Stock and price updates flow from suppliers to your store in under a minute, across every channel.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Automatic order fulfillment</h4><p>Orders route straight to the right supplier. Tracking numbers sync back to your store automatically.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h4>1-click catalog import</h4><p>Add curated brand collections to your store in a single click. No manual data entry, no image sourcing.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div><h4>Blind dropshipping</h4><p>Every order ships under your brand with white-label packing slips. Your customer never sees the supplier.</p></div>
          <div class="feat-card reveal reveal-d1"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg></div><h4>Vetted supplier network</h4><p>Every supplier is onboarded and vetted. Buy wholesale or dropship &mdash; whichever fits the order.</p></div>
          <div class="feat-card reveal reveal-d2"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg></div><h4>Shopify, WooCommerce &amp; BigCommerce</h4><p>Native plugins sync products, orders, and inventory across every major e-commerce platform.</p></div>
        </div>
        <div class="center" style="margin-top:56px;">
          <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg reveal">Start free trial</a>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
