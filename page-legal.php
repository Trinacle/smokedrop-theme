<?php
/**
 * Template Name: Legal / Document
 * Template Post Type: page
 *
 * Reusable layout for legal and standard document pages (Terms of Use, Privacy
 * Policy, Supplier Agreement, Retailer Agreement). Renders the page's
 * post_content in a readable, narrowly-centered prose column with the new
 * design system — so every standard page adopts the new look without each
 * needing its own bespoke template.
 *
 * The content itself is authored in wp-admin; this template only wraps it.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

// The page title (legal pages have meaningful titles set in wp-admin).
$legal_title = get_the_title();
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Legal</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;"><?php echo esc_html( $legal_title ); ?></h1>
        <p class="lede reveal reveal-d2" style="max-width:560px;margin:0 auto;">Last updated <?php echo esc_html( get_the_modified_date( 'F j, Y' ) ); ?>. Questions? Email <a href="mailto:support@thesmokedrop.com" style="color:var(--green-xl);">support@thesmokedrop.com</a>.</p>
      </div>
    </section>

    <section class="sec">
      <div class="wrap wrap-tight">
        <article class="legal-doc">
          <?php
          // Render the authored legal content with formatting preserved.
          if ( have_posts() ) :
            while ( have_posts() ) : the_post();
              the_content();
            endwhile;
          endif;
          ?>
        </article>

        <div class="center" style="margin-top:64px;padding-top:40px;border-top:1px solid var(--line);">
          <p style="color:var(--ink-mute);">Need help with something in this document?</p>
          <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-outline" style="margin-top:16px;">Contact support</a>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
