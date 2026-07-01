<?php
/**
 * ACF field groups for Brands CPT
 *
 * Registers custom fields via PHP (works even without ACF being active if
 * the fallback helper below is used). Requires ACF Pro for oEmbed + Gallery.
 *
 * @package SmokeDropNoir
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Register ACF field group for Brand CPT ---------- */
add_action( 'acf/init', 'sdn_register_brand_fields' );
function sdn_register_brand_fields() {

    // Bail if ACF isn't active (the helpers.php fallback handles missing fields)
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( array(
        'key'      => 'group_brand_details',
        'title'    => 'Brand Details',
        'fields'   => array(

            // Brand Logo
            array(
                'key'           => 'field_brand_logo',
                'label'         => 'Brand Logo',
                'name'          => 'brand_logo',
                'type'          => 'image',
                'instructions'  => 'Upload the brand logo (PNG with transparency preferred). Used in mega menu, brand cards, and footer.',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ),

            // Hero Image (already uses featured image, but this is the split-hero image)
            array(
                'key'           => 'field_brand_hero_image',
                'label'         => 'Split-Hero Image',
                'name'          => 'brand_hero_image',
                'type'          => 'image',
                'instructions'  => 'The large image shown on the left side of the brand landing page (50/50 split). If empty, uses the Featured Image.',
                'return_format' => 'url',
                'preview_size'  => 'sdn-brand-hero',
            ),

            // Gallery (flexible count)
            array(
                'key'           => 'field_brand_gallery',
                'label'         => 'Product Gallery',
                'name'          => 'brand_gallery',
                'type'          => 'gallery',
                'instructions'  => 'Upload 3+ product/lifestyle images. Displayed in a responsive grid. Unlimited count.',
                'return_format' => 'id',
                'preview_size'  => 'sdn-brand-gallery',
                'insert'        => 'append',
                'library'       => 'all',
            ),

            // Video URL (YouTube / Instagram / Facebook)
            array(
                'key'           => 'field_brand_video_url',
                'label'         => 'Video URL',
                'name'          => 'brand_video_url',
                'type'          => 'oEmbed',
                'instructions'  => 'Paste a YouTube, Instagram, or Facebook video URL. Rendered as an embed on the brand page.',
                'width'         => '70',
            ),

            // Video type (fallback for non-oEmbed sources like IG/FB)
            array(
                'key'           => 'field_brand_video_type',
                'label'         => 'Video Platform',
                'name'          => 'brand_video_type',
                'type'          => 'select',
                'instructions'  => 'Used for proper iframe rendering if oEmbed fails.',
                'choices'       => array(
                    'youtube'   => 'YouTube',
                    'instagram' => 'Instagram',
                    'facebook'  => 'Facebook',
                    'vimeo'     => 'Vimeo',
                ),
                'allow_null'    => true,
                'width'         => '30',
            ),

            // Brand Categories
            array(
                'key'           => 'field_brand_categories',
                'label'         => 'Categories',
                'name'          => 'brand_categories',
                'type'          => 'text',
                'instructions'  => 'e.g., "Vaporizers, Bongs, Apparel". Shown as tags on the brand page.',
                'placeholder'   => 'Vaporizers, Bongs, Apparel',
            ),

            // Featured (shows in mega menu + featured grid)
            array(
                'key'           => 'field_brand_featured',
                'label'         => 'Featured Brand',
                'name'          => 'brand_featured',
                'type'          => 'true_false',
                'instructions'  => 'Show in the featured brands grid and mega menu.',
                'default_value' => 0,
                'ui'            => 1,
            ),

            // Official Website
            array(
                'key'           => 'field_brand_website',
                'label'         => 'Official Website',
                'name'          => 'brand_website',
                'type'          => 'url',
                'instructions'  => 'The brand\'s official website (optional).',
            ),

            // Marketing tagline
            array(
                'key'           => 'field_brand_tagline',
                'label'         => 'Tagline',
                'name'          => 'brand_tagline',
                'type'          => 'text',
                'instructions'  => 'A short punchy tagline for the brand (shown in the hero).',
                'placeholder'   => 'Battery-free. Built to last.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'brand',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'field',
        'active'                => true,
    ) );
}
