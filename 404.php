<?php
/**
 * 404 error page.
 *
 * Noir-styled "page not found" with search + key links.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main>
    <section class="page-hero" style="min-height:60vh;display:flex;align-items:center;">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center" style="width:100%;">
        <div class="reveal" style="font-family:var(--display);font-size:6rem;font-weight:700;line-height:1;color:var(--green-xl);letter-spacing:-.04em;">404</div>
        <h1 class="display reveal reveal-d1" style="margin:20px 0;">This page took a <span class="italic gradient-text">different trip.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:540px;margin:0 auto 32px;">The page you&rsquo;re looking for isn&rsquo;t here. Try a search, or head to one of the popular destinations below.</p>
        <div class="reveal reveal-d3" style="max-width:560px;margin:0 auto;">
          <?php get_search_form(); ?>
        </div>
      </div>
    </section>

    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="contact-methods">
          <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>" class="cm-card reveal">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg></span>
            <h4>Browse brands</h4>
            <p>300+ dropship-ready brands</p>
            <span class="cm-note">Explore the full SmokeDrop marketplace catalog</span>
          </a>
          <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/marketplace' ) ); ?>" class="cm-card reveal reveal-d1">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg></span>
            <h4>Marketplace</h4>
            <p>20,000+ products</p>
            <span class="cm-note">Shop the full product catalog</span>
          </a>
          <a href="<?php echo esc_url( home_url( '/help' ) ); ?>" class="cm-card reveal reveal-d2">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
            <h4>Help Center</h4>
            <p>FAQs &amp; docs</p>
            <span class="cm-note">Answers to common questions</span>
          </a>
          <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="cm-card reveal">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></span>
            <h4>Contact us</h4>
            <p>Talk to our team</p>
            <span class="cm-note">We&rsquo;ll help you find what you need</span>
          </a>
        </div>
      </div>
    </section>
</main>

<?php
get_footer();
