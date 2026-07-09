<?php
/**
 * Brand content generator.
 *
 * Generates unique, brand-specific descriptive text and category detection
 * for each brand page, since the production brand pages are empty Astra
 * shells with no real content. Also resolves the brand's product images.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Detect a brand's primary category/niche from its name ---------- */
function sdn_brand_niche( $brand_name ) {
    $name = strtolower( $brand_name );
    $niches = array(
        'vaporizers'      => array( 'pax', 'puffco', 'dynavap', 'arizer', 'davinci', 'firefly', 'g pen', 'gpen', 'atmos', 'boundless', 'crafty', 'mighty', 'vape', 'vapor', 'xvape', 'vapmod', 'vapir', 'kandypens', 'airvape', 'geekvape', 'evolv', 'yocan', 'storz', 'stundenglass', 'cloudious', 'focus v', 'dr. dabber', 'dr dabber', 'hitoki', 'pulsar' ),
        'cbd & hemp'      => array( 'cbd', 'hemp', 'cbn', 'cbg', 'thc', 'delta', 'elfthc', '3chi', 'dozo', 'exodus', 'modus', 'hiXotic', 'just cbd', 'cbdmd', 'cbd daily', 'green roads', 'munchies', 'urb', 'wnc cbd', 'indacloud', 'zoetic', 'mitra', 'vivazen', 'kratom', 'mit45', 'hush', 'sweet lyfe', 'hydroxie', 'hyphoria' ),
        'glass & rigs'    => array( 'grav', 'empire glass', 'empire', 'cheech', 'mj arsenal', 'mj', 'dablabz', 'daze glass', 'dopezilla', 'softglass', 'diamond glass', 'calibear', 'groove glass', 'hillside glass', 'glass house', 'smoke', 'roor', 'zob', 'afm', 'afg', 'mathemat', 'piranha', 'cali crusher', 'grav labs', 'horny', 'maverick', 'tbwo' ),
        'rolling papers'  => array( 'raw', 'ocb', 'elements', 'zigzag', 'zig zag', 'juicy', 'blazy', 'randy', 'kushkards', 'twisted hemp', 'bob marley', 'high hemp', 'revelry', 'g-rollz', 'job', 'benji', 'OCB' ),
        'accessories'     => array( 'smokebuddy', 'smokezilla', 'boveda', 'integra', 'cvault', 'stashlogix', 'ryot', 'dime bags', ' Kannastor', 'santa cruz', 'sharpstone', 'cali crusher', 'grateful', 'stash', 'lock', 'canlock' ),
        'cbd'             => array( 'cbd', 'hemp', 'canna' ),
    );

    foreach ( $niches as $niche => $keywords ) {
        foreach ( $keywords as $kw ) {
            if ( strpos( $name, strtolower( $kw ) ) !== false ) {
                return $niche;
            }
        }
    }
    // Default: derive from initials for variety
    return 'smoke shop';
}

/* ---------- Generate unique descriptive copy for a brand ---------- */
function sdn_brand_description( $brand_name ) {
    $niche   = sdn_brand_niche( $brand_name );
    $first   = strtok( $brand_name, ' ' );

    // Niche-specific intro sentences (varied so each brand reads uniquely)
    $intros = array(
        'vaporizers'     => array(
            "$brand_name is a standout in the vaporizer category, known for engineering-driven hardware and a reputation that pulls customers into stores.",
            "As one of the most-requested vaporizer brands on the SmokeDrop marketplace, $brand_name pairs premium build quality with the kind of category recognition that drives repeat sales.",
            "Retailers carrying $brand_name benefit from a brand that buyers actively search for — a proven performer across dry herb, concentrate, and hybrid devices.",
        ),
        'cbd & hemp'     => array(
            "$brand_name is a Farm Bill compliant hemp and CBD brand carried by SmokeDrop, offering flower, prerolls, edibles, and concentrates that move fast in today's market.",
            "With cannabinoid products from $brand_name, retailers tap into one of the fastest-growing verticals — fully compliant, lab-tested, and dropship-ready.",
            "$brand_name brings a thoughtfully formulated CBD and hemp lineup to the marketplace, engineered for the customers already asking for it by name.",
        ),
        'glass & rigs'   => array(
            "$brand_name crafts sought-after glass — from water pipes and dab rigs to hand pipes — with the kind of artistry that turns first-time browsers into loyal collectors.",
            "As a glass specialist on the SmokeDrop marketplace, $brand_name delivers the statement pieces that anchor a headshop's display and drive impulse add-ons.",
            "$brand_name's glasswork is built to be photographed and shared, giving retailers products that market themselves on social and in-store.",
        ),
        'rolling papers' => array(
            "$brand_name is a rolling-paper and wraps staple — the high-velocity, high-margin consumables that every smoke shop restocks weekly.",
            "Carrying $brand_name means stocking the papers, cones, and wraps your customers already reach for, with wholesale pricing that protects your margin.",
            "$brand_name brings decades of rolling-category heritage to the marketplace, with the consistency and brand recognition that keeps shelves turning.",
        ),
        'accessories'    => array(
            "$brand_name makes the accessories that complete every purchase — grinders, storage, odor control, and tools that round out a basket.",
            "As a SmokeDrop accessories partner, $brand_name delivers the high-turn essentials that lift average order value without eating shelf space.",
            "$brand_name's accessories solve the everyday problems smokers have, which is exactly why they sell through again and again.",
        ),
        'smoke shop'     => array(
            "$brand_name is part of the SmokeDrop marketplace — a curated, dropship-ready catalog of the brands smoke shop customers already ask for.",
            "Retailers dropshipping $brand_name get instant access to a vetted supplier with automatic inventory sync and blind shipping under their own brand.",
            "$brand_name rounds out the SmokeDrop catalog with products built for the modern smoke, vape, and hemp retailer.",
        ),
    );

    // Deterministic pick based on the brand name so each brand is stable + unique
    $pool     = $intros[ $niche ];
    $pick     = abs( crc32( $brand_name ) ) % count( $pool );
    $intro    = $pool[ $pick ];

    $middle = " Dropship $brand_name products with zero inventory — every order routes to the right supplier and ships blind under your brand, with real-time stock and price sync across your Shopify, WooCommerce, or BigCommerce store. Or buy at wholesale pricing with no minimum order and stock your shelves directly.";

    $close = " $brand_name is ranked among the top brands on the SmokeDrop network, available to retailers and wholesalers with no transaction fees and no commissions.";

    return $intro . $middle . $close;
}

/* ---------- Get up to N product image URLs for a brand ----------
 * Matches products whose title contains the brand name, then pulls their
 * featured + gallery image IDs in ONE query (no per-product wc_get_product
 * calls). Result is cached 24h via a transient so repeat visits are instant.
 * Falls back to a curated set if the brand has no products yet.
 */
function sdn_brand_gallery_images( $brand_name, $limit = 3 ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return sdn_brand_gallery_fallback( $limit );
    }

    $cache_key = 'sdn_brand_gallery_' . md5( $brand_name . '_' . $limit );
    $cached    = get_transient( $cache_key );
    if ( is_array( $cached ) && ! empty( $cached ) ) {
        return $cached;
    }

    global $wpdb;
    $like = '%' . $wpdb->esc_like( $brand_name ) . '%';
    // Fetch product IDs + their _thumbnail_id and _product_image_gallery meta
    // in a single joined query (avoids N+1 wc_get_product() calls).
    $rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT p.ID, pm.meta_value AS thumb, pmg.meta_value AS gallery
         FROM {$wpdb->posts} p
         LEFT JOIN {$wpdb->postmeta} pm  ON pm.post_id = p.ID  AND pm.meta_key = '_thumbnail_id'
         LEFT JOIN {$wpdb->postmeta} pmg ON pmg.post_id = p.ID AND pmg.meta_key = '_product_image_gallery'
         WHERE p.post_type = 'product' AND p.post_status = 'publish'
           AND p.post_title LIKE %s
         ORDER BY p.post_date DESC
         LIMIT 12",
        $like
    ) );

    $image_ids = array();
    foreach ( $rows as $r ) {
        if ( ! empty( $r->thumb ) ) {
            $image_ids[] = (int) $r->thumb;
        }
        if ( ! empty( $r->gallery ) ) {
            foreach ( explode( ',', $r->gallery ) as $gid ) {
                $gid = (int) trim( $gid );
                if ( $gid ) $image_ids[] = $gid;
            }
        }
        $image_ids = array_values( array_unique( $image_ids ) );
        if ( count( $image_ids ) >= $limit ) break;
    }

    $images = array();
    foreach ( array_slice( $image_ids, 0, $limit ) as $aid ) {
        $url = wp_get_attachment_image_url( $aid, 'large' );
        if ( $url ) $images[] = $url;
    }

    if ( count( $images ) < $limit ) {
        $images = array_merge( $images, sdn_brand_gallery_fallback( $limit - count( $images ) ) );
    }
    $images = array_slice( array_unique( $images ), 0, $limit );

    set_transient( $cache_key, $images, DAY_IN_SECONDS );
    return $images;
}

/* ---------- Fallback product images when a brand has no Woo products ---------- */
function sdn_brand_gallery_fallback( $limit = 3 ) {
    $fallbacks = array(
        'https://images.unsplash.com/photo-1604881991720-f91add269bed?w=800&q=80',
        'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&q=80',
        'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=800&q=80',
        'https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?w=800&q=80',
    );
    return array_slice( $fallbacks, 0, $limit );
}
