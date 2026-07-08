<?php
/**
 * Template Name: Brands We Carry
 * Template Post Type: page
 *
 * Dynamic showcase of the brands on the SmokeDrop marketplace. Pulls the full
 * ~380-brand directory (366 active ranked + 14 recently joined) from
 * sdn_brand_directory() / sdn_new_brands(). Assign to the Page at /brands/.
 *
 * Sections:
 *   1. Hero
 *   2. Logo marquee (brands with known logos)
 *   3. Featured brands grid (top-ranked, with logos + product images)
 *   4. Recently Joined Brands
 *   5. Alphabetical master directory (A-Z alpha-nav + pills)
 *   6. CTA
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$supply_url   = home_url( '/suppliers' );
$register     = 'https://wholesale.thesmokedrop.com/register';
$sdn_active   = sdn_brand_directory();
$sdn_new      = sdn_new_brands();
$sdn_logos    = array_filter( $sdn_active, function ( $b ) { return ! empty( $b['logo'] ); } );

// Top-ranked brands for the featured grid (value >= 9).
$sdn_featured = array_filter( $sdn_active, function ( $b ) { return isset( $b['value'] ) && $b['value'] >= 9; } );

// Logo marquee rows.
$sdn_logo_arr = array_values( $sdn_logos );
$row_a = array_slice( $sdn_logo_arr, 0, 6 );
$row_b = array_slice( $sdn_logo_arr, 6, 5 );
$row_c = array_slice( $sdn_logo_arr, 11 );

// Group the full active list alphabetically for the master directory.
$sdn_grouped = array();
foreach ( $sdn_active as $b ) {
    $clean  = preg_replace( '/^[^a-zA-Z0-9]+/', '', $b['name'] );
    $letter = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( mb_substr( $clean, 0, 1 ) ) : strtoupper( substr( $clean, 0, 1 ) );
    if ( ! ctype_alnum( $letter ) ) $letter = '#';
    $sdn_grouped[ $letter ][] = $b;
}
ksort( $sdn_grouped );
$sdn_letters = array_keys( $sdn_grouped );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Brands We Carry</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">300+ brands.<br><span class="italic gradient-text">One integration.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">The deepest smoke, vape &amp; hemp catalog in the industry &mdash; <?php echo count( $sdn_active ); ?>+ brands your customers already ask for, ready to dropship or buy wholesale.</p>
        <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
          <a href="<?php echo esc_url( $register ); ?>" class="btn btn-lime btn-lg">Start Free Trial</a>
          <a href="#directory" class="btn btn-outline btn-lg">Browse all brands</a>
        </div>
      </div>
    </section>

    <!-- MULTI-ROW LOGO MARQUEE -->
    <?php if ( ! empty( $sdn_logos ) ) : ?>
    <section class="logo-wall-white reveal">
      <div class="lw-wall">
        <?php if ( $row_a ) : ?>
        <div class="lw-row">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_a as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['logo'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
        <?php endif; ?>
        <?php if ( $row_b ) : ?>
        <div class="lw-row rev" style="margin-top:40px;">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_b as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['logo'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
        <?php endif; ?>
        <?php if ( $row_c ) : ?>
        <div class="lw-row" style="margin-top:40px;">
          <?php for ( $i = 0; $i < 3; $i++ ) : foreach ( $row_c as $b ) : ?>
            <span class="lgo"><img class="lgo-img" src="<?php echo esc_url( home_url( '/wp-content/uploads/' . $b['logo'] ) ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy"></span>
          <?php endforeach; endfor; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- FEATURED BRAND CARDS (top-ranked, WITH logos only) -->
    <?php
    // Resolve logos for featured brands via the full resolver (directory + CPT meta).
    $sdn_featured_with_logo = array();
    foreach ( $sdn_featured as $b ) {
        $logo_url = sdn_brand_logo_for_slug( $b['slug'] );
        if ( $logo_url ) {
            $sdn_featured_with_logo[] = array( 'b' => $b, 'logo' => $logo_url );
        }
    }
    // Cap the featured grid so it stays a clean grid (not hundreds of cards).
    $sdn_featured_with_logo = array_slice( $sdn_featured_with_logo, 0, 24 );
    ?>
    <?php if ( ! empty( $sdn_featured_with_logo ) ) : ?>
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="center" style="margin-bottom:48px;">
          <p class="eyebrow reveal" style="justify-content:center;">Featured brands</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Top trending brands</h2>
        </div>
        <div class="brand-grid reveal reveal-d2">
          <?php foreach ( $sdn_featured_with_logo as $fl ) :
              $b = $fl['b'];
              ?>
              <a href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>" class="brand-card" id="brand-<?php echo esc_attr( $b['slug'] ); ?>">
                <img src="<?php echo esc_url( $fl['logo'] ); ?>" alt="<?php echo esc_attr( $b['name'] ); ?>" loading="lazy">
                <span class="brand-card-name"><?php echo esc_html( $b['name'] ); ?></span>
              </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- RECENTLY JOINED BRANDS -->
    <?php if ( ! empty( $sdn_new ) ) : ?>
    <section class="sec">
      <div class="wrap">
        <div class="center" style="margin-bottom:40px;">
          <p class="eyebrow reveal" style="justify-content:center;color:var(--green-xl);">Just added</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Recently joined brands</h2>
          <p class="lede reveal reveal-d2" style="max-width:560px;margin:16px auto 0;">New partners fresh on the marketplace.</p>
        </div>
        <div class="brand-grid-new reveal reveal-d2">
          <?php foreach ( $sdn_new as $b ) : ?>
            <a href="<?php echo esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ); ?>" class="brand-pill-new">
              <span class="bp-new-mark"><?php echo esc_html( $b['initials'] ); ?></span>
              <span class="bp-new-name"><?php echo esc_html( $b['name'] ); ?></span>
              <span class="bp-new-tag">NEW</span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ALPHABETICAL MASTER DIRECTORY -->
    <section class="sec" id="directory">
      <div class="wrap">
        <div class="center" style="margin-bottom:32px;">
          <p class="eyebrow reveal" style="justify-content:center;">Full directory</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Browse all <?php echo count( $sdn_active ); ?>+ brands</h2>
        </div>

        <!-- A-Z alpha nav -->
        <div class="alpha-nav reveal">
          <?php foreach ( $sdn_letters as $l ) : ?>
            <a href="#dir-<?php echo esc_attr( strtolower( $l ) ); ?>"><?php echo esc_html( $l ); ?></a>
          <?php endforeach; ?>
        </div>

        <!-- Grouped directory -->
        <div class="brand-directory-wrap">
          <?php foreach ( $sdn_grouped as $letter => $brands ) : ?>
            <h3 class="alpha-head" id="dir-<?php echo esc_attr( strtolower( $letter ) ); ?>"><?php echo esc_html( $letter ); ?></h3>
            <div class="brand-directory">
              <?php foreach ( $brands as $b ) :
                  $name     = $b['name'];
                  $initials = isset( $b['initials'] ) ? $b['initials'] : strtoupper( substr( $name, 0, 2 ) );
                  $slug     = isset( $b['slug'] ) ? $b['slug'] : sanitize_title( $name );
                  // Resolve logo from directory OR CPT post_meta.
                  $logo_url = sdn_brand_logo_for_slug( $slug );
                  $has_logo = ! empty( $logo_url );
                  $cls      = $has_logo ? 'brand-pill brand-pill--logo' : 'brand-pill';
                  ?>
                  <a href="<?php echo esc_url( home_url( '/brand/' . $slug . '/' ) ); ?>" class="<?php echo esc_attr( $cls ); ?>">
                    <?php if ( $has_logo ) : ?>
                      <span class="bp-logo"><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy"></span>
                    <?php else : ?>
                      <span class="bp-mark"><?php echo esc_html( $initials ); ?></span>
                    <?php endif; ?>
                    <span><?php echo esc_html( $name ); ?></span>
                  </a>
              <?php endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- CTA -->
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
