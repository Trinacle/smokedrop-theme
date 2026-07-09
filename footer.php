<?php
/**
 * The footer for SmokeDrop Noir
 *
 * @package SmokeDropNoir
 */
?>

<footer class="footer site-footer">
    <div class="footer-inner">
        <div class="foot-newsletter">
            <div>
                <h3>Get the drop.</h3>
                <p>New brands, guides, and growth tactics, monthly. No spam.</p>
            </div>
            <form class="news-form" onsubmit="return false">
                <input type="email" placeholder="you@yourstore.com">
                <button class="btn btn-lime">Subscribe</button>
            </form>
        </div>

        <div class="foot-grid">
            <div class="foot-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand"><?php echo sdn_logo( 42 ); // phpcs:ignore ?></a>
                <p>The wholesale and dropshipping platform for the smoke, vape, and hemp industry. Sync 20,000+ products in one click.</p>
                <div class="foot-cta-stack">
    <a href="https://apps.shopify.com/smoke-drop" class="foot-mini-cta">
        <span class="fmc-ic"><img src="<?php echo esc_url( home_url( '/wp-content/uploads/2024/01/5f1a58272cd5b8c219db0ba4_shopify-logo.svg' ) ); ?>" alt="Shopify" style="width:30px;height:30px;object-fit:contain;"></span>
        <span>Install on Shopify</span>
    </a>
    <a href="<?php echo esc_url( home_url( '/download-smokedrop-plugin' ) ); ?>" class="foot-mini-cta">
        <span class="fmc-ic"><img src="<?php echo esc_url( home_url( '/wp-content/uploads/2024/01/5f1a59d6f884854a22b65124_woocommerce-logo.svg' ) ); ?>" alt="WooCommerce" style="width:30px;height:30px;object-fit:contain;"></span>
        <span>Download WooCommerce Plugin</span>
    </a>
                </div>
                <div class="foot-social">
                    <a href="https://www.facebook.com/thesmokedrop/" aria-label="Facebook" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.56 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.78-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99A10 10 0 0 0 22 12z"/></svg></a>
                    <a href="https://x.com/smokedropapp" aria-label="X" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2H21.5l-7.5 8.57L22.5 22h-6.844l-5.36-7.01L4.16 22H.9l8.02-9.17L1.5 2h6.99l4.84 6.4L18.244 2z"/></svg></a>
                    <a href="https://www.youtube.com/@thesmokedrop" aria-label="YouTube" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 8.5a3 3 0 0 0-2.1-2.1C18 6 12 6 12 6s-6 0-7.9.4A3 3 0 0 0 2 8.5 31 31 0 0 0 2 12a31 31 0 0 0 .1 3.5 3 3 0 0 0 2 2.1C6 18 12 18 12 18s6 0 7.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 22 12a31 31 0 0 0-.1-3.5z"/><polygon points="10 9 15 12 10 15" fill="currentColor"/></svg></a>
                </div>
            </div>
            <div class="foot-col">
                <h5>Platforms</h5>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Overview</a>
                <a href="<?php echo esc_url( home_url( '/retailers' ) ); ?>">For Retailers</a>
                <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Suppliers</a>
                <a href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>">For Wholesalers</a>
                <a href="<?php echo esc_url( home_url( '/pricing' ) ); ?>">Pricing</a>
                <a href="<?php echo esc_url( home_url( '/integrations' ) ); ?>">Integrations</a>
            </div>
            <div class="foot-col">
                <h5>Solutions</h5>
                <a href="<?php echo esc_url( home_url( '/retailers' ) ); ?>">For Retailers</a>
                <a href="<?php echo esc_url( home_url( '/suppliers' ) ); ?>">For Suppliers</a>
                <a href="<?php echo esc_url( home_url( '/wholesalers' ) ); ?>">For Wholesalers</a>
                <a href="<?php echo esc_url( home_url( '/industries' ) ); ?>">Industries</a>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'product' ) ?: home_url( '/shop' ) ); ?>">Marketplace</a>
            </div>
            <div class="foot-col">
                <h5>Brands We Carry</h5>
                <a href="<?php echo esc_url( home_url( '/brand/cookies/' ) ); ?>">Cookies</a>
                <a href="<?php echo esc_url( home_url( '/brand/pax/' ) ); ?>">PAX</a>
                <a href="<?php echo esc_url( home_url( '/brand/puffco/' ) ); ?>">Puffco</a>
                <a href="<?php echo esc_url( home_url( '/brand/vessel/' ) ); ?>">Vessel</a>
                <a href="<?php echo esc_url( home_url( '/brands' ) ); ?>">View 300+</a>
            </div>
            <div class="foot-col">
                <h5>Resources</h5>
                <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">Blog</a>
                <a href="<?php echo esc_url( home_url( '/testimonials' ) ); ?>">Testimonials</a>
                <a href="<?php echo esc_url( home_url( '/help' ) ); ?>">Help Center</a>
                <a href="<?php echo esc_url( home_url( '/demo' ) ); ?>">Get a Demo</a>
                <a href="<?php echo esc_url( home_url( '/call' ) ); ?>">Schedule Call</a>
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
                <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a>
            </div>
        </div>

        <div class="foot-bottom">
            <div>&copy; <span data-year><?php echo esc_html( date( 'Y' ) ); ?></span> SmokeDrop. &nbsp;
                <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" style="color:var(--ink-mute);">Privacy</a> &middot;
                <a href="<?php echo esc_url( home_url( '/terms-of-use' ) ); ?>" style="color:var(--ink-mute);">Terms</a> &middot;
                <a href="<?php echo esc_url( home_url( '/retailer-terms-of-use-agreement' ) ); ?>" style="color:var(--ink-mute);">Retailer Agreement</a> &middot;
                <a href="<?php echo esc_url( home_url( '/terms-of-use-for-suppliers' ) ); ?>" style="color:var(--ink-mute);">Supplier Agreement</a> &middot;
                <a href="<?php echo esc_url( home_url( '/sitemap' ) ); ?>" style="color:var(--ink-mute);">Sitemap</a>
            </div>
            <div style="display:flex;align-items:center;gap:16px;">
                <button id="theme-toggle" aria-label="Toggle light/dark mode" style="display:inline-flex;align-items:center;gap:8px;padding:8px 14px;border-radius:999px;background:rgba(255,255,255,.06);border:1px solid var(--line);color:var(--ink-mute);font-size:.82rem;font-weight:500;cursor:pointer;transition:all .25s;">
                    <svg id="theme-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.2" y1="4.2" x2="5.6" y2="5.6"/><line x1="18.4" y1="18.4" x2="19.8" y2="19.8"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.2" y1="19.8" x2="5.6" y2="18.4"/><line x1="18.4" y1="5.6" x2="19.8" y2="4.2"/></svg>
                    <span id="theme-label">Light</span>
                </button>
                <span>thesmokedrop.com</span>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
