<?php
/**
 * Template Name: Testimonials
 * Template Post Type: page
 *
 * "What retailers say" — curated testimonials grid (real Shopify reviews).
 * Assign this template to the WordPress Page mapped to /testimonials/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// Real testimonials from the Shopify App Store + thesmokedrop.com.
$sdn_testis = array(
    array( 'mark' => 'DV', 'name' => 'The Darth Vapor', 'role' => 'Online Retailer',
        'quote' => 'I really love you guys. I was having a very difficult time finding the right products to sell and what to sell exactly. I came up on this app and now my shop is flourishing. No complaints so far. Thanks guys!' ),
    array( 'mark' => 'SG', 'name' => 'Session Glass', 'role' => 'Online Retailer', 'grad' => '145deg,#0a6b3f,#13c27b',
        'quote' => 'I am new to the business and was a bit apprehensive until I found Smoke Drop. They have a great catalogue of quality products and an extremely user-friendly set-up. Maybe even better than that, is their customer service. I highly recommend this app!' ),
    array( 'mark' => 'MR', 'name' => 'My Rolling Tray', 'role' => 'Online Retailer', 'grad' => '145deg,#004122,#0a6b3f',
        'quote' => 'As someone who uses Smoke Drop to sell on one accounts and dropship from another, this app is great! It helps streamline my dropshipping side of the business and it also lets me find vendor and products quick.' ),
    array( 'mark' => 'CP', 'name' => 'Cloud Peak Vapes', 'role' => 'Online Retailer',
        'quote' => 'We added 2,000 SKUs in a weekend and tripled our vape category revenue in 90 days. The auto-sync means we never oversell.' ),
    array( 'mark' => 'JR', 'name' => 'Jess Ramirez', 'role' => 'Owner, Cloud Peak Vapes', 'grad' => '145deg,#0a6b3f,#13c27b',
        'quote' => 'The inventory sync is flawless. I used to spend hours updating stock — now it just happens. I focus on marketing, not manual entry.' ),
    array( 'mark' => 'HK', 'name' => 'Highkey Smokeshop', 'role' => 'Online Retailer', 'grad' => '145deg,#004122,#0a6b3f',
        'quote' => 'Best dropshipping app for smoke shops, hands down. The catalog depth is unreal — every brand my customers ask for, in one place.' ),
);

$shopify_url = 'https://apps.shopify.com/smoke-drop';
$demo_url    = home_url( '/demo' );
?>

<main>
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">We love your feedback</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">What retailers <span class="italic gradient-text">say.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Real reviews from SmokeDrop retailers on the Shopify App Store and beyond.</p>
    </div>
  </section>

  <section class="sec">
    <div class="wrap">
      <div class="testi-grid">
        <?php
        $d = array( '', ' reveal-d1', ' reveal-d2' );
        foreach ( $sdn_testis as $i => $t ) :
            $grad = isset( $t['grad'] ) ? $t['grad'] : '';
            ?>
            <div class="testi-card reveal<?php echo esc_attr( $d[ $i % 3 ] ); ?>">
              <div class="tc-mark"<?php echo $grad ? ' style="background:linear-gradient(' . esc_attr( $grad ) . ');"' : ''; ?>><?php echo esc_html( $t['mark'] ); ?></div>
              <blockquote><?php echo esc_html( $t['quote'] ); ?></blockquote>
              <div class="tc-author"><div><strong><?php echo esc_html( $t['name'] ); ?></strong><span><?php echo esc_html( $t['role'] ); ?></span></div></div>
            </div>
        <?php endforeach; ?>
      </div>

      <div class="center reveal" style="margin-top:56px;">
        <a href="<?php echo esc_url( $shopify_url ); ?>" class="btn btn-lime btn-lg">Read more on the Shopify App Store</a>
        <p style="color:var(--ink-mute);margin-top:16px;font-size:.9rem;">Want to see SmokeDrop in action? <a href="<?php echo esc_url( $demo_url ); ?>" style="color:var(--green-xl);">Get a demo &rarr;</a></p>
      </div>
    </div>
  </section>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
