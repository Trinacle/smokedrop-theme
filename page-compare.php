<?php
/**
 * Template Name: Compare
 * Template Post Type: page
 *
 * SmokeDrop vs Crowdship, Spocket, Duoplane — competitor comparison.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

/**
 * Comparison matrix.
 *
 * Each row: [ feature, smoke, crowdship, spocket, duoplane ] where each value
 * after the label is a boolean (true = check, false = cross).
 */
$matrix = array(
    array( 'Free retailer tier',                  true,  false, true,  false ),
    array( 'No PO / transaction fees',            true,  false, false, true  ),
    array( 'Built for smoke/vape/CBD',            true,  true,  false, false ),
    array( 'Blind dropshipping',                  true,  true,  true,  true  ),
    array( 'Automatic order routing',            true,  true,  false, true  ),
    array( 'Real-time inventory sync',            true,  true,  true,  true  ),
    array( 'Automated supplier payments',         true,  true,  false, false ),
    array( 'Dropship accounting (QuickBooks)',    true,  true,  false, false ),
    array( '300+ smoke/vape brands',              true,  true,  false, false ),
    array( 'Shopify / WooCommerce / BigCommerce', true,  true,  true,  true  ),
    array( 'REST API',                            true,  true,  false, true  ),
);
?>

<main>
    <section class="hero" style="min-height:auto;padding-top:180px;padding-bottom:60px;">
      <div class="hero-inner">
        <p class="eyebrow reveal">Compare</p>
        <h1 class="display reveal reveal-d1" style="margin:24px 0;">SmokeDrop vs<br><span class="italic gradient-text">the rest.</span></h1>
        <p class="lede reveal reveal-d2" style="max-width:620px;">Built specifically for smoke, vape, CBD and hemp. No PO fees, no hidden margin tax, a free retailer tier, and the deepest headshop catalog on the market.</p>
      </div>
    </section>

    <section class="sec" style="padding-top:40px;">
      <div class="wrap">
        <div class="bento" style="margin-bottom:64px;">
          <div class="bento-cell lime reveal">
            <div class="inner"><p class="bento-eyebrow">vs Crowdship</p><h3>No PO fees. No margin tax.</h3><p>Crowdship charges a 2&ndash;10% fee on every supplier cost. SmokeDrop doesn't tax your margin. Ever.</p></div>
          </div>
          <div class="bento-cell dark reveal reveal-d1">
            <div class="inner"><p class="bento-eyebrow">vs Spocket</p><h3>Built for smoke, not AliExpress.</h3><p>Spocket is for generic goods with 2-week shipping. SmokeDrop is USA-based with automatic order fulfillment and tracking sync.</p></div>
          </div>
          <div class="bento-cell dark reveal reveal-d2">
            <div class="inner"><p class="bento-eyebrow">vs Duoplane</p><h3>Automation, not just routing.</h3><p>Duoplane routes orders. SmokeDrop automates sourcing, sync, payments, and fulfillment end to end.</p></div>
          </div>
        </div>

        <div class="reveal reveal-d1" style="overflow-x:auto;">
          <table class="compare-table">
            <thead>
              <tr>
                <th>Feature</th>
                <th class="us">SmokeDrop</th>
                <th class="them">Crowdship</th>
                <th class="them">Spocket</th>
                <th class="them">Duoplane</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ( $matrix as $row ) :
                  list( $feat, $sd, $cs, $sp, $dp ) = $row;
                  ?>
                  <tr>
                    <td class="feat"><?php echo esc_html( $feat ); ?></td>
                    <td class="us <?php echo $sd ? 'yes' : 'no'; ?>"></td>
                    <td class="them <?php echo $cs ? 'yes' : 'no'; ?>"></td>
                    <td class="them <?php echo $sp ? 'yes' : 'no'; ?>"></td>
                    <td class="them <?php echo $dp ? 'yes' : 'no'; ?>"></td>
                  </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <section class="sec" style="background:var(--bg-2);">
      <div class="wrap wrap-tight center">
        <p class="eyebrow reveal" style="justify-content:center;">The verdict</p>
        <h2 class="display reveal reveal-d1" style="margin-top:24px;">Switch to SmokeDrop.<br><span class="italic gradient-text">Keep your margin.</span></h2>
        <p class="lede reveal reveal-d2" style="margin-top:24px;max-width:580px;">Migrate from Crowdship, Spocket, or Duoplane in days, not months. Free to start, no PO fees, no hidden margin tax.</p>
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-lg reveal reveal-d3" style="margin-top:32px;">Start free migration</a>
      </div>
    </section>
</main>

<?php
get_footer();
