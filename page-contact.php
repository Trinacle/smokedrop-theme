<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Contact page — real SmokeDrop contact info + the site's existing
 * Forminator contact form (ID 818, "contact-us"). Assign this template
 * to the WordPress Page mapped to /contact/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$call_url = home_url( '/call' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Contact</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Talk to<br><span class="italic gradient-text">our team.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:560px;margin:0 auto;">Our support staff is here to help you through every step of the process.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:0;">
      <div class="wrap wrap-tight">
        <div class="contact-grid reveal">
          <div class="contact-info">
            <h3>Get in touch</h3>
            <div class="ci-item">
              <span class="ci-label">Email</span>
              <a href="mailto:support@thesmokedrop.com">support@thesmokedrop.com</a>
            </div>
            <div class="ci-item">
              <span class="ci-label">Address</span>
              <p>315 South Coast Highway 101 #528<br>Encinitas, CA 92024</p>
            </div>
            <div class="ci-item">
              <span class="ci-label">Prefer to talk?</span>
              <a href="<?php echo esc_url( $call_url ); ?>">Schedule a support call &rarr;</a>
            </div>
          </div>
          <div class="contact-form-card">
            <?php echo do_shortcode( '[forminator_form id="818"]' ); ?>
          </div>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
