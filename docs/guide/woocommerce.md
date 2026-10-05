# Gift shop and WooCommerce

The Gift Shop is a regular page built from core blocks, so staff can edit items in the block editor with no plugin. When the shop sells online, WooCommerce takes over the grid (see below).

## Today: the Gift Shop page

- Each item is a **group with the class `shop-card`**: image, tag (`shop-tag`), name (H3, `shop-card-t`), price (`shop-price`), note (`shop-card-x`) and a call-to-hold link (`shop-card-a`). To add an item, select a card and choose **Duplicate**.
- The cards sit in a group with the class `shop-grid` (4 columns on desktop, 2 on tablet, 1 on small phones).
- Insert **Patterns → Cobble & Candle → Shop items grid** to start a new grid on any page.
- Other sections on the page use `shop-split`, `shop-facts`, `shop-frames`, `shop-aside`, `shop-steps` and `shop-faq`. They are styled in `resources/css/shop.css`.

## Selling online with WooCommerce

The theme runs a pickup-only gift shop on WooCommerce: guests add items on the Gift Shop page, check out with **Pay at pickup**, and collect at the counter. No card gateway or shipping zones are needed to start.

### Set it up

1. Install and activate WooCommerce. Skip its theme and store-design suggestions.
2. Enter the store address in **WooCommerce → Settings → General**. The pickup location uses it.
3. Add the demo store (optional, safe to run again):
   ```
   studio wp cobbleandcandle-shop seed --path ~/Studio/cobbleandcandle
   ```
   It adds eight products in **Bakery** and **Country Curiosity Store**, turns on **Local pickup** ("Gift shop counter") and **Pay at pickup** (WooCommerce's Cash on delivery gateway, renamed), turns off product reviews, writes the Shop page's hero line, and creates a **Gift Shop** page when the site has none. Products are matched by SKU (`DH-…`); pickup and payment settings an owner already turned on are left alone.
4. Add your photos to each product (**Products → Edit → Product image**). Until then, cards show the theme's basket drawing.
5. On an existing Gift Shop page, replace the `shop-grid` group with **Patterns → Cobble & Candle → Shop products (online store)**. It shows live products with **Add to cart** in the same card style. Without WooCommerce the pattern inserts nothing.
6. Purge LiteSpeed Cache, and confirm `/cart/`, `/checkout/` and `/my-account/` are excluded from the page cache (LiteSpeed does this for WooCommerce by default).

### What guests see

- **Gift Shop page** and **Shop** (`/shop/`, `templates/archive-product.html`): product cards with category, name, price, short description and **Add to cart**. Category pages use `taxonomy-product_cat.html`.
- **Utility bar**: a **Cart** link with an item count. The count updates without a reload after an add or remove, and on cached pages (`resources/js/app.js` reads the Store API when WooCommerce's cart cookie is set).
- **Cart** and **Checkout** (`templates/page-cart.html`, `page-checkout.html`): the page hero, then WooCommerce's cart and checkout blocks in the theme's fields, buttons and colors. The theme's mobile action bar is hidden on these two pages, since WooCommerce's sticky checkout button takes its place.
- **Order received** (`templates/order-confirmation.html`): order number, total, the pickup address and the "Pay at pickup" instructions.

### Taking card payments later

Install a gateway (WooPayments, Stripe or Square), enable it in **WooCommerce → Settings → Payments**, and leave or turn off **Pay at pickup**. The checkout styles apply to any gateway that uses the checkout block.

### Shipping later

Bakery items are pickup only. To ship non-perishables, add a shipping zone with a flat rate and give bakery products a shipping class with no rate in that zone. Checkout then shows a Ship / Pick up choice.

### When WooCommerce is off

The Cart link, product grids and store templates disappear; the rest of the site is unchanged. A page that holds the "Shop products" pattern shows its heading and note with no grid, so switch it back to "Shop items grid" if WooCommerce is turned off for good.

## Files

- `app/woocommerce.php`: theme support, style dequeue, `shop_active()`, `cart_link()`, `shop_hero()`, placeholder image, checkout stylesheet.
- `app/shop-demo.php`: the `wp cobbleandcandle-shop seed` command.
- `templates/archive-product.html`, `taxonomy-product_cat.html`, `single-product.html`, `page-cart.html`, `page-checkout.html`, `order-confirmation.html`.
- `resources/css/shop.css`: gift shop sections and product cards (every page).
- `resources/css/checkout.css`: cart, checkout and order received (only on those pages).
- `resources/images/shop-placeholder.svg`: the card drawing for products without a photo.
- `patterns/shop-items.php` ("Shop items grid", no plugin) and `patterns/shop-products.php` ("Shop products (online store)", WooCommerce).
