<?php
/**
 * Title: Shop items grid
 * Slug: cobbleandcandle/shop-items
 * Categories: cobbleandcandle
 * Keywords: shop, gift shop, products, bakery, store, woocommerce
 * Description: A heading and a grid of item cards (photo, tag, name, price, note, call-to-hold link) for a gift shop page. Duplicate a card to add an item. When WooCommerce is active, swap the grid for a Product Collection block: it uses the same card styles.
 */
?>
<!-- wp:group {"align":"full","className":"section texture","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section texture"><!-- wp:group {"className":"container","layout":{"type":"default"}} -->
<div class="wp-block-group container"><!-- wp:group {"className":"shop-head","layout":{"type":"default"}} -->
<div class="wp-block-group shop-head"><!-- wp:group {"className":"shop-head-t","layout":{"type":"default"}} -->
<div class="wp-block-group shop-head-t"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php echo esc_html__('In the shop now', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2"} -->
<h2 class="wp-block-heading h2"><?php echo esc_html__('Take a taste home', 'cobbleandcandle'); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"shop-note"} -->
<p class="shop-note"><?php echo esc_html__('Stock changes with the seasons. Call ahead to hold an item for pickup.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"shop-grid","layout":{"type":"default"}} -->
<div class="wp-block-group shop-grid"><!-- wp:group {"className":"shop-card","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"shop-card-b","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card-b"><!-- wp:paragraph {"className":"shop-tag"} -->
<p class="shop-tag"><?php echo esc_html__('House favorite', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"shop-card-t"} -->
<h3 class="wp-block-heading shop-card-t"><?php echo esc_html__('Item name', 'cobbleandcandle'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"shop-price"} -->
<p class="shop-price">$20</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-x"} -->
<p class="shop-card-x"><?php echo esc_html__('One or two lines on what it is and why guests buy it.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-a"} -->
<p class="shop-card-a"><a href="<?php echo esc_url(\App\page_link('/locations/')); ?>"><?php echo esc_html__('Call to hold one', 'cobbleandcandle'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"shop-card","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"shop-card-b","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card-b"><!-- wp:paragraph {"className":"shop-tag"} -->
<p class="shop-tag"><?php echo esc_html__('House favorite', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"shop-card-t"} -->
<h3 class="wp-block-heading shop-card-t"><?php echo esc_html__('Item name', 'cobbleandcandle'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"shop-price"} -->
<p class="shop-price">$20</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-x"} -->
<p class="shop-card-x"><?php echo esc_html__('One or two lines on what it is and why guests buy it.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-a"} -->
<p class="shop-card-a"><a href="<?php echo esc_url(\App\page_link('/locations/')); ?>"><?php echo esc_html__('Call to hold one', 'cobbleandcandle'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"shop-card","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"shop-card-b","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card-b"><!-- wp:paragraph {"className":"shop-tag"} -->
<p class="shop-tag"><?php echo esc_html__('House favorite', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"shop-card-t"} -->
<h3 class="wp-block-heading shop-card-t"><?php echo esc_html__('Item name', 'cobbleandcandle'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"shop-price"} -->
<p class="shop-price">$20</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-x"} -->
<p class="shop-card-x"><?php echo esc_html__('One or two lines on what it is and why guests buy it.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-a"} -->
<p class="shop-card-a"><a href="<?php echo esc_url(\App\page_link('/locations/')); ?>"><?php echo esc_html__('Call to hold one', 'cobbleandcandle'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"shop-card","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card"><!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
<figure class="wp-block-image size-large"><img alt=""/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"shop-card-b","layout":{"type":"default"}} -->
<div class="wp-block-group shop-card-b"><!-- wp:paragraph {"className":"shop-tag"} -->
<p class="shop-tag"><?php echo esc_html__('House favorite', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"shop-card-t"} -->
<h3 class="wp-block-heading shop-card-t"><?php echo esc_html__('Item name', 'cobbleandcandle'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"shop-price"} -->
<p class="shop-price">$20</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-x"} -->
<p class="shop-card-x"><?php echo esc_html__('One or two lines on what it is and why guests buy it.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"shop-card-a"} -->
<p class="shop-card-a"><a href="<?php echo esc_url(\App\page_link('/locations/')); ?>"><?php echo esc_html__('Call to hold one', 'cobbleandcandle'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
