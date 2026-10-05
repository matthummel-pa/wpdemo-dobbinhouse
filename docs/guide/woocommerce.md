# Gift shop and WooCommerce

The Gift Shop is a regular page built from core blocks, so staff can edit items in the block editor with no plugin. The theme is ready for WooCommerce if the shop later sells online.

## Today: the Gift Shop page

- Each item is a **group with the class `shop-card`**: image, tag (`shop-tag`), name (H3, `shop-card-t`), price (`shop-price`), note (`shop-card-x`) and a call-to-hold link (`shop-card-a`). To add an item, select a card and choose **Duplicate**.
- The cards sit in a group with the class `shop-grid` (4 columns on desktop, 2 on tablet, 1 on small phones).
- Insert **Patterns → Cobble & Candle → Shop items grid** to start a new grid on any page.
- Other sections on the page use `shop-split`, `shop-facts`, `shop-frames`, `shop-aside`, `shop-steps` and `shop-faq`. They are styled in `resources/css/shop.css`.

## Later: turning on WooCommerce

The theme already declares WooCommerce support, ships `archive-product`, `taxonomy-product_cat` and `single-product` block templates, and styles WooCommerce's product cards to match `.shop-card`. WooCommerce's own front-end stylesheets are turned off. Nothing loads until WooCommerce is active.

1. Install and activate WooCommerce. Skip its theme and store-design suggestions.
2. Add each item as a **Product**: the card's name, price, note (short description) and photo. Use product categories such as "Bakery" and "Country Curiosity Store".
3. For pickup only, set up **Local pickup** in WooCommerce → Settings → Shipping, and turn off shipping zones you don't need.
4. On the Gift Shop page, replace the `shop-grid` group with a **Product Collection** block (or the "Featured products" collection). The cards keep the same look.
5. WooCommerce's **Shop** page (`/shop/`) uses `templates/archive-product.html`: the Page Hero shows the Shop page's title and excerpt. To keep the Gift Shop as the landing page, leave the Shop page separate and link to it ("Shop online") from the Gift Shop.
6. A **Cart** link appears in the utility bar once WooCommerce is active (`App\cart_link()`).
7. Purge LiteSpeed Cache after activating, and exclude `/cart/`, `/checkout/` and `/my-account/` from the page cache (LiteSpeed does this for WooCommerce by default; confirm it).

## Files

- `app/woocommerce.php`: theme support, style dequeue, `shop_active()`, `cart_link()`, `shop_hero()`.
- `templates/archive-product.html`, `templates/taxonomy-product_cat.html`, `templates/single-product.html`.
- `resources/css/shop.css`: gift shop sections and WooCommerce blocks.
- `patterns/shop-items.php`: the "Shop items grid" pattern.
