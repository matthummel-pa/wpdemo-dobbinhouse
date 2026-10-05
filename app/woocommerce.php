<?php

/**
 * WooCommerce readiness. Nothing here runs until WooCommerce is active, so the Gift Shop can stay a regular page
 * today and grow into an online store later (see docs/guide/woocommerce.md).
 */

namespace App;

/**
 * Whether WooCommerce is active.
 */
function shop_active(): bool
{
    return class_exists('WooCommerce');
}

/**
 * Declare support so WooCommerce uses the theme's block templates and styles instead of its fallbacks.
 */
add_action('after_setup_theme', function (): void {
    add_theme_support('woocommerce', [
        'thumbnail_image_width' => 600,
        'single_image_width' => 1200,
        'product_grid' => ['default_columns' => 3, 'min_columns' => 2, 'max_columns' => 4],
    ]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

/**
 * WooCommerce's own stylesheets fight the theme's tokens; the theme styles its blocks in resources/css/shop.css.
 * The block-based cart and checkout keep their own (layout-critical) styles.
 */
add_filter('woocommerce_enqueue_styles', function (array $styles): array {
    unset($styles['woocommerce-general'], $styles['woocommerce-layout'], $styles['woocommerce-smallscreen']);

    return $styles;
});

/**
 * Cart link for the utility bar, or '' when WooCommerce is off.
 *
 * @return array{url: string, label: string}|null
 */
function cart_link(): ?array
{
    if (! shop_active() || ! function_exists('wc_get_cart_url')) {
        return null;
    }

    return ['url' => (string) wc_get_cart_url(), 'label' => __('Cart', 'cobbleandcandle')];
}

/**
 * Page-hero copy for shop archives: the Shop page's own title and excerpt, or the product category's.
 *
 * @return array{title: string, lede: string, image_id: int}|null
 */
function shop_hero(): ?array
{
    if (! shop_active()) {
        return null;
    }
    if (function_exists('is_shop') && is_shop()) {
        $page = (int) wc_get_page_id('shop');

        return $page > 0
            ? ['title' => plain_title($page), 'lede' => has_excerpt($page) ? get_the_excerpt($page) : '', 'image_id' => (int) get_post_thumbnail_id($page)]
            : ['title' => __('Shop', 'cobbleandcandle'), 'lede' => '', 'image_id' => 0];
    }
    if (is_tax(['product_cat', 'product_tag'])) {
        $term = get_queried_object();
        $thumb = $term instanceof \WP_Term ? (int) get_term_meta($term->term_id, 'thumbnail_id', true) : 0;

        return [
            'title' => wp_specialchars_decode(single_term_title('', false), ENT_QUOTES),
            'lede' => wp_strip_all_tags(term_description()),
            'image_id' => $thumb,
        ];
    }

    return null;
}
