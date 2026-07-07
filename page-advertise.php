<?php
/**
 * Template Name: Advertise
 * Template Post Type: page
 *
 * Ad-sales landing page for suppliers and brands. Uses the real ad packages
 * from thesmokedrop.com/advertise, with holiday-targeting messaging, an
 * all-in bundle (10% off), and value props for suppliers (sell more, faster)
 * and brands (exposure + growth). No fabricated stats.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_url = home_url( '/contact' );

// Real ad packages from the production site (verified prices).
$sdn_packages = array(
    array(
        'id'    => 'holiday',
        'name'  => 'Holiday Promo',
        'price' => '$200',
        'blurb' => 'Showcase your products in our Holiday Center during peak seasons &mdash; 420, 710, Black Friday, and more.',
        'desc'  => 'Capture shoppers exactly when they are buying. Tailor your products to specific holidays and appear in the dedicated Holiday Center, where seasonal demand is highest.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12v8H4v-8"/><path d="M2 7h20v5H2zM12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>',
    ),
    array(
        'id'    => 'featured',
        'name'  => 'Featured in Top of Category',
        'price' => '$350',
        'blurb' => 'Pin your products to the top of their category page &mdash; the first thing category browsers see.',
        'desc'  => 'When retailers browse a category, your products appear first. Highest-intent placement for buyers actively sourcing a specific product type.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
    ),
    array(
        'id'    => 'new-products',
        'name'  => 'New Products Promotion',
        'price' => '$400',
        'blurb' => 'Spotlight a new product launch and get it in front of buyers looking for what is fresh.',
        'desc'  => 'Launching something new? This puts your latest SKU in front of retailers who watch for new arrivals &mdash; the fastest way to seed a new product into the network.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>',
    ),
    array(
        'id'    => 'product-promo',
        'name'  => 'Product Promotion',
        'price' => '$500',
        'blurb' => 'Dedicated promotion for a single hero product across the marketplace.',
        'desc'  => 'Push one flagship product with dedicated placement and messaging &mdash; ideal for clearing stock, pushing a best-seller, or building a signature SKU.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg>',
    ),
    array(
        'id'    => 'category-boost',
        'name'  => 'Additional Category Boost',
        'price' => '$500',
        'blurb' => 'Appear in a second category so your product reaches more browsing buyers.',
        'desc'  => 'Products normally live in one category. This boost places them in an additional category, expanding the number of buyers who discover them.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg>',
    ),
    array(
        'id'    => 'retailer-dashboard',
        'name'  => 'Featured in Retailer Dashboard',
        'price' => '$650',
        'blurb' => 'Get placed inside the retailer dashboard &mdash; where buyers go to manage their store.',
        'desc'  => 'Your product appears inside the dashboard that active retailers use daily. The most consistent, high-visibility placement on the platform.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
    ),
    array(
        'id'    => 'brand-month',
        'name'  => 'Brand or Product of the Month',
        'price' => '$750',
        'blurb' => 'The flagship package &mdash; your brand or product spotlighted for an entire month.',
        'desc'  => 'The biggest spotlight we offer. Your brand or a single product becomes the featured focus for a full month across the marketplace, with premium placement throughout.',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
    ),
);

// All-in bundle: sum of all packages, 10% off.
$sdn_all_in_prices = array( 200, 350, 400, 500, 500, 650, 750 );
$sdn_all_in_total  = array_sum( $sdn_all_in_prices );      // 3350
$sdn_all_in_price  = round( $sdn_all_in_total * 0.9 );     // 3015
$sdn_all_in_save   = $sdn_all_in_total - $sdn_all_in_price; // 335
?>

<main>
  <!-- HERO -->
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Advertise with SmokeDrop</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">Sell more product,<br><span class="italic gradient-text">faster.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:640px;margin:0 auto;">Put your brand and products in front of smoke shop retailers the moment they are sourcing. Featured placements, holiday promotions, and dedicated spotlights &mdash; real packages, transparent pricing.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="#packages" class="btn btn-lime btn-lg">View packages</a>
        <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-outline btn-lg">Talk to Sales</a>
      </div>
    </div>
  </section>

  <!-- WHY ADVERTISE -->
  <section class="sec">
    <div class="wrap">
      <div style="max-width:780px;margin-bottom:56px;">
        <p class="eyebrow reveal">Why advertise on SmokeDrop</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Reach buyers who are<br><span class="italic gradient-text">already sourcing.</span></h2>
      </div>
      <div class="bento">
        <div class="bento-cell wide emerald reveal">
          <div class="inner"><p class="bento-eyebrow">For Suppliers</p><h3>Sell more, faster.</h3><p>Every SmokeDrop visitor is a retailer or wholesaler actively deciding what to stock. Advertising puts your catalog in front of them at the exact moment they are ready to buy &mdash; cutting your sales cycle and moving more product without lifting a finger on outreach.</p></div>
        </div>
        <div class="bento-cell lime reveal reveal-d1">
          <div class="inner"><p class="bento-eyebrow">For Brands</p><h3>Exposure &amp; growth.</h3><p>Get discovered by new retailers who have never heard of you, and stay top-of-mind with the ones who have. Build brand recognition across the network and grow your retail footprint.</p></div>
        </div>
        <div class="bento-cell dark reveal">
          <div class="inner"><p class="bento-eyebrow">Niche audience</p><h3>Smoke, vape &amp; hemp.</h3><p>100% of our audience is in your category. No wasted spend on generic marketplaces full of tire-kickers.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- HOLIDAY TARGETING -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap wrap-tight center">
      <p class="eyebrow reveal" style="justify-content:center;">Seasonal demand</p>
      <h2 class="display reveal reveal-d1" style="margin-top:24px;">Be there on the<br><span class="italic gradient-text">biggest selling days.</span></h2>
      <p class="lede reveal reveal-d2" style="max-width:600px;margin:24px auto 0;">The smoke industry has massive seasonal spikes. Our Holiday Promo puts you in front of buyers exactly when demand peaks.</p>
      <div class="holiday-grid reveal reveal-d3" style="margin-top:48px;">
        <div class="holiday-card">
          <span class="holiday-tag">April 20</span>
          <h3>420</h3>
          <p>The biggest day in cannabis culture &mdash; our highest-traffic week of the year.</p>
        </div>
        <div class="holiday-card">
          <span class="holiday-tag">July 10</span>
          <h3>710</h3>
          <p>Concentrate appreciation day &mdash; peak demand for dabs, wax, and extract gear.</p>
        </div>
        <div class="holiday-card">
          <span class="holiday-tag">November</span>
          <h3>Black Friday</h3>
          <p>Retailers stock up for the year&rsquo;s biggest shopping weekend. Be on their shortlist.</p>
        </div>
        <div class="holiday-card">
          <span class="holiday-tag">Year-round</span>
          <h3>+ more</h3>
          <p>Cyber Monday, Green Wednesday, harvest season, and new-product launch windows.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- AD PACKAGES -->
  <section class="sec" id="packages">
    <div class="wrap">
      <div class="center" style="max-width:760px;margin:0 auto 56px;">
        <p class="eyebrow reveal" style="justify-content:center;">Ad packages</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Choose your placement</h2>
        <p class="lede reveal reveal-d2" style="margin-top:16px;">Mix and match to fit your launch. Every placement is a one-time promotion &mdash; no long-term contract.</p>
      </div>
      <div class="ad-package-grid">
        <?php foreach ( $sdn_packages as $i => $pkg ) : ?>
          <div class="ad-package-card reveal<?php echo $i % 3 === 1 ? ' reveal-d1' : ''; ?><?php echo $i % 3 === 2 ? ' reveal-d2' : ''; ?>" id="<?php echo esc_attr( $pkg['id'] ); ?>">
            <div class="apc-icon"><?php echo $pkg['icon']; // phpcs:ignore ?></div>
            <h3 class="apc-name"><?php echo esc_html( $pkg['name'] ); ?></h3>
            <div class="apc-price"><?php echo esc_html( $pkg['price'] ); ?></div>
            <p class="apc-blurb"><?php echo $pkg['blurb']; // contains an entity ?></p>
            <p class="apc-desc"><?php echo esc_html( $pkg['desc'] ); ?></p>
            <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-outline btn-block apc-cta">Get this package</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ALL-IN BUNDLE -->
  <section class="sec" id="all-in">
    <div class="wrap">
      <div class="bento-cell full reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));border:1px solid var(--green-l);min-height:auto;">
        <div class="inner" style="padding:clamp(40px,6vw,64px);align-items:center;text-align:center;">
          <p class="bento-eyebrow" style="color:rgba(255,255,255,.8);">Maximum reach</p>
          <h2 class="display reveal" style="font-size:clamp(1.8rem,3.5vw,2.8rem);color:#fff;margin-top:16px;">The All-In Bundle</h2>
          <p class="lede reveal reveal-d1" style="color:rgba(255,255,255,.82);max-width:620px;margin:20px auto 0;">Every package, combined for maximum exposure across the entire marketplace. Holiday promo, top-of-category, new products, retailer dashboard, brand of the month &mdash; all of it.</p>
          <div class="all-in-pricing reveal reveal-d2">
            <div class="aip-total"><span class="aip-strike">$<?php echo (int) $sdn_all_in_total; ?></span> <strong>$<?php echo (int) $sdn_all_in_price; ?></strong></div>
            <span class="aip-save">You save $<?php echo (int) $sdn_all_in_save; ?> (10%)</span>
          </div>
          <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg reveal reveal-d3" style="background:#fff;color:var(--green);margin-top:32px;">Get the All-In Bundle</a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="sec" style="background:var(--bg-2);">
    <div class="wrap wrap-tight center">
      <p class="eyebrow reveal" style="justify-content:center;">Get started</p>
      <h2 class="display reveal reveal-d1" style="margin-top:24px;">Ready to move more product?</h2>
      <p class="lede reveal reveal-d2" style="max-width:560px;margin:24px auto 0;">Talk to our team about which package fits your launch &mdash; or build a custom combination.</p>
      <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg reveal reveal-d3" style="margin-top:32px;">Talk to Sales</a>
    </div>
  </section>
</main>

<?php
get_footer();
