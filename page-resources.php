<?php
/**
 * Template Name: Resources
 * Template Post Type: page
 *
 * Resources hub — aggregates Help Center, blog categories, recommended tools,
 * and testimonials. The "Resources" nav item points here.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$help_url   = home_url( '/help' );
$blog_url   = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/dropshipping-blog' );
$tools_url  = home_url( '/recommend-tools-for-ecommerce' );
$testi_url  = home_url( '/testimonials' );
$contact_url = home_url( '/contact' );
$register   = 'https://wholesale.thesmokedrop.com/register';

// Top blog categories for the category grid.
$sdn_cats = get_categories( array(
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 6,
    'hide_empty' => true,
    'exclude'    => get_option( 'default_category' ),
) );
?>

<main>
    <section class="page-hero">
      <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
      <div class="ph-inner center">
        <p class="eyebrow reveal" style="justify-content:center;">Resources</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">Guides, docs, &amp; <span class="italic gradient-text">growth tools.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:580px;margin:0 auto;">Everything you need to get the most out of SmokeDrop &mdash; from setup guides to the e-commerce stack we recommend.</p>
      </div>
    </section>

    <!-- QUICK LINK CARDS -->
    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="contact-methods">
          <a href="<?php echo esc_url( $help_url ); ?>" class="cm-card reveal">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg></span>
            <h4>Help Center</h4>
            <p>FAQs &amp; documentation</p>
            <span class="cm-note">Answers to common questions about dropshipping, suppliers, and your account</span>
          </a>
          <a href="<?php echo esc_url( $blog_url ); ?>" class="cm-card reveal reveal-d1">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></span>
            <h4>Blog &amp; Guides</h4>
            <p>Insights &amp; how-tos</p>
            <span class="cm-note">Dropshipping strategies, industry trends, and growth tactics</span>
          </a>
          <a href="<?php echo esc_url( $tools_url ); ?>" class="cm-card reveal reveal-d2">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></span>
            <h4>Recommended Tools</h4>
            <p>The e-commerce stack we trust</p>
            <span class="cm-note">Merchant processing, web design, and shipping protection partners</span>
          </a>
          <a href="<?php echo esc_url( $testi_url ); ?>" class="cm-card reveal">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
            <h4>Testimonials</h4>
            <p>What retailers say</p>
            <span class="cm-note">Real stories from stores growing with SmokeDrop</span>
          </a>
          <a href="<?php echo esc_url( $contact_url ); ?>" class="cm-card reveal reveal-d1">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></span>
            <h4>Contact Support</h4>
            <p>Talk to our team</p>
            <span class="cm-note">Get help with setup, troubleshooting, or anything else</span>
          </a>
          <a href="<?php echo esc_url( $register ); ?>" class="cm-card reveal reveal-d2">
            <span class="cm-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg></span>
            <h4>Start Free Trial</h4>
            <p>7 days, no credit card</p>
            <span class="cm-note">Import products and start dropshipping in minutes</span>
          </a>
        </div>
      </div>
    </section>

    <!-- BLOG CATEGORIES -->
    <?php if ( ! empty( $sdn_cats ) && ! is_wp_error( $sdn_cats ) ) : ?>
    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap">
        <div class="center" style="margin-bottom:40px;">
          <p class="eyebrow reveal" style="justify-content:center;">Browse by topic</p>
          <h2 class="h-sec reveal reveal-d1" style="margin-top:16px;">Blog <span class="italic gradient-text">categories.</span></h2>
        </div>
        <div class="filter-bubbles reveal reveal-d2" style="justify-content:center;">
          <?php foreach ( $sdn_cats as $c ) : ?>
            <a href="<?php echo esc_url( get_category_link( $c ) ); ?>" class="filter-bubble"><?php echo esc_html( $c->name ); ?> <span><?php echo (int) $c->count; ?></span></a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php sdn_cta(); ?>
</main>

<?php
get_footer();
