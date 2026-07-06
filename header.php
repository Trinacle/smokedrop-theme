<?php
/**
 * The header for SmokeDrop Noir
 *
 * @package SmokeDropNoir
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="mega-backdrop"></div>

<header class="site">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" data-cursor>
        <?php echo sdn_logo( 34 ); // phpcs:ignore ?>
    </a>

    <nav class="nav-row" aria-label="Primary">
        <div class="nav-item has-mega" data-menu="solutions">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">Solutions <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
        <div class="nav-item has-mega" data-menu="brands">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
        <?php
        // Direct nav items — editable via WordPress Menus (Appearance > Menus)
        // Fallback to hardcoded links if no menu is assigned
        if ( has_nav_menu( 'solutions' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'solutions',
                'container'      => false,
                'menu_class'     => '',
                'depth'          => 1,
                'fallback_cb'    => false,
                'items_wrap'     => '%3$s',
                'walker'         => new SDN_Direct_Nav_Walker(),
            ) );
        } else {
            // Hardcoded fallback (matches the static prototype)
            ?>
            <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/shop' ) ); ?>">Marketplace</a></div>
            <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a></div>
            <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( home_url( '/compare' ) ); ?>">Compare</a></div>
            <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Resources</a></div>
            <?php
        }
        ?>
    </nav>

    <div class="nav-cta">
        <a href="https://apps.shopify.com/smoke-drop" class="btn btn-outline hide-mob" style="font-size:.85rem;padding:8px 16px;">Shopify App</a>
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime">Get Started</a>
        <button class="menu-trigger" aria-label="Menu" aria-expanded="false"></button>
    </div>
</header>

<!-- SIMPLE DROPDOWN MENU -->
<div class="mega">
    <div class="mega-inner">
        <div class="mega-panels">

            <!-- SOLUTIONS PANEL -->
            <div class="mega-panel active" data-panel="solutions">
                <div class="mega-grid">
                    <div class="mega-col-head">Solutions</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/retailers' ) ); ?>"><strong>For Retailers</strong><span>Automate dropshipping & sync inventory</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>"><strong>For Suppliers</strong><span>Launch a dropship channel, from $49.99/mo</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>"><strong>For Wholesalers</strong><span>Grow distribution</span></a>

                    <div class="mega-col-head">Platform</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/platform' ) ); ?>"><strong>Platform Overview</strong><span>How SmokeDrop works</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/pricing' ) ); ?>"><strong>Pricing</strong><span>7-day free trial, from $49.99/mo</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/compare' ) ); ?>"><strong>Compare</strong><span>vs Crowdship, Spocket, Duoplane</span></a>

                    <div class="mega-col-head">Resources</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/testimonials' ) ); ?>"><strong>Testimonials</strong><span>What retailers say</span></a>
                    <a class="mega-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><strong>Blog</strong><span>Guides & insights</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/help' ) ); ?>"><strong>Help Center</strong><span>FAQs & docs</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/demo' ) ); ?>"><strong>Get a Demo</strong><span>See SmokeDrop in action</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/call' ) ); ?>"><strong>Schedule Call</strong><span>Book a support call</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><strong>Contact</strong><span>Talk to our team</span></a>
                </div>
            </div>

            <!-- BRANDS PANEL -->
            <div class="mega-panel" data-panel="brands" style="display:none;">
                <div class="mega-grid">
                    <?php
                    // Real brands from the live marketplace (sdn_real_brand_logos()
                    // is the source of truth until the brand CPT is populated).
                    $sdn_mega_brands = sdn_real_brand_logos();
                    $sdn_brands_url  = home_url( '/brands' );
                    if ( ! empty( $sdn_mega_brands ) ) :
                        echo '<div class="mega-col-head">All Brands</div>';
                        foreach ( $sdn_mega_brands as $b ) {
                            printf(
                                '<a class="mega-link" href="%1$s#brand-%2$s"><strong>%3$s</strong><span>View on the marketplace</span></a>',
                                esc_url( $sdn_brands_url ),
                                esc_attr( $b['slug'] ),
                                esc_html( $b['name'] )
                            );
                        }
                    endif;
                    ?>

                    <div class="mega-col-head">Shop by Category</div>
                    <a class="mega-link" href="<?php echo esc_url( $sdn_brands_url ); ?>"><strong>Vaporizers</strong><span>Dry herb & concentrate</span></a>
                    <a class="mega-link" href="<?php echo esc_url( $sdn_brands_url ); ?>"><strong>Hemp & CBD</strong><span>Flower, prerolls, edibles</span></a>
                    <a class="mega-link" href="<?php echo esc_url( $sdn_brands_url ); ?>"><strong>Glass & Rigs</strong><span>Bongs, dab rigs, tools</span></a>
                    <a class="mega-link" href="<?php echo esc_url( $sdn_brands_url ); ?>"><strong>All Brands</strong><span>Browse 300+ in the catalog</span></a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MOBILE NAV -->
<div class="mobile-nav">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
    <a href="<?php echo esc_url( home_url( '/retailers' ) ); ?>">For Retailers</a>
    <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Suppliers</a>
    <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Wholesalers</a>
    <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands We Carry</a>
    <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/shop' ) ); ?>">Marketplace</a>
    <a href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a>
    <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a>
    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
</div>


<?php
/**
 * Custom nav walker for direct (non-mega) nav items
 */
class SDN_Direct_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $output .= '<div class="nav-item"><a class="nav-link" href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a></div>';
    }
    function end_el( &$output, $item, $depth = 0, $args = array() ) {}
}
?>
