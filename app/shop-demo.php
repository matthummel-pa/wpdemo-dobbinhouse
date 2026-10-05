<?php

/**
 * Gift shop demo store: `wp cobbleandcandle-shop seed` adds the gift shop's products, turns on local pickup with
 * "Pay at pickup", and builds a Gift Shop page when the site has none. Safe to run again: products are matched
 * by SKU and settings the owner already changed are left alone. Only loads under WP-CLI with WooCommerce active.
 */

namespace App;

/**
 * Demo products: category, name, SKU, price, short description, featured.
 *
 * @return list<array{cat: string, name: string, sku: string, price: string, note: string, featured: bool}>
 */
function shop_demo_products(): array
{
    $bakery = __('Bakery', 'cobbleandcandle');
    $store = __('Country Curiosity Store', 'cobbleandcandle');

    return [
        ['cat' => $bakery, 'name' => __('Sticky Buns, Half Dozen', 'cobbleandcandle'), 'sku' => 'DH-BUNS-6', 'price' => '14.00', 'note' => __('Baked each morning with brown sugar, butter and toasted pecans. Best warmed for a minute before serving.', 'cobbleandcandle'), 'featured' => true],
        ['cat' => $bakery, 'name' => __('Shoofly Pie', 'cobbleandcandle'), 'sku' => 'DH-SHOOFLY', 'price' => '18.00', 'note' => __('A Pennsylvania Dutch molasses pie with a crumb top. Serves eight.', 'cobbleandcandle'), 'featured' => true],
        ['cat' => $bakery, 'name' => __('Apple Butter Bread', 'cobbleandcandle'), 'sku' => 'DH-APPLEBREAD', 'price' => '9.00', 'note' => __('A tender quick bread swirled with our apple butter. One loaf.', 'cobbleandcandle'), 'featured' => false],
        ['cat' => $bakery, 'name' => __('Colonial Gingerbread', 'cobbleandcandle'), 'sku' => 'DH-GINGER', 'price' => '8.00', 'note' => __('Dark, spiced and cut in squares, the way it was baked in 1776.', 'cobbleandcandle'), 'featured' => false],
        ['cat' => $store, 'name' => __('Apple Butter, 16 oz Jar', 'cobbleandcandle'), 'sku' => 'DH-APPLEBUTTER', 'price' => '9.00', 'note' => __('Slow-cooked from Adams County apples. Our most-asked-for take-home.', 'cobbleandcandle'), 'featured' => true],
        ['cat' => $store, 'name' => __('Beeswax Taper Candles, Pair', 'cobbleandcandle'), 'sku' => 'DH-TAPERS', 'price' => '16.00', 'note' => __('Hand-dipped 10-inch tapers that burn clean and smell of honey.', 'cobbleandcandle'), 'featured' => true],
        ['cat' => $store, 'name' => __('Pewter Tavern Mug', 'cobbleandcandle'), 'sku' => 'DH-MUG', 'price' => '42.00', 'note' => __('A lead-free pewter pint cast from an eighteenth-century pattern.', 'cobbleandcandle'), 'featured' => false],
        ['cat' => $store, 'name' => __('Tavern Recipe Cards, Set of 12', 'cobbleandcandle'), 'sku' => 'DH-RECIPES', 'price' => '15.00', 'note' => __('Colonial dishes from our kitchen, printed on heavy card stock.', 'cobbleandcandle'), 'featured' => false],
    ];
}

/**
 * Create or update the demo products, pickup and payment settings, and the Gift Shop page.
 *
 * @return array{created: int, updated: int, notes: list<string>}
 */
function shop_demo_seed(): array
{
    $result = ['created' => 0, 'updated' => 0, 'notes' => []];

    foreach (shop_demo_products() as $item) {
        $term = term_exists($item['cat'], 'product_cat');
        if (! $term) {
            $term = wp_insert_term($item['cat'], 'product_cat');
        }
        $term_id = is_array($term) ? (int) $term['term_id'] : 0;

        $id = (int) wc_get_product_id_by_sku($item['sku']);
        $product = $id ? wc_get_product($id) : new \WC_Product_Simple;
        if (! $product) {
            continue;
        }
        $product->set_name($item['name']);
        $product->set_sku($item['sku']);
        $product->set_regular_price($item['price']);
        $product->set_short_description($item['note']);
        $product->set_featured($item['featured']);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        if ($term_id) {
            $product->set_category_ids([$term_id]);
        }
        $product->save();
        $id ? $result['updated']++ : $result['created']++;
    }

    // Pickup at the gift shop counter, using the store address. The owner's own pickup list is kept.
    $address = [
        'address_1' => (string) get_option('woocommerce_store_address', ''),
        'city' => (string) get_option('woocommerce_store_city', ''),
        'state' => '',
        'postcode' => (string) get_option('woocommerce_store_postcode', ''),
        'country' => (string) get_option('woocommerce_default_country', 'US'),
    ];
    if (str_contains($address['country'], ':')) {
        [$address['country'], $address['state']] = explode(':', $address['country'], 2);
    }
    $pickup = (array) get_option('woocommerce_pickup_location_settings', []);
    if (($pickup['enabled'] ?? 'no') !== 'yes') {
        update_option('woocommerce_pickup_location_settings', array_merge($pickup, [
            'enabled' => 'yes',
            'title' => __('Pick up at the gift shop', 'cobbleandcandle'),
            'tax_status' => 'taxable',
            'cost' => '',
        ]));
    }
    if (! get_option('pickup_location_pickup_locations')) {
        update_option('pickup_location_pickup_locations', [[
            'name' => __('Gift shop counter', 'cobbleandcandle'),
            'address' => $address,
            'details' => __('We email you when your order is ready, usually within two hours.', 'cobbleandcandle'),
            'enabled' => true,
        ]]);
    }
    if ($address['address_1'] === '') {
        $result['notes'][] = __('Add the store address in WooCommerce → Settings → General; the pickup location uses it.', 'cobbleandcandle');
    }

    // Pay at pickup: WooCommerce's Cash on delivery gateway, renamed. A real card gateway can replace it later.
    $cod = (array) get_option('woocommerce_cod_settings', []);
    if (($cod['enabled'] ?? 'no') !== 'yes') {
        update_option('woocommerce_cod_settings', array_merge($cod, [
            'enabled' => 'yes',
            'title' => __('Pay at pickup', 'cobbleandcandle'),
            'description' => __('Pay by card or cash at the gift shop counter when you collect your order.', 'cobbleandcandle'),
            'instructions' => __('Pay at the gift shop counter when you collect your order. We email you when it is ready.', 'cobbleandcandle'),
            'enable_for_methods' => [],
            'enable_for_virtual' => 'yes',
        ]));
    }

    // A gift shop sells bakery items and keepsakes: no product reviews. First run only, so an owner can turn them on.
    if ($result['created'] > 0) {
        update_option('woocommerce_enable_reviews', 'no');
    }

    // The Shop page's hero copy.
    $shop_id = (int) wc_get_page_id('shop');
    if ($shop_id > 0 && ! has_excerpt($shop_id)) {
        wp_update_post(['ID' => $shop_id, 'post_excerpt' => __('Baked goods from the tavern kitchen and keepsakes from the Country Curiosity Store. Order online and pick up at the gift shop counter.', 'cobbleandcandle')]);
    }

    // A Gift Shop page with the live product grid, only when the site has none.
    if (! get_page_by_path('gift-shop')) {
        $pattern = \WP_Block_Patterns_Registry::get_instance()->get_registered('cobbleandcandle/shop-products');
        wp_insert_post([
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_name' => 'gift-shop',
            'post_title' => __('Gift Shop', 'cobbleandcandle'),
            'post_excerpt' => __('Sticky buns, shoofly pie and keepsakes from 1776. Order online and pick up at the counter.', 'cobbleandcandle'),
            'post_content' => $pattern['content'] ?? '',
        ]);
        $result['notes'][] = __('Created the Gift Shop page (/gift-shop/).', 'cobbleandcandle');
    }

    return $result;
}

if (defined('WP_CLI') && \WP_CLI) {
    add_action('init', function (): void {
        if (! shop_active()) {
            return;
        }
        \WP_CLI::add_command('cobbleandcandle-shop seed', function (): void {
            $result = shop_demo_seed();
            foreach ($result['notes'] as $note) {
                \WP_CLI::log($note);
            }
            \WP_CLI::success(sprintf('Gift shop: %d products created, %d updated.', $result['created'], $result['updated']));
        }, ['shortdesc' => 'Add the gift shop demo products, local pickup and Pay at pickup.']);
    }, 20);
}
