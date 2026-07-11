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

<!-- Screen loader -->
<div id="sdn-loader" class="sdn-loader">
    <div class="sdn-loader-logo">
        <?php echo sdn_logo( 36 ); // phpcs:ignore ?>
    </div>
</div>

<div class="mega-backdrop"></div>

<header class="site">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand" data-cursor>
        <?php echo sdn_logo( 34 ); // phpcs:ignore ?>
    </a>

    <nav class="nav-row" aria-label="Primary">
        <div class="nav-item has-mega" data-menu="solutions">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/solutions' ) ); ?>">Solutions <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
        <div class="nav-item has-mega" data-menu="brands">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
        <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a></div>
        <div class="nav-item"><a class="nav-link" href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/marketplace' ) ); ?>">Marketplace</a></div>
        <div class="nav-item has-mega" data-menu="resources">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/resources' ) ); ?>">Resources <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
        <div class="nav-item has-mega" data-menu="advertise">
            <a class="nav-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>">Advertise <?php echo sdn_chevron(); // phpcs:ignore ?></a>
        </div>
    </nav>

    <div class="nav-cta">
        <button class="header-search-btn" aria-label="Search products" id="header-search-trigger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <a href="https://apps.shopify.com/smoke-drop" class="btn btn-outline hide-mob" style="font-size:.85rem;padding:8px 16px;">Shopify App</a>
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime">Get Started</a>
        <button class="menu-trigger" aria-label="Menu" aria-expanded="false"><span></span></button>
    </div>
</header>

<!-- HEADER SEARCH OVERLAY -->
<div class="header-search-overlay" id="header-search-overlay" hidden>
    <form role="search" method="get" action="<?php echo esc_url( home_url( '/marketplace-search' ) ); ?>" class="header-search-form">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="search" name="q" placeholder="Search 20,000+ products and brands…" autocomplete="off" autofocus>
        <button type="button" class="header-search-close" aria-label="Close search">&times;</button>
    </form>
</div>

<!-- SIMPLE DROPDOWN MENU -->
<div class="mega">
    <div class="mega-inner">
        <div class="mega-panels">

            <!-- SOLUTIONS PANEL -->
            <div class="mega-panel" data-panel="solutions">
                <div class="mega-grid">
                    <div class="mega-col-head">Solutions</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/retailers' ) ); ?>"><strong>For Retailers</strong><span>Automate dropshipping &amp; sync inventory</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>"><strong>For Suppliers</strong><span>Launch a dropship channel, from $49.99/mo</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>"><strong>For Wholesalers</strong><span>Grow distribution</span></a>

                    <div class="mega-col-head">Platform</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/platform' ) ); ?>"><strong>Platform Overview</strong><span>How SmokeDrop works</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/pricing' ) ); ?>"><strong>Pricing</strong><span>7-day free trial, from $49.99/mo</span></a>

                    <div class="mega-col-head">Resources</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/help' ) ); ?>"><strong>Help Center</strong><span>FAQs &amp; docs</span></a>
                    <a class="mega-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><strong>Blog</strong><span>Guides &amp; insights</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/demo' ) ); ?>"><strong>Get a Demo</strong><span>See SmokeDrop in action</span></a>
                </div>
            </div>

            <!-- BRANDS PANEL -->
            <div class="mega-panel" data-panel="brands">
                <div class="mega-grid">
                    <?php
                    // Top brands (logo'd) linking to their /brand/{slug}/ page.
                    $sdn_mega_brands = sdn_real_brand_logos();
                    $sdn_brands_url  = home_url( '/brands' );
                    if ( ! empty( $sdn_mega_brands ) ) :
                        echo '<div class="mega-col-head">Featured Brands</div>';
                        foreach ( $sdn_mega_brands as $b ) {
                            printf(
                                '<a class="mega-link" href="%1$s"><strong>%2$s</strong><span>View products &amp; dropship</span></a>',
                                esc_url( home_url( '/brand/' . $b['slug'] . '/' ) ),
                                esc_html( $b['name'] )
                            );
                        }
                    endif;
                    ?>
                </div>
            </div>

            <!-- RESOURCES PANEL -->
            <div class="mega-panel" data-panel="resources">
                <div class="mega-grid">
                    <div class="mega-col-head">Getting Started</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/demo' ) ); ?>"><strong>Get a Demo</strong><span>See SmokeDrop in action</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/help' ) ); ?>"><strong>Help Center</strong><span>FAQs &amp; docs</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/call' ) ); ?>"><strong>Schedule a Call</strong><span>Book a support call</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/quick-start-guide' ) ); ?>"><strong>Quick Start Guide</strong><span>Live in under an hour</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/recommend-tools-for-ecommerce' ) ); ?>"><strong>Recommended Tools</strong><span>E-commerce stack we trust</span></a>

                    <?php
                    // Blog categories (top 6 by post count).
                    $sdn_mega_cats = get_categories( array(
                        'taxonomy'   => 'category',
                        'hide_empty' => true,
                        'number'     => 6,
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                    ) );
                    if ( ! empty( $sdn_mega_cats ) && ! is_wp_error( $sdn_mega_cats ) ) :
                        echo '<div class="mega-col-head">Blog Categories</div>';
                        foreach ( $sdn_mega_cats as $cat ) {
                            printf(
                                '<a class="mega-link" href="%1$s"><strong>%2$s</strong><span>%3$s articles</span></a>',
                                esc_url( get_category_link( $cat ) ),
                                esc_html( $cat->name ),
                                (int) $cat->count
                            );
                        }
                    endif;
                    ?>

                    <div class="mega-col-head">More</div>
                    <a class="mega-link" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><strong>Blog</strong><span>Guides &amp; insights</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/testimonials' ) ); ?>"><strong>Testimonials</strong><span>What retailers say</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><strong>Contact</strong><span>Talk to our team</span></a>
                </div>
            </div>

            <!-- ADVERTISE PANEL -->
            <div class="mega-panel" data-panel="advertise">
                <div class="mega-grid">
                    <div class="mega-col-head">Ad Packages</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>#featured"><strong>Featured Listings</strong><span>Top of search &amp; category</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>#homepage"><strong>Homepage Takeover</strong><span>Logo wall &amp; hero placement</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>#newsletter"><strong>Newsletter Sponsorship</strong><span>Reach retailers in their inbox</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>#sponsored"><strong>Sponsored Content</strong><span>Brand spotlights &amp; guides</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>#all-in"><strong>All-In Bundle</strong><span>Everything, 10% off</span></a>

                    <div class="mega-col-head">Get Started</div>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/advertise' ) ); ?>"><strong>View All Packages</strong><span>Pricing &amp; details</span></a>
                    <a class="mega-link" href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><strong>Talk to Sales</strong><span>Build a custom package</span></a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MOBILE NAV -->
<div class="mobile-nav">
    <div class="mn-auth">
        <a href="https://wholesale.thesmokedrop.com/login" class="btn btn-outline btn-block">Log in</a>
        <a href="https://wholesale.thesmokedrop.com/register" class="btn btn-lime btn-block">Create account</a>
    </div>
    <nav class="mn-links">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
        <a href="<?php echo esc_url( home_url( '/retailers' ) ); ?>">For Retailers</a>
        <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Suppliers</a>
        <a href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>">For Wholesalers</a>
        <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">Brands We Carry</a>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/marketplace' ) ); ?>">Marketplace</a>
        <a href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a>
        <a href="<?php echo esc_url( home_url( '/advertise' ) ); ?>">Advertise</a>
        <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a>
        <a href="<?php echo esc_url( home_url( '/help' ) ); ?>">Help Center</a>
        <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
    </nav>
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
