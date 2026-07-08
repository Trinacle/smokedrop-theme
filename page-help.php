<?php
/**
 * Template Name: Help Center
 * Template Post Type: page
 *
 * FAQs & docs hub. Categorized accordion FAQ list + contact routes.
 * Assign this template to the WordPress Page mapped to /help/.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$contact_url = home_url( '/contact' );
$demo_url    = home_url( '/demo' );
$call_url    = home_url( '/call' );

// Categorized help articles. Edit freely — add rows to extend.
$sdn_help = array(
    'Getting Started' => array(
        array( 'How do I create a SmokeDrop account?',
            'Sign up free at app.thesmokedrop.com. No credit card required — you get full catalog access during the 14-day trial.' ),
        array( 'How do I connect my Shopify / WooCommerce / BigCommerce store?',
            'Install the SmokeDrop app from your platform\'s app store, or download the WooCommerce plugin. One click links your store and starts the inventory sync.' ),
        array( 'How long does setup take?',
            'Most retailers are live in under an hour: install the app, import a curated collection, set your prices, and you\'re selling.' ),
        array( 'Do I need a developer?',
            'No. The native apps handle everything. The REST API and CSV/FTP options are available for custom stacks if you need them later.' ),
    ),
    'Dropshipping' => array(
        array( 'How does blind dropshipping work?',
            'When a customer orders from you, SmokeDrop routes it to the nearest supplier, who ships under your brand within 24 hours. Your customer never sees our name.' ),
        array( 'How fast do orders ship?',
            'Most orders ship within 24 hours via smart routing to the supplier nearest your customer. We maintain a 98% on-time fulfillment rate.' ),
        array( 'How does inventory sync work?',
            'Inventory, price, and detail changes flow from suppliers into your store in real time — sub-minute updates, 24/7. You never sell what you don\'t have.' ),
        array( 'Can I set my own retail prices?',
            'Yes. You see wholesale cost before you import, then set any retail price. The difference is all yours. No PO fees, no commissions.' ),
    ),
    'Suppliers & Wholesale' => array(
        array( 'I\'m a supplier or brand — what does it cost?',
            'Suppliers and brands are 100% free: no listing fees, no transaction fees, unlimited retailers. The Supplier plan ($49.99/mo) unlocks advanced order automation and analytics.' ),
        array( 'How do payouts work?',
            'Escrow-based payouts run on a schedule, with batch invoicing, Net Terms, and credit memos. Funds land in your account automatically.' ),
    ),
    'Account & Billing' => array(
        array( 'Is there a free trial?',
            'Yes — both Retailer and Supplier plans include a 7-day free trial with full access. No credit card to start.' ),
        array( 'Are there transaction fees or commissions?',
            'No. SmokeDrop charges one flat monthly (or yearly) plan fee. No transaction fees and no commissions on anything you buy or sell.' ),
        array( 'Can I switch plans or cancel?',
            'Anytime. Upgrades take effect immediately; downgrades at the next cycle. No contracts, no penalties.' ),
    ),
);
?>

<main>
  <section class="page-hero">
    <div class="ph-smoke"><div class="ph-blob b1"></div><div class="ph-blob b2"></div><div class="ph-blob b3"></div></div>
    <div class="ph-inner center">
      <p class="eyebrow reveal" style="justify-content:center;">Help Center</p>
      <h1 class="display reveal reveal-d1" style="margin:24px 0;">FAQs &amp; <span class="italic gradient-text">docs.</span></h1>
      <p class="lede reveal reveal-d2" style="max-width:620px;margin:0 auto;">Answers to the questions retailers and suppliers ask most. Can't find what you need? Talk to our team.</p>
      <div class="hero-actions reveal reveal-d3" style="justify-content:center;margin-top:32px;">
        <a href="<?php echo esc_url( $contact_url ); ?>" class="btn btn-lime btn-lg">Contact support</a>
        <a href="<?php echo esc_url( $call_url ); ?>" class="btn btn-outline btn-lg">Book a call</a>
      </div>
    </div>
  </section>

  <?php foreach ( $sdn_help as $sdn_cat => $sdn_faqs ) : ?>
    <section class="sec<?php echo $sdn_cat === 'Getting Started' ? '" style="padding-top:60px' : ''; ?>">
      <div class="wrap wrap-tight">
        <p class="eyebrow reveal"><?php echo esc_html( $sdn_cat ); ?></p>
        <div class="faq-list reveal reveal-d1" style="margin-top:32px;">
          <?php foreach ( $sdn_faqs as $i => $sdn_faq ) : ?>
            <div class="faq-item<?php echo ( $sdn_cat === 'Getting Started' && $i === 0 ) ? ' open' : ''; ?>">
              <button class="faq-q"><?php echo esc_html( $sdn_faq[0] ); ?> <span class="pm"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span></button>
              <div class="faq-a"><p><?php echo esc_html( $sdn_faq[1] ); ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endforeach; ?>

  <?php sdn_cta(); ?>
</main>

<?php
get_footer();
