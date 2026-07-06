<?php
/**
 * Template Name: Schedule Call
 * Template Post Type: page
 *
 * Support call scheduler. Assign this template to the WordPress Page
 * mapped to /call/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_url = home_url( '/contact' );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Schedule Call</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Book a support<br><span class="italic gradient-text">call.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:560px;margin:0 auto;">Book a support call with one of our support staff with the scheduler below.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:0;">
      <div class="wrap wrap-tight">
        <div class="scheduler-embed reveal">
          <div class="calendly-inline-widget" data-url="https://calendly.com/d/36t-kf9-qmx/the-smokedrop-on-boarding-call" style="min-width:320px;width:100%;height:680px;"></div>
        </div>
        <p class="center form-note" style="margin-top:20px;">Trouble loading the scheduler? <a href="<?php echo esc_url( $contact_url ); ?>" style="color:var(--green-xl);">Contact us</a> and we'll set up a time.</p>
      </div>
    </section>
</main>

<?php
get_footer();
