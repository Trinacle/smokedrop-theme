<?php
/**
 * The Brands archive template.
 *
 * The primary "Brands We Carry" page is the static Page at /brands/ using
 * page-brands.php. This archive-brand.php is a safety net: if the brand CPT's
 * has_archive is ever enabled, or a request hits /brand/ (no slug), render the
 * same alphabetical directory so there's never a broken/empty view.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url   = home_url( '/suppliers' );
$sdn_dir      = sdn_brand_directory();
$sdn_grouped  = array();

// Merge in any real CPT brand posts (so wp-admin-edited brands appear too).
$cpt_brands = get_posts( array(
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'post_status'    => 'publish',
) );
foreach ( $cpt_brands as $cb ) {
    $sdn_dir[] = array(
        'name'     => get_the_title( $cb ),
        'initials' => strtoupper( substr( get_the_title( $cb ), 0, 2 ) ),
        'slug'     => $cb->post_name,
    );
}

foreach ( $sdn_dir as $b ) {
    $clean  = preg_replace( '/^[^a-zA-Z0-9]+/', '', $b['name'] );
    $letter = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( mb_substr( $clean, 0, 1 ) ) : strtoupper( substr( $clean, 0, 1 ) );
    if ( ! ctype_alnum( $letter ) ) $letter = '#';
    $sdn_grouped[ $letter ][] = $b;
}
ksort( $sdn_grouped );
$sdn_letters = array_keys( $sdn_grouped );
$sdn_brands_pg = home_url( '/brands' );
?>

<main>
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Brands We Carry</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">300+ brands.<br><span class="italic gradient-text">One integration.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">The deepest smoke, vape &amp; hemp catalog in the industry &mdash; the brands your customers already ask for, ready to dropship or buy wholesale.</p>
    </div>
  </section>

  <section class="sec">
    <div class="wrap">
      <div class="center" style="margin-bottom:32px;">
        <p class="eyebrow reveal" style="justify-content:center;">Full directory</p>
        <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Browse all brands</h2>
      </div>

      <div class="alpha-nav reveal">
        <?php foreach ( $sdn_letters as $l ) : ?>
          <a href="#dir-<?php echo esc_attr( strtolower( $l ) ); ?>"><?php echo esc_html( $l ); ?></a>
        <?php endforeach; ?>
      </div>

      <div class="brand-directory-wrap">
        <?php foreach ( $sdn_grouped as $letter => $brands ) : ?>
          <h3 class="alpha-head" id="dir-<?php echo esc_attr( strtolower( $letter ) ); ?>"><?php echo esc_html( $letter ); ?></h3>
          <div class="brand-directory">
            <?php foreach ( $brands as $b ) :
                $name     = $b['name'];
                $initials = isset( $b['initials'] ) ? $b['initials'] : strtoupper( substr( $name, 0, 2 ) );
                $slug     = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $name );
                ?>
                <a href="<?php echo esc_url( home_url( '/brand/' . $slug . '/' ) ); ?>" class="brand-pill">
                  <span class="bp-mark"><?php echo esc_html( $initials ); ?></span>
                  <span><?php echo esc_html( $name ); ?></span>
                </a>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="sec-sm">
    <div class="wrap">
      <div class="cta-bg reveal" style="background:linear-gradient(135deg,var(--green-d),var(--green));">
        <div class="inner">
          <h2 class="display" style="color:#fff;">Don't see your brand?</h2>
          <p class="lede">Suppliers and brands can join the marketplace and reach hundreds of retailers &mdash; from $49.99/mo, no transaction fees.</p>
          <div class="hero-actions">
            <a href="<?php echo esc_url( $supply_url ); ?>" class="btn btn-lime btn-lg">Become a Wholesaler</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
get_footer();
