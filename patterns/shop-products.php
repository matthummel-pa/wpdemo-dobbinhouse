<?php
/**
 * Title: Shop products (online store)
 * Slug: cobbleandcandle/shop-products
 * Categories: cobbleandcandle
 * Keywords: shop, gift shop, products, woocommerce, store, cart, pickup
 * Description: Live WooCommerce products in the gift shop card style, with Add to cart, under a heading and a pickup note. Needs WooCommerce; without WooCommerce it inserts nothing, so use "Shop items grid".
 */
if (! \App\shop_active()) {
    return;
}
?>
<!-- wp:group {"align":"full","className":"section texture","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section texture"><!-- wp:group {"className":"container","layout":{"type":"default"}} -->
<div class="wp-block-group container"><!-- wp:group {"className":"shop-head","layout":{"type":"default"}} -->
<div class="wp-block-group shop-head"><!-- wp:group {"className":"shop-head-t","layout":{"type":"default"}} -->
<div class="wp-block-group shop-head-t"><!-- wp:paragraph {"className":"eyebrow"} -->
<p class="eyebrow"><?php echo esc_html__('Order online, pick up at the counter', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"h2"} -->
<h2 class="wp-block-heading h2"><?php echo esc_html__('Take a taste home', 'cobbleandcandle'); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"shop-note"} -->
<p class="shop-note"><?php echo esc_html__('Add what you want, pay when you collect it. We email you when your order is ready, usually within two hours.', 'cobbleandcandle'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/store-notices /-->

<!-- wp:woocommerce/product-collection {"queryId":1,"query":{"perPage":8,"pages":1,"offset":0,"postType":"product","order":"asc","orderBy":"menu_order","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"className":"shop-products","queryContextIncludes":["collection"]} -->
<div class="wp-block-woocommerce-product-collection shop-products"><!-- wp:woocommerce/product-template -->
<!-- wp:woocommerce/product-image {"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"showSaleBadge":false} /-->

<!-- wp:post-terms {"term":"product_cat","className":"shop-tag"} /-->

<!-- wp:post-title {"level":3,"isLink":true,"__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true} /-->

<!-- wp:post-excerpt {"excerptLength":24,"className":"shop-card-x","__woocommerceNamespace":"woocommerce/product-collection/product-summary"} /-->

<!-- wp:woocommerce/product-button {"isDescendentOfQueryLoop":true} /-->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection -->

<!-- wp:paragraph {"className":"shop-more"} -->
<p class="shop-more"><a href="<?php echo esc_url((string) get_permalink(wc_get_page_id('shop'))); ?>"><?php echo esc_html__('See everything in the shop', 'cobbleandcandle'); ?></a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
