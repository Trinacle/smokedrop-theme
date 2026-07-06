<?php
/**
 * Template Name: Industries
 * Template Post Type: page
 *
 * Dropshipping by vertical — headshop, CBD & hemp, adult products.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$brands_url = get_post_type_archive_link( 'brand' );

/**
 * Vertical cards. Each: [ tag, title, desc, image, [ stat => label, ... ] ]
 */
$verticals = array(
    array(
        'tag'   => 'Headshop',
        'title' => 'Smoke shop dropshipping',
        'desc'  => 'Bongs, dab rigs, vaporizers, grinders, rolling papers, hand pipes. The deepest catalog in the category.',
        'img'   => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=900&q=80',
        'stats' => array( '500+' => 'brands', '100+' => 'categories', '1,000+' => 'retailers' ),
    ),
    array(
        'tag'   => 'CBD &amp; Hemp',
        'title' => 'CBD &amp; THCA dropshipping',
        'desc'  => 'Flower, prerolls, edibles, tinctures, topicals, vapes. Farm Bill compliant, hemp-derived.',
        'img'   => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=900&q=80',
        'stats' => array( '1,000+' => 'SKUs', '50+' => 'brands', 'Farm Bill' => 'compliant' ),
    ),
    array(
        'tag'   => 'Adult',
        'title' => 'Adult products dropshipping',
        'desc'  => 'Discreet, compliant fulfillment for the adult novelty category.',
        'img'   => 'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=900&q=80',
        'stats' => array( 'All 50' => 'states aware', 'Discreet' => 'packaging', 'Compliant' => 'fulfillment' ),
    ),
);
?>

<main>
    <section class="hero" style="min-height:auto;padding-top:180px;padding-bottom:60px;">
      <div class="hero-inner">
        <p class="eyebrow reveal">By industry</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Dropshipping,<br><span class="italic gradient-text">by vertical.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;">SmokeDrop is purpose-built for high-risk, highly-regulated verticals. Each industry gets compliant fulfillment, vetted suppliers, and category-specific inventory.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="industries">
          <?php foreach ( $verticals as $i => $v ) : ?>
            <a href="<?php echo esc_url( $brands_url ); ?>" class="ind-card reveal reveal-d<?php echo $i; // 0,1,2 -> reveal-d0 (no delay), reveal-d1, reveal-d2 ?>" style="text-decoration:none;">
              <img src="<?php echo esc_url( $v['img'] ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $v['title'] ) ); ?>">
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
      <div class="wrap wrap-tight center">
        <p class="eyebrow reveal" style="justify-content:center;">Why SmokeDrop wins in high-risk</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Compliance is not<br>an add-on. <span class="italic gradient-text">It's the product.</span></h2>
        <p class="lede reveal reveal-d2" style="margin-top:28px;">Generic dropship platforms weren't built for smoke, CBD, or adult. SmokeDrop was. Age gates, MAP enforcement, restricted-state logic, compliant packaging, and high-risk merchant processing are baked into the platform.</p>
        <div class="bento-tag-row reveal reveal-d3" style="justify-content:center;margin-top:40px;">
          <span class="bento-tag">&#10003; Compliant fulfillment</span>
          <span class="bento-tag">&#10003; MAP enforcement</span>
          <span class="bento-tag">&#10003; Restricted-state logic</span>
          <span class="bento-tag">&#10003; Compliant packaging</span>
          <span class="bento-tag">&#10003; High-risk merchant processing</span>
        </div>
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg reveal reveal-d4" style="margin-top:40px;">Start free trial</a>
      </div>
    </section>
</main>

<?php
get_footer();
