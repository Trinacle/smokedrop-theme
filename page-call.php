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
          <?php
          /**
           * Paste the real scheduler embed here (e.g. a Calendly inline widget):
           *
           * <div class="calendly-inline-widget" data-url="https://calendly.com/your-slug" style="min-width:320px;height:640px;"></div>
           * <script src="https://assets.calendly.com/assets/external/widget.js" async></script>
           */
          ?>
          <p>Scheduler coming soon. In the meantime, <a href="<?php echo esc_url( $contact_url ); ?>" style="color:var(--green-xl);">contact us</a> and we'll set up a time.</p>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
