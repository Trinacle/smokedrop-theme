<?php
/**
 * Template Name: Sitemap
 * Template Post Type: page
 *
 * Human-readable HTML sitemap covering every section of the site: solutions,
 * marketplace, brands, resources, company, and legal. Assign to /sitemap/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$sdn_shop_url = get_post_type_archive_link( 'product' ) ?: home_url( '/shop' );
$sdn_blog_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/dropshipping-blog' );

// Build an A-Z brand index from the directory for the Brands section.
$sdn_sm_brands = sdn_brand_directory();
$sdn_sm_grouped = array();
foreach ( $sdn_sm_brands as $b ) {
    $clean  = preg_replace( '/^[^a-zA-Z0-9]+/', '', $b['name'] );
    $letter = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( mb_substr( $clean, 0, 1 ) ) : strtoupper( substr( $clean, 0, 1 ) );
    if ( ! ctype_alnum( $letter ) ) $letter = '#';
    $sdn_sm_grouped[ $letter ][] = $b;
}
ksort( $sdn_sm_grouped );

// Recent blog posts for the sitemap.
$sdn_sm_posts = get_posts( array(
    'post_type'           => 'post',
    'posts_per_page'      => 12,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'orderby'             => 'date',
    'order'               => 'DESC',
) );
$sdn_sm_cats = get_categories( array(
    'taxonomy'   => 'category',
    'hide_empty' => true,
    'number'     => 10,
) );
?>

<main>
    <section class="page-hero" style="min-height:auto;padding-bottom:60px;">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Sitemap</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Find your way<br><span class="italic gradient-text">around SmokeDrop.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Every page, every section, every brand &mdash; all in one place.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:0;">
      <div class="wrap">
        <div class="sitemap-grid-full reveal">

          <div class="foot-col">
            <h5>Solutions</h5>
            <a href="<?php echo esc_url( home_url( '/retailers' ) ); ?>">For Retailers</a>
            <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Suppliers</a>
            <a href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>">For Wholesalers</a>
            <a href="<?php echo esc_url( home_url( '/industries' ) ); ?>">By Industry</a>
            <a href="<?php echo esc_url( home_url( '/compare' ) ); ?>">Compare</a>
          </div>

          <div class="foot-col">
            <h5>Platform</h5>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Overview</a>
            <a href="<?php echo esc_url( home_url( '/platform' ) ); ?>">Integrations</a>
            <a href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a>
            <a href="<?php echo esc_url( home_url( '/demo' ) ); ?>">Get a Demo</a>
            <a href="<?php echo esc_url( home_url( '/call' ) ); ?>">Schedule a Call</a>
          </div>

          <div class="foot-col">
            <h5>Marketplace</h5>
            <a href="<?php echo esc_url( $sdn_shop_url ); ?>">Shop all products</a>
            <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">All brands</a>
            <a href="<?php echo esc_url( home_url( '/new-dropshipping-products' ) ); ?>">New products</a>
            <a href="<?php echo esc_url( home_url( '/integrations' ) ); ?>">Integrations</a>
            <a href="<?php echo esc_url( home_url( '/integrations/shopify' ) ); ?>">Shopify App</a>
            <a href="<?php echo esc_url( home_url( '/integrations/woocommerce' ) ); ?>">WooCommerce Plugin</a>
            <a href="<?php echo esc_url( home_url( '/integrations/bigcommerce' ) ); ?>">BigCommerce App</a>
            <a href="<?php echo esc_url( home_url( '/integrations/api' ) ); ?>">Custom API</a>
          </div>

          <div class="foot-col">
            <h5>Resources</h5>
            <a href="<?php echo esc_url( $sdn_blog_url ); ?>">Blog &amp; Guides</a>
            <a href="<?php echo esc_url( home_url( '/help' ) ); ?>">Help Center</a>
            <a href="<?php echo esc_url( home_url( '/testimonials' ) ); ?>">Testimonials</a>
            <a href="<?php echo esc_url( home_url( '/quick-start-guide' ) ); ?>">Quick Start Guide</a>
            <a href="<?php echo esc_url( home_url( '/optimize-your-smokedrop-program' ) ); ?>">Optimize Your Program</a>
          </div>

          <div class="foot-col">
            <h5>Company</h5>
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
            <a href="<?php echo esc_url( home_url( '/advertise' ) ); ?>">Advertise</a>
            <a href="<?php echo esc_url( home_url( '/whats-new' ) ); ?>">What's New</a>
          </div>

          <div class="foot-col">
            <h5>Legal</h5>
            <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">Privacy Policy</a>
            <a href="<?php echo esc_url( home_url( '/terms-of-use' ) ); ?>">Terms of Use</a>
            <a href="<?php echo esc_url( home_url( '/retailer-terms-of-use-agreement' ) ); ?>">Retailer Agreement</a>
            <a href="<?php echo esc_url( home_url( '/terms-of-use-for-suppliers' ) ); ?>">Supplier Agreement</a>
          </div>

        </div>

        <!-- A-Z BRAND INDEX -->
        <div class="sitemap-brands reveal" style="margin-top:72px;padding-top:48px;border-top:1px solid var(--line);">
          <h3 style="font-family:var(--display);font-size:1.6rem;font-weight:600;letter-spacing:-.02em;margin-bottom:24px;">Brands A&ndash;Z <span style="color:var(--ink-mute);font-size:.9rem;font-weight:400;">(<?php echo count( $sdn_sm_brands ); ?>+)</span></h3>
          <div class="alpha-nav" style="margin-bottom:32px;">
            <?php foreach ( array_keys( $sdn_sm_grouped ) as $l ) : ?>
              <a href="<?php echo esc_url( home_url( '/brands/#dir-' . strtolower( $l ) ) ); ?>"><?php echo esc_html( $l ); ?></a>
            <?php endforeach; ?>
          </div>
          <p style="color:var(--ink-mute);">Browse the complete directory on the <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>" style="color:var(--green-xl);">Brands We Carry</a> page.</p>
        </div>

        <!-- BLOG POSTS -->
        <?php if ( ! empty( $sdn_sm_posts ) ) : ?>
        <div class="sitemap-brands reveal" style="margin-top:72px;padding-top:48px;border-top:1px solid var(--line);">
          <h3 style="font-family:var(--display);font-size:1.6rem;font-weight:600;letter-spacing:-.02em;margin-bottom:24px;">From the blog <span style="color:var(--ink-mute);font-size:.9rem;font-weight:400;">(guides &amp; insights)</span></h3>

          <?php if ( ! empty( $sdn_sm_cats ) ) : ?>
            <div class="sitemap-cats" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:28px;">
              <?php foreach ( $sdn_sm_cats as $c ) : ?>
                <a href="<?php echo esc_url( get_category_link( $c ) ); ?>" style="font-size:.82rem;padding:6px 14px;border-radius:var(--r-pill);background:var(--bg-2);border:1px solid var(--line);color:var(--ink-dim);text-decoration:none;"><?php echo esc_html( $c->name ); ?> <span style="color:var(--ink-mute);"><?php echo (int) $c->count; ?></span></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div class="sitemap-postlist">
            <?php foreach ( $sdn_sm_posts as $p ) :
                $sdn_pcat = get_the_category( $p->ID );
                $sdn_pcat_name = ! empty( $sdn_pcat ) ? $sdn_pcat[0]->name : '';
                ?>
              <a href="<?php echo esc_url( get_permalink( $p ) ); ?>" class="sitemap-post">
                <span class="sp-title"><?php echo esc_html( get_the_title( $p ) ); ?></span>
                <?php if ( $sdn_pcat_name ) : ?><span class="sp-cat"><?php echo esc_html( $sdn_pcat_name ); ?></span><?php endif; ?>
                <span class="sp-date"><?php echo esc_html( get_the_date( 'M j, Y', $p ) ); ?></span>
              </a>
            <?php endforeach; ?>
          </div>
          <p style="color:var(--ink-mute);margin-top:24px;"><a href="<?php echo esc_url( $sdn_blog_url ); ?>" style="color:var(--green-xl);">Read all posts &rarr;</a></p>
        </div>
        <?php endif; ?>

      </div>
    </section>
</main>

<?php
get_footer();
