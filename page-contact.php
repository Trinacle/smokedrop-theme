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

$call_url   = home_url( '/call' );
$demo_url   = home_url( '/demo' );
$marketplace_url = 'https://wholesale.thesmokedrop.com/register';
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Contact</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Let&rsquo;s talk.<br><span class="italic gradient-text">We&rsquo;re here to help.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:560px;margin:0 auto;">Questions about dropshipping, suppliers, or your account? Our team replies fast &mdash; usually within one business day.</p>
      </div>
    </section>

    <!-- Quick-contact method cards -->
    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="contact-methods">
          <a href="mailto:support@thesmokedrop.com" class="cm-card reveal">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></span>
            <h4>Email support</h4>
            <p>support@thesmokedrop.com</p>
            <span class="cm-note">Best for account &amp; order questions &middot; replies within 1 business day</span>
          </a>
          <a href="<?php echo esc_url( $call_url ); ?>" class="cm-card reveal reveal-d1">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
            <h4>Schedule a call</h4>
            <p>Book a 1:1 support session</p>
            <span class="cm-note">Walk through setup, troubleshoot, or get onboarding help</span>
          </a>
          <a href="<?php echo esc_url( $demo_url ); ?>" class="cm-card reveal reveal-d2">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><rect x="7" y="11" width="3" height="7"/><rect x="12" y="7" width="3" height="11"/><rect x="17" y="13" width="3" height="5"/></svg></span>
            <h4>Request a demo</h4>
            <p>See the platform in action</p>
            <span class="cm-note">Personalized walkthrough for new retailers &amp; suppliers</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Form + details -->
    <section class="sec" style="padding-top:20px;">
      <div class="wrap wrap-tight">
        <div class="contact-grid reveal">
          <div class="contact-info">
            <h3>Send us a message</h3>
            <p class="ci-intro">Fill out the form and we&rsquo;ll get back to you within one business day. For urgent order issues, email is fastest.</p>

            <div class="ci-item">
              <span class="cm-ico sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m2 7 10 6 10-6"/></svg></span>
              <div>
                <span class="ci-label">Email</span>
                <a href="mailto:support@thesmokedrop.com">support@thesmokedrop.com</a>
              </div>
            </div>

            <div class="ci-item">
              <span class="cm-ico sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <div>
                <span class="ci-label">Address</span>
                <p>315 South Coast Highway 101 #528<br>Encinitas, CA 92024</p>
              </div>
            </div>

            <div class="ci-item">
              <span class="cm-ico sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></span>
              <div>
                <span class="ci-label">Hours</span>
                <p>Mon&ndash;Fri, 9am&ndash;5pm PT</p>
              </div>
            </div>

            <div class="ci-item">
              <span class="cm-ico sm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 0 1 15-6.7L21 8"/><path d="M21 3v5h-5"/></svg></span>
              <div>
                <span class="ci-label">New to SmokeDrop?</span>
                <a href="<?php echo esc_url( $marketplace_url ); ?>">Start a free trial &rarr;</a>
              </div>
            </div>
          </div>

          <div class="contact-form-card">
            <?php echo do_shortcode( '[forminator_form id="818"]' ); ?>
          </div>
        </div>
      </div>
    </section>

    <?php sdn_cta(); ?>
</main>

<?php
get_footer();
