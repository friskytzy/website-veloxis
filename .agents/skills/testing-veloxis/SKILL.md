---
name: testing-veloxis
description: Test the Veloxis Laravel/Vite sparepart ecommerce MVP end-to-end. Use when verifying homepage, catalog filtering, product detail, session cart, Buy Now, guest checkout, and confirmation flows.
---

# Veloxis Testing Skill

## Devin Secrets Needed

None for the MVP guest checkout flow. Veloxis public sparepart routes use session cart state and do not require login.

## Local Setup

From the repo root:

```bash
npm install --no-audit --no-fund
composer install --no-interaction --prefer-dist
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate --ansi --force
php artisan serve --host=127.0.0.1 --port=8000
```

If PHP/Composer are missing on Ubuntu, install the verified packages first:

```bash
sudo apt-get update
sudo apt-get install -y php-cli php-mbstring php-xml php-curl php-sqlite3 php-zip unzip composer
```

For browser recordings, maximize Chrome first. `wmctrl` works on the Ubuntu desktop:

```bash
sudo apt-get install -y wmctrl
wmctrl -r :ACTIVE: -b add,maximized_vert,maximized_horz
```

## Validation Commands

```bash
npm run build
php artisan test
```

## Primary E2E Flow

1. Open `http://127.0.0.1:8000/` and verify the `VELOXIS` homepage and `Cari Sparepart Motor Anda` CTA.
2. Click `Cari Sparepart Motor Anda` to reach `/sparepart`.
3. Filter catalog with search `Castrol` and motor brand `Honda`, then click `Terapkan Filter`.
   - Expected: `1 produk ditemukan`, product `Castrol Power1 Ultimate 10W-40`, price `Rp 78.000`.
4. Open the product detail page.
   - Expected: SKU `VLX-OLI-001`, fitment `Honda Beat, Vario, Scoopy 2018-2025`, quantity field, `Add to Cart`, and `Buy Now`.
5. Set quantity to `3`, click `Buy Now`.
   - Expected checkout summary: `Qty 3`, subtotal `Rp 234.000`, shipping `Rp 18.000`, discount `- Rp 0`, total `Rp 252.000`.
6. Submit guest checkout with any realistic name, phone, address, courier, and payment method.
   - Expected: `/order-confirmation` with `Order diterima` and `order demo berhasil`.
7. Open the cart icon.
   - Expected: `Keranjang masih kosong`, proving the order cleared the session cart.

## Notes

- The checkout is demo-only; do not expect real payment gateway requests.
- Product images are external Unsplash URLs, so placeholders or slow image loads may appear if the network is flaky. Prefer text/state assertions for pass/fail decisions.
- The Buy Now quantity check is important because a broken implementation can redirect to checkout while ignoring the selected quantity.
