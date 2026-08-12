<?php
/**
 * The front page — SmokeDrop homepage.
 *
 * Renders automatically for the page set as
 * "Settings > Reading > Your homepage displays > A static page".
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$shop_url    = get_post_type_archive_link( 'product' ) ?: home_url( '/shop' );
$brands_url  = home_url( '/brands' );
$blog_url    = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/dropshipping-blog' );
$contact_url = home_url( '/contact' );
$pricing_url = home_url( '/pricing' );
$retail_url  = home_url( '/retailers' );
$supply_url  = home_url( '/suppliers' );

// Real integration logo URLs (verified working on thesmokedrop.com)
$sdu = function ( $path ) { return home_url( '/wp-content/uploads/2024/01/' . $path ); };
?>

<main>

    <!-- ===== VIMEO VIDEO SECTION (standalone, no overlay) ===== -->
    <section class="video-section">
      <div class="vimeo-bg">
        <iframe src="https://player.vimeo.com/video/1164525650?background=1&autoplay=1&loop=1&byline=0&title=0&muted=1" allow="autoplay; fullscreen" allowfullscreen loading="lazy"></iframe>
      </div>
    </section>

    <!-- ===== HERO (below the video) ===== -->
    <section class="hero" id="hero">
      <div class="hero-inner">
        <p class="eyebrow reveal">#1 Online Smoke Shop Dropshipping App</p>
        <h1 class="display-mega">
          <span class="line-mask"><span>The industry</span></span>
          <span class="line-mask line-mask-d1"><span>leading <em class="italic gradient-text">dropship</em></span></span>
          <span class="line-mask line-mask-d2"><span>marketplace.</span></span>
        </h1>

        <!-- Flip text: rotating product categories -->
        <div class="hero-flip reveal reveal-d3">
          <span class="hf-prefix">Thousands of</span>
          <div id="flip" class="hf-flip">
            <div>
              <div>Dab Rigs</div>
              <div>Pipes</div>
              <div>Bongs</div>
              <div>Vaporizers</div>
              <div>Ashtrays</div>
              <div>Grinders</div>
              <div>Vape Pens</div>
              <div>Gummies</div>
              <div>Bowls</div>
              <div>Dab Straws</div>
              <div>E-Rigs</div>
            </div>
          </div>
          <span class="hf-suffix">Available</span>
        </div>

        <p class="lede reveal reveal-d4">Import over 20,000 smoke shop products to your online store. The dropshipping platform built for smoke shops &mdash; connect to 300+ smoke, vape, hemp and glass brands. Customers order from you. Suppliers ship for you. You keep the margin.</p>
        <div class="hero-actions reveal reveal-d5">
          <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg" data-magnetic>Start Free Trial <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
          <a href="#how" class="btn btn-outline btn-lg" data-magnetic>See how it works</a>
        </div>
      </div>
    </section>

    <!-- ===== WHITE BRAND LOGO WALL (crowdship-style) ===== -->
    <section class="logo-wall-white reveal">
      <div class="lw-head">
        <span class="lw-eyebrow">The SmokeDrop Marketplace</span>
        <h2>300+ brands.<br>One integration.</h2>
        <p>Get instant access to the deepest smoke, vape &amp; hemp catalog in the industry. The brands your customers already ask for &mdash; ready to dropship.</p>
        <div class="lw-stats">
          <div class="lw-stat"><div class="n">300+</div><div class="l">Brands</div></div>
          <div class="lw-stat"><div class="n">20,000+</div><div class="l">Products</div></div>
          <div class="lw-stat"><div class="n">400+</div><div class="l">Collections</div></div>
          <div class="lw-stat"><div class="n">1,000+</div><div class="l">New SKUs/month</div></div>
        </div>
      </div>
      <?php
      $sdn_all_brands  = sdn_real_brand_logos();
      $sdn_brand_row1  = array_slice( $sdn_all_brands, 0, 8 );
      $sdn_brand_row2  = array_slice( $sdn_all_brands, 8 );
      ?>
      <div class="lw-wall">
        <div class="lw-row">
          <?php for ( $r1 = 0; $r1 < 2; $r1++ ) : foreach ( $sdn_brand_row1 as $b ) : ?>
            <a class="lgo" href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></a>
          <?php endforeach; endfor; ?>
        </div>
        <div class="lw-row rev" style="margin-top:40px;">
          <?php for ( $r2 = 0; $r2 < 2; $r2++ ) : foreach ( $sdn_brand_row2 as $b ) : ?>
            <a class="lgo" href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['file'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></a>
          <?php endforeach; endfor; ?>
        </div>
      </div>
      <div class="lw-foot">
        <a href="<?php echo esc_url( $brands_url ); ?>">View all 300+ brands <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </section>

    <!-- ===== PRODUCTS SECTION (real copy from thesmokedrop.com) ===== -->
    <section class="sec" id="products">
      <div class="wrap center">
        <p class="eyebrow reveal" style="justify-content:center;">Products Available for Dropshipping &amp; Wholesale</p>
        <h2 class="display reveal reveal-d1" style="margin-top:20px;">Dropship thousands of water pipes,<br>vape, &amp; CBD products, <span class="italic gradient-text">all in one place.</span></h2>
        <p class="lede reveal reveal-d2" style="max-width:620px;margin:28px auto 0;">We carry all the latest items from the top brands. Import products to your online store in just a few clicks, with automatic order syncing with suppliers.</p>
        <div class="feat-grid reveal reveal-d3" style="margin-top:56px;text-align:left;max-width:900px;margin-left:auto;margin-right:auto;">
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg></div><h4>Start Selling Today</h4><p>Import to your online store in just few clicks. Automatic order syncing with suppliers. We carry all the latest items from the top brands.</p></div>
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Become a Supplier</h4><p>Fully automated order management. Easy &amp; fast catalog import. Seamless product import &amp; order fulfillment.</p></div>
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Automatic Order Fulfillment</h4><p>Easily manage orders in your Shopify or WooCommerce. Tracking numbers sync across suppliers, retailers &amp; customers.</p></div>
        </div>
        <a href="<?php echo esc_url( $shop_url ); ?>" class="btn btn-lime btn-lg reveal reveal-d4" style="margin-top:40px;">Browse the catalog</a>
      </div>
    </section>

    <!-- ===== DUAL SELL: RETAILERS + SUPPLIERS ===== -->
    <section class="sec" id="retailers">
      <div class="wrap">
        <div style="max-width:820px;margin-bottom:64px;">
          <p class="eyebrow reveal">Built for everyone in the chain</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Whether you sell<br>or supply, <span class="italic gradient-text">we move product.</span></h2>
        </div>
        <div class="dual">
          <!-- Retailers -->
          <div class="dual-card retailer reveal">
            <span class="tag">For Retailers</span>
            <h3>Become the next online success story.</h3>
            <p class="lede">Control everything from your shopping cart, including inventory, order management, and pricing. Stock 20,000+ SKUs with zero inventory.</p>
            <ul class="checks">
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Auto-sync inventory to Shopify, WooCommerce, BigCommerce</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Blind dropshipping, ships under your brand</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>We carry the latest items from the top brands</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>No contracts, no minimums, no warehouse</span></li>
            </ul>
            <div class="cta-row">
              <a href="<?php echo esc_url( $retail_url ); ?>" class="btn btn-lime btn-lg" data-magnetic style="background:#fff;color:var(--green);">I'm a retailer <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
          <!-- Suppliers -->
          <div class="dual-card supplier reveal reveal-d1">
            <span class="tag">For Suppliers</span>
            <h3>Get your products in front of thousands of retailers.</h3>
            <p class="lede">List your catalog once and reach hundreds of retailers. SmokeDrop handles the listings, orders, payments, and routing. You focus on fulfillment.</p>
            <ul class="checks">
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Reach hundreds of retailers with one integration</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Automated ordering straight to your fulfillment</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Demand analytics and order automation built in</span></li>
              <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>Fast, transparent payouts, no listing fees</span></li>
            </ul>
            <div class="cta-row">
              <a href="<?php echo esc_url( $supply_url ); ?>" class="btn btn-lime btn-lg" data-magnetic>I'm a supplier <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== FEATURES GRID (comprehensive) ===== -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div style="max-width:820px;margin-bottom:64px;">
          <p class="eyebrow reveal">Every feature, included</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">One platform.<br><span class="italic gradient-text">Every workflow.</span></h2>
        </div>
        <div class="feat-grid">
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></div><h4>Real-time inventory sync</h4><p>Sub-minute stock &amp; price updates across every channel.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div><h4>Supplier onboarding</h4><p>Invite and vet suppliers with a self-serve portal.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 7h13l4 4v6h-3"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg></div><h4>Automatic order fulfillment</h4><p>Orders sync automatically with suppliers. Tracking numbers update across everyone.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></div><h4>Branded packing slips</h4><p>White-label every order with your logo and insert cards.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l3-3 3 2 4-5"/></svg></div><h4>Analytics &amp; reporting</h4><p>Profit per SKU, supplier-level, SKU-level, export raw data.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11a8 8 0 0 1-12 7l-5 1 1-5a8 8 0 1 1 16-3z"/><path d="M9 11h.01"/><path d="M13 11h.01"/><path d="M17 11h.01"/></svg></div><h4>In-app support &amp; live chat</h4><p>Reach our support team with live chat, right inside the platform.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg></div><h4>REST API &amp; EDI</h4><p>Custom integrations via API, CSV/FTP, and EDI-X12.</p></div>
          <div class="feat-card reveal"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></div><h4>1-click import</h4><p>Add curated collections to your store in a single click.</p></div>
        </div>
      </div>
    </section>


    <!-- ===== BENTO: THE PLATFORM ===== -->
    <section class="sec" id="sync" style="background:var(--bg-2);">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:72px;">
          <p class="eyebrow reveal">The platform</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Built for smoke shops<br><span class="outline-text italic">that want to grow.</span></h2>
        </div>

        <div class="bento">
          <div class="bento-cell wide emerald reveal">
            <div class="inner">
              <p class="bento-eyebrow">Real-time sync</p>
              <h3>Never oversell.<br>Never refund out-of-stock.</h3>
              <p>Every supplier's stock, price, and detail flows into your store the instant it changes. Sub-minute updates across every channel, 24/7.</p>
            </div>
          </div>
          <div class="bento-cell lime reveal reveal-d1">
            <div class="inner">
              <p class="bento-eyebrow">300+ brands</p>
              <h3>The catalog competitors wish they had.</h3>
              <p>PAX, Puffco, Cookies, GRAV, RAW, Dr. Dabber and hundreds more. Import curated collections in one click.</p>
              <div class="bento-tag-row">
                <span class="bento-tag">Vaporizers</span>
                <span class="bento-tag">Hemp</span>
                <span class="bento-tag">Glass</span>
                <span class="bento-tag">Accessories</span>
              </div>
            </div>
          </div>
          <div class="bento-cell dark reveal">
            <div class="inner">
              <p class="bento-eyebrow">Blind dropship</p>
              <h3>Ships under your brand.</h3>
              <p>Orders route to the right supplier and ship blind under your brand. Your customer never sees our name.</p>
              <div class="bento-visual">
                <svg viewBox="0 0 320 100" style="width:100%;max-width:300px;"><path d="M3,70 L80,70 M80,70 L80,20 L200,20 L200,70 M200,70 L317,70" stroke="rgba(255,255,255,.2)" stroke-width="2.5" fill="none" stroke-linecap="round"/><rect x="80" y="20" width="120" height="50" rx="6" fill="rgba(255,255,255,.04)" stroke="rgba(255,255,255,.2)" stroke-width="2.5"/><path d="M95,40 L140,40 M95,52 L160,52" stroke="var(--green-xl)" stroke-width="2.5" stroke-linecap="round"/><circle cx="280" cy="70" r="10" fill="var(--green-xl)"/><path d="M275,70 L279,74 L286,66" stroke="#0a0b0a" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </div>
            </div>
          </div>
          <div class="bento-cell wide dark reveal reveal-d1">
            <div class="inner">
              <p class="bento-eyebrow">Inventory, synced</p>
              <h3>Sync your inventory so you never sell what you don't have.</h3>
              <p>Tracking numbers are synced across suppliers, retailers, and customers. Our inventory sync feature helps you maintain accuracy, so you never have to worry about selling products that are out of stock.</p>
              <div class="bento-tag-row">
                <span class="bento-tag">&#10003; Real-time sync</span>
                <span class="bento-tag">&#10003; Automatic tracking</span>
                <span class="bento-tag">&#10003; Never oversell</span>
              </div>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner">
              <p class="bento-eyebrow">Wholesale pricing</p>
              <h3>Transparent margins.</h3>
              <p>See cost and suggested retail before you import. Your price, your call.</p>
            </div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner">
              <p class="bento-eyebrow">Analytics</p>
              <h3>Know your winners.</h3>
              <p>Profit per SKU, best-sellers, reorder trends. Double down on what sells.</p>
              <div class="bento-visual">
                <svg viewBox="0 0 360 110" style="width:100%;max-width:320px;"><g><rect x="0" y="60" width="40" height="50" rx="5" fill="rgba(19,194,123,.25)"/><rect x="50" y="40" width="40" height="70" rx="5" fill="rgba(19,194,123,.4)"/><rect x="100" y="20" width="40" height="90" rx="5" fill="rgba(19,194,123,.6)"/><rect x="150" y="35" width="40" height="75" rx="5" fill="rgba(19,194,123,.45)"/><rect x="200" y="10" width="40" height="100" rx="5" fill="var(--green-xl)"/><rect x="250" y="50" width="40" height="60" rx="5" fill="rgba(19,194,123,.35)"/><rect x="300" y="25" width="40" height="85" rx="5" fill="rgba(19,194,123,.55)"/></g></svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SCALE STATS BAND (full-width #13c27b, all black text) ===== -->
    <section class="sec-sm" style="background:#13c27b;">
      <div class="wrap">
        <div class="scale-stats">
          <div class="ss reveal"><div class="n" style="color:#000;font-weight:800;"><span data-count="20000" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Smoke shop products</div></div>
          <div class="ss reveal reveal-d1"><div class="n" style="color:#000;font-weight:800;"><span data-count="300" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Top brands</div></div>
          <div class="ss reveal reveal-d2"><div class="n" style="color:#000;font-weight:800;"><span data-count="30" data-suffix="+">0</span></div><div class="l" style="color:#000;font-weight:600;">Countries shipped to</div></div>
          <div class="ss reveal reveal-d3"><div class="n" style="color:#000;font-weight:800;">Real Time</div><div class="l" style="color:#000;font-weight:600;">Order sync</div></div>
        </div>
      </div>
    </section>

    <!-- ===== GETTING STARTED ===== -->
    <section class="sec" id="getting-started">
      <div class="wrap">
        <div style="max-width:780px;margin-bottom:64px;">
          <p class="eyebrow reveal">Getting Started</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Live in <span class="italic gradient-text">three steps.</span></h2>
          <p class="lede reveal reveal-d2" style="margin-top:20px;">From sign-up to first sale in under an hour. No warehouse, no upfront inventory, no developer required.</p>
        </div>
        <div class="getting-started">
          <div class="gs-card reveal">
            <span class="gs-num">01</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c0 5-3.5 8-9 10-5.5-2-9-5-9-10V6l9-4 9 4z"/></svg></div>
            <h4>Create your SmokeDrop account</h4>
            <p>Start your 7-day free trial as a retailer or supplier at wholesale.thesmokedrop.com. Takes less than a minute to get started.</p>
          </div>
          <div class="gs-card reveal reveal-d1">
            <span class="gs-num">02</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 10v4M10 10v4M14 10v4M18 10v4"/></svg></div>
            <h4>Add the app to your store</h4>
            <p><strong>Shopify:</strong> Install the SmokeDrop app from the Shopify App Store. <strong>WooCommerce:</strong> Download the SmokeDrop WordPress plugin. <strong>BigCommerce:</strong> Install from the BigCommerce marketplace. One click links your store.</p>
          </div>
          <div class="gs-card reveal reveal-d2">
            <span class="gs-num">03</span>
            <div class="gs-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg></div>
            <h4>Import products &amp; start selling</h4>
            <p>Browse 20,000+ products from 300+ brands. Import curated collections with a click, set your retail prices, and orders sync automatically with suppliers.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== SOLUTIONS BY COMPANY SIZE ===== -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="max-width:760px;margin:0 auto 56px;">
          <p class="eyebrow reveal" style="justify-content:center;">From the Shopify App Store</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">What retailers say.</h2>
        </div>
        <div class="testi-grid">
          <div class="testi-card reveal">
            <div class="tc-mark">DV</div>
            <blockquote>"I really love you guys. I was having a very difficult time finding the right products to sell and what to sell exactly. I came up on this app and now my shop is flourishing. No complaints so far. Thanks guys"</blockquote>
            <div class="tc-author"><div><strong>The Darth Vapor</strong><span>Online Retailer</span></div></div>
          </div>
          <div class="testi-card reveal reveal-d1">
            <div class="tc-mark" style="background:linear-gradient(145deg,#0a6b3f,#13c27b);">SG</div>
            <blockquote>"I am new to the business and was a bit apprehensive until I found Smoke Drop. They have a great catalogue of quality products and an extremely user-friendly set-up. Maybe even better than that, is their customer service. I highly recommend this app!"</blockquote>
            <div class="tc-author"><div><strong>Session Glass</strong><span>Online Retailer</span></div></div>
          </div>
          <div class="testi-card reveal reveal-d2">
            <div class="tc-mark" style="background:linear-gradient(145deg,#004122,#0a6b3f);">MR</div>
            <blockquote>"As someone who uses Smoke Drop to sell on one accounts and dropship from another, this app is great! It helps streamline my dropshipping side of the business and it also lets me find vendor and products quick."</blockquote>
            <div class="tc-author"><div><strong>My Rolling Tray</strong><span>Online Retailer</span></div></div>
          </div>
        </div>
        <div class="center reveal reveal-d3" style="margin-top:40px;">
          <a href="https://apps.shopify.com/smoke-drop" class="link-arrow" style="font-size:1.05rem;">Read more reviews on the Shopify App Store <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>
    </section>

    <!-- ===== FEATURED PRODUCTS ===== -->
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:24px;margin-bottom:56px;">
          <div>
            <p class="eyebrow reveal">Featured products</p>
            <h2 class="h-sec reveal reveal-d1" style="margin-top:18px;">The latest items from<br><span class="italic gradient-text">the top brands.</span></h2>
            <p class="lede reveal reveal-d2" style="margin-top:18px;max-width:540px;">Browse water pipes, vaporizers, CBD, and accessories. Import to your store with transparent wholesale pricing.</p>
          </div>
          <a href="<?php echo esc_url( $shop_url ); ?>" class="link-arrow reveal reveal-d3">Explore the catalog <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
        <?php
        // Pull real featured/on-sale products if WooCommerce is active; else fall back to a curated card grid.
        $featured = function_exists( 'wc_get_products' ) ? wc_get_products( array(
            'status'  => 'publish',
            'limit'   => 4,
            'orderby' => 'date',
            'order'   => 'DESC',
        ) ) : array();

        if ( ! empty( $featured ) ) :
            $delays = array( '', ' reveal-d1', ' reveal-d2', ' reveal-d3' );
            echo '<div class="market">';
            foreach ( $featured as $i => $product ) :
                $p        = $product->get_id();
                $title    = $product->get_name();
                $cat_terms = get_the_terms( $p, 'product_cat' );
                $cat_text  = ( $cat_terms && ! is_wp_error( $cat_terms ) )
                    ? wp_strip_all_tags( implode( ', ', wp_list_pluck( $cat_terms, 'name' ) ) )
                    : 'Smoke Shop';
                $img      = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80';
                $brands   = wp_get_post_terms( $p, 'product_brand', array( 'fields' => 'names' ) );
                $brand    = ! empty( $brands ) && ! is_wp_error( $brands ) ? $brands[0] : 'SmokeDrop';
                ?>
                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="market-card reveal<?php echo esc_attr( $delays[ $i % 4 ] ); ?>" style="text-decoration:none;color:inherit;">
                  <div class="mimg"><span class="flag">&#127482;&#127480; USA</span><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy"></div>
                  <div class="mbody">
                    <span class="mbrand"><?php echo esc_html( $brand ); ?></span>
                    <h4><?php echo esc_html( $title ); ?></h4>
                    <div class="mprice-row">
                      <div class="mprice"><div class="lbl">Category</div><div class="val" style="font-size:1rem;"><?php echo esc_html( $cat_text ); ?></div></div>
                      <div class="margin"><strong>View</strong>wholesale</div>
                    </div>
                    <span class="add">View pricing <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                  </div>
                </a>
                <?php
            endforeach;
            echo '</div>';
        else :
            // Static fallback (no products yet)
            ?>
            <div class="market">
              <a href="<?php echo esc_url( $brands_url ); ?>" class="market-card reveal" style="text-decoration:none;color:inherit;">
                <div class="mimg"><span class="flag">&#127482;&#127480; USA</span><img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=600&q=80" alt="Vessel product" loading="lazy"></div>
                <div class="mbody"><span class="mbrand">Vessel</span><h4>Vessel Pipe &mdash; Emerald</h4>
                  <div class="mprice-row"><div class="mprice"><div class="lbl">Category</div><div class="val" style="font-size:1rem;">Water Pipes</div></div><div class="margin"><strong>View</strong>wholesale</div></div>
                  <span class="add">View pricing <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
              <a href="<?php echo esc_url( $brands_url ); ?>" class="market-card reveal reveal-d1" style="text-decoration:none;color:inherit;">
                <div class="mimg"><span class="flag">&#127482;&#127480; USA</span><img src="https://images.unsplash.com/photo-1604881991720-f91add269bed?w=600&q=80" alt="Storz &amp; Bickel" loading="lazy"></div>
                <div class="mbody"><span class="mbrand">Storz &amp; Bickel</span><h4>Hybrid Volcano</h4>
                  <div class="mprice-row"><div class="mprice"><div class="lbl">Category</div><div class="val" style="font-size:1rem;">Vaporizers</div></div><div class="margin"><strong>View</strong>wholesale</div></div>
                  <span class="add">View pricing <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
              <a href="<?php echo esc_url( $brands_url ); ?>" class="market-card reveal reveal-d2" style="text-decoration:none;color:inherit;">
                <div class="mimg"><span class="flag">&#127482;&#127480; USA</span><img src="https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?w=600&q=80" alt="GRAV" loading="lazy"></div>
                <div class="mbody"><span class="mbrand">GRAV</span><h4>Long Hammer Hand Pipe</h4>
                  <div class="mprice-row"><div class="mprice"><div class="lbl">Category</div><div class="val" style="font-size:1rem;">Glass</div></div><div class="margin"><strong>View</strong>wholesale</div></div>
                  <span class="add">View pricing <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
              <a href="<?php echo esc_url( $brands_url ); ?>" class="market-card reveal reveal-d3" style="text-decoration:none;color:inherit;">
                <div class="mimg"><span class="flag">&#127482;&#127480; USA</span><img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600&q=80" alt="Pulsar" loading="lazy"></div>
                <div class="mbody"><span class="mbrand">Pulsar</span><h4>APX Vape V3 Kit</h4>
                  <div class="mprice-row"><div class="mprice"><div class="lbl">Category</div><div class="val" style="font-size:1rem;">Vaporizers</div></div><div class="margin"><strong>View</strong>wholesale</div></div>
                  <span class="add">View pricing <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
            </div>
            <?php
        endif;
        ?>
      </div>
    </section>

    <!-- ===== BLOG PREVIEW (animated background) ===== -->
    <section class="sec blog-animated" id="blog">
      <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:24px;margin-bottom:60px;">
          <div>
            <p class="eyebrow reveal">From the blog</p>
            <h2 class="h-sec reveal reveal-d1" style="margin-top:18px;">Guides, news &amp;<br>growth tactics.</h2>
          </div>
          <a href="<?php echo esc_url( $blog_url ); ?>" class="link-arrow reveal reveal-d2">Read the blog <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
        <?php
        // Pull the 3 most recent posts. Fall back to curated cards if the blog is empty.
        $latest = new WP_Query( array(
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ) );

        if ( $latest->have_posts() ) :
            echo '<div class="blog-grid">';
            $d = array( '', ' reveal-d1', ' reveal-d2' );
            $i = 0;
            while ( $latest->have_posts() ) :
                $latest->the_post();
                $first_cat = get_the_category();
                $cat_name  = ! empty( $first_cat ) ? $first_cat[0]->name : 'Dropshipping';
                $thumb     = get_the_post_thumbnail_url( get_the_ID(), 'sdn-blog-thumb' ) ?: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80';
                ?>
                <a href="<?php the_permalink(); ?>" class="blog-card reveal<?php echo esc_attr( $d[ $i % 3 ] ); ?>">
                  <div class="thumb"><span class="cat"><?php echo esc_html( $cat_name ); ?></span><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy"></div>
                  <div class="body">
                    <div class="meta"><span><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span><span><?php echo esc_html( sdn_reading_time() ); ?></span></div>
                    <h4><?php the_title(); ?></h4>
                    <span class="more">Read more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                  </div>
                </a>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            echo '</div>';
        else :
            // Static fallback
            ?>
            <div class="blog-grid">
              <a href="<?php echo esc_url( $blog_url ); ?>" class="blog-card reveal">
                <div class="thumb"><span class="cat">Dropshipping</span><img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&q=80" alt="Smoke shop dropshipping" loading="lazy"></div>
                <div class="body">
                  <div class="meta"><span>Jun 24, 2026</span><span>8 min</span></div>
                  <h4>The 2026 Smoke Shop Dropshipping Playbook</h4>
                  <p>How to launch a 1,000-SKU store this weekend with zero inventory.</p>
                  <span class="more">Read more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
              <a href="<?php echo esc_url( $blog_url ); ?>" class="blog-card reveal reveal-d1">
                <div class="thumb"><span class="cat">Wholesale</span><img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&q=80" alt="Wholesale" loading="lazy"></div>
                <div class="body">
                  <div class="meta"><span>Jun 18, 2026</span><span>6 min</span></div>
                  <h4>Stock Up Local Inventory With Wholesale Pricing</h4>
                  <p>Purchase products at wholesale prices with no minimum order amount.</p>
                  <span class="more">Read more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
              <a href="<?php echo esc_url( $blog_url ); ?>" class="blog-card reveal reveal-d2">
                <div class="thumb"><span class="cat">Brand Spotlight</span><img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&q=80" alt="PAX vaporizers" loading="lazy"></div>
                <div class="body">
                  <div class="meta"><span>Jun 20, 2026</span><span>5 min</span></div>
                  <h4>Why PAX Still Dominates the Vaporizer Category</h4>
                  <p>How heritage hardware brands keep winning, and how to stock them.</p>
                  <span class="more">Read more <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
                </div>
              </a>
            </div>
            <?php
        endif;
        ?>
      </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="sec" id="faqs" style="background:var(--bg-2);">
      <div class="wrap wrap-tight">
        <div style="text-align:center;max-width:680px;margin:0 auto 64px;">
          <p class="eyebrow reveal" style="justify-content:center;">FAQs</p>
          <h2 class="display reveal reveal-d1" style="margin-top:24px;">Questions,<br><span class="italic gradient-text">answered.</span></h2>
        </div>
        <?php
        $sdn_home_faqs = array(
            array(
                'q'    => 'What is dropshipping?',
                'a'    => 'Dropshipping means selling products in your own store without holding any inventory yourself &mdash; your supplier ships directly to the customer, and you keep the margin between wholesale and retail.',
                'slug' => 'what-is-dropshipping-for-beginners',
            ),
            array(
                'q'    => 'How do I start dropshipping on Shopify?',
                'a'    => 'Install the SmokeDrop app from the Shopify App Store, connect your store, and import products from the catalog. Orders sync automatically once a customer checks out.',
                'slug' => 'how-to-start-dropshipping-on-shopify-using-smokedrop',
            ),
            array(
                'q'    => 'Is dropshipping profitable?',
                'a'    => 'It can be &mdash; margins come from the spread between wholesale and retail pricing, and from keeping overhead low since there\'s no inventory or warehouse to fund.',
                'slug' => 'is-dropshipping-profitable-using-smokedrop',
            ),
            array(
                'q'    => 'How are dropship orders processed?',
                'a'    => 'When a customer orders from your store, SmokeDrop routes the order to the supplier, who fulfills and ships it. Order status and tracking sync back to your store automatically.',
                'slug' => 'how-dropship-orders-are-processed',
            ),
            array(
                'q'    => 'How do I find good suppliers?',
                'a'    => 'Look for suppliers with real-time inventory sync, transparent wholesale pricing, and no per-order fees. SmokeDrop\'s marketplace gives you access to hundreds of vetted suppliers in one place.',
                'slug' => 'what-are-the-best-suppliers-for-dropshipping',
            ),
            array(
                'q'    => 'How does product pricing work?',
                'a'    => 'You buy at the supplier\'s wholesale price and set your own retail price in your store &mdash; SmokeDrop doesn\'t take a cut of that margin.',
                'slug' => 'product-pricing-explained',
            ),
        );
        ?>
        <div class="faq-list reveal">
          <?php foreach ( $sdn_home_faqs as $sdn_fi => $sdn_faq ) : ?>
            <div class="faq-item<?php echo 0 === $sdn_fi ? ' open' : ''; // phpcs:ignore ?>">
              <button class="faq-q"><?php echo esc_html( $sdn_faq['q'] ); ?> <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
              <div class="faq-a"><p><?php echo wp_kses_post( $sdn_faq['a'] ); ?> <a href="<?php echo esc_url( home_url( '/' . $sdn_faq['slug'] . '/' ) ); ?>" style="color:var(--green-xl);">Read the full guide &rarr;</a></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- ===== SHOPPING CART INTEGRATIONS (real copy from thesmokedrop.com) ===== -->
    <section class="sec" id="integrations">
      <div class="wrap center">
        <p class="eyebrow reveal" style="justify-content:center;">Shopping Cart Integrations</p>
        <h2 class="display reveal reveal-d1" style="margin-top:20px;">Import over 20,000 smoke shop<br>products to <span class="italic gradient-text">your online store.</span></h2>
        <div class="integrations-row reveal reveal-d2" style="margin-top:56px;">
          <?php sdn_integration_bubbles(); ?>
        </div>
        <div class="feat-grid reveal reveal-d3" style="margin-top:56px;text-align:left;">
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="#95bf47"><path d="M15.337 4.13a4.36 4.36 0 0 0-2.69 1.43 4.07 4.07 0 0 0-3.34-1.42c-2.41.12-3.96 2.13-3.96 4.4 0 4.04 3.86 7.04 5.95 8.34l.04.02.04-.02c2.09-1.3 5.95-4.3 5.95-8.34 0-2.27-1.55-4.28-3.96-4.4z"/></svg></div><h4>SmokeDrop Shopify App</h4><p>Provides everything you need to start a successful dropshipping business. Add our app to your store and get started today.</p></div>
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="#7f54b3"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h4a3 3 0 0 1 0 6h-1l3 4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg></div><h4>WordPress WooCommerce</h4><p>Designed to make dropshipping easy and hassle-free. This lets you sell more, and work less.</p></div>
          <div class="feat-card"><div class="fc-ico"><svg viewBox="0 0 24 24" fill="#0d7377"><rect x="3" y="3" width="18" height="18" rx="3"/><text x="12" y="16" font-size="10" fill="#fff" text-anchor="middle" font-family="sans-serif">B</text></svg></div><h4>BigCommerce</h4><p>Our industry-leading dropshipping app lets you list products from our marketplace directly from the BigCommerce control panel.</p></div>
        </div>
        <div class="hero-actions reveal reveal-d4" style="justify-content:center;margin-top:48px;">
          <a href="<?php echo esc_url( home_url( '/integrations' ) ); ?>" class="btn btn-outline btn-lg">Compare all integrations</a>
          <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg">Start Free Trial</a>
        </div>
      </div>
    </section>

    <!-- ===== TRUST BAR ===== -->
    <div class="trust-bar reveal">
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-4z"/><polyline points="9 12 11 14 15 10"/></svg><div><strong>7-day free trial</strong><span>No commissions</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><div><strong>Automatic sync</strong><span>Orders &amp; tracking</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg><div><strong>No PO fees</strong><span>Keep your margin</span></div></div>
      <div class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l1-5h16l1 5"/><path d="M5 9v11h14V9"/></svg><div><strong>300+ brands</strong><span>20,000+ products</span></div></div>
    </div>

    <!-- ===== REAL TESTIMONIALS (from thesmokedrop.com) ===== -->
    <section class="sec">
      <div class="wrap">
        <div class="center" style="max-width:760px;margin:0 auto 56px;">
          <p class="eyebrow reveal" style="justify-content:center;">We love your feedback</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Retailers who<br><span class="italic gradient-text">flourish.</span></h2>
        </div>
        <div class="testi-grid">
          <div class="testi-card reveal">
            <div class="tc-mark">DV</div>
            <blockquote>"I really love you guys. I was having a very difficult time finding the right products to sell and what to sell exactly. I came up on this app and now my shop is flourishing. No complaints so far. Thanks guys"</blockquote>
            <div class="tc-author"><div><strong>The Darth Vapor</strong><span>Online Retailer</span></div></div>
          </div>
          <div class="testi-card reveal reveal-d1">
            <div class="tc-mark" style="background:linear-gradient(145deg,#0a6b3f,#13c27b);">SG</div>
            <blockquote>"I am new to the business and was a bit apprehensive until I found Smoke Drop. They have a great catalogue of quality products and an extremely user-friendly set-up. Maybe even better than that, is their customer service. I highly recommend this app!"</blockquote>
            <div class="tc-author"><div><strong>Session Glass</strong><span>Online Retailer</span></div></div>
          </div>
          <div class="testi-card reveal reveal-d2">
            <div class="tc-mark" style="background:linear-gradient(145deg,#004122,#0a6b3f);">MR</div>
            <blockquote>"As someone who uses Smoke Drop to sell on one accounts and dropship from another, this app is great! It helps streamline my dropshipping side of the business and it also lets me find vendor and products quick."</blockquote>
            <div class="tc-author"><div><strong>My Rolling Tray</strong><span>Online Retailer</span></div></div>
          </div>
        </div>
      </div>
    </section>

    <!-- ===== CTA ===== -->
    <?php sdn_cta(); ?>

</main>

<?php
get_footer();
