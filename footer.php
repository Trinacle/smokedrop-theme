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
                        <svg viewBox="0 0 24 24" fill="#95bf47" width="20" height="20"><path d="M15.337 4.13a4.36 4.36 0 0 0-2.69 1.43 4.07 4.07 0 0 0-3.34-1.42c-2.41.12-3.96 2.13-3.96 4.4 0 4.04 3.86 7.04 5.95 8.34l.04.02.04-.02c2.09-1.3 5.95-4.3 5.95-8.34 0-2.27-1.55-4.28-3.96-4.4z"/></svg>
                        <span>Install on Shopify</span>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/download-smokedrop-plugin' ) ); ?>" class="foot-mini-cta">
                        <svg viewBox="0 0 24 24" fill="#7f54b3" width="20" height="20"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M9 8h4a3 3 0 0 1 0 6h-1l3 4" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Download WooCommerce Plugin</span>
                    </a>
                </div>
                <div class="foot-social">
                    <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
                    <a href="#" aria-label="X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2H21.5l-7.5 8.57L22.5 22h-6.844l-5.36-7.01L4.16 22H.9l8.02-9.17L1.5 2h6.99l4.84 6.4L18.244 2z"/></svg></a>
                    <a href="#" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 8.5a3 3 0 0 0-2.1-2.1C18 6 12 6 12 6s-6 0-7.9.4A3 3 0 0 0 2 8.5 31 31 0 0 0 2 12a31 31 0 0 0 .1 3.5 3 3 0 0 0 2 2.1C6 18 12 18 12 18s6 0 7.9-.4a3 3 0 0 0 2.1-2.1A31 31 0 0 0 22 12a31 31 0 0 0-.1-3.5z"/><polygon points="10 9 15 12 10 15" fill="currentColor"/></svg></a>
                    <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 8a6 6 0 0 1 6 6v6h-4v-6a2 2 0 0 0-4 0v6h-4v-10h4v1.5"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                </div>
            </div>
            <div class="foot-col">
                <h5>Platform</h5>
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
