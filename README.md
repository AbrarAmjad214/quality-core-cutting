# Quality Core Cutting UAE — website

Laravel 12 marketing site for **qualitycorecuttinguae.com** — concrete cutting, core cutting,
wall / wire / floor saw cutting and GPR scanning in Dubai, Abu Dhabi and Sharjah.

No database, no build step: plain Blade views, one CSS file and one JS file in `public/assets/`.

## Where things are

| What | Where |
| --- | --- |
| Business details (phone, email, address, Google tags) | `config/site.php` |
| Service pages content (10 services) | `resources/data/services.php` |
| City pages (Dubai, Abu Dhabi, Sharjah) | `resources/data/locations.php` |
| Shared content (stats, FAQs, projects…) | `resources/data/company.php` |
| Page templates | `resources/views/pages`, `services/show`, `locations/show` |
| Header (`<head>`) / footer (scripts) | `resources/views/partials/header.blade.php`, `footer.blade.php` |
| SEO schema (JSON-LD) | `resources/views/partials/schema/` |
| CSS / JS / images / fonts | `public/assets/` |
| Old WordPress URL redirects | `routes/web.php` |

URLs use a trailing slash (`/about-us/`); see `app/Http/Middleware/AddTrailingSlash.php`.

## Deploy on Hostinger (Git)

`vendor/` is committed (production dependencies only), so the site runs straight after a pull.

1. **hPanel → Websites → Manage → Advanced → PHP Configuration**: PHP **8.2 or newer**.
2. **hPanel → Advanced → Git**: repository `https://github.com/AbrarAmjad214/quality-core-cutting.git`,
   branch `main`, install path empty (= `public_html`). The folder must be empty for the first deploy.
   Click **Deploy**. Optional: enable **Auto Deployment** and add the webhook URL in GitHub.
3. **Create `.env`** in `public_html` (File Manager): copy `.env.example` to `.env`, then set `APP_KEY`
   and the mail password. With SSH you can simply run `bash deploy.sh` instead.
4. Open `https://qualitycorecuttinguae.com/` and submit `sitemap.xml` in Google Search Console.

The root `.htaccess` serves the app from `public/` (no `/public` in URLs), forces
`https://qualitycorecuttinguae.com`, and blocks `.env`, `vendor/`, `storage/` etc. with 403.

After each new deploy with SSH: `bash deploy.sh` (refreshes caches).

## Local development

```bash
composer install          # installs dev tools too
cp .env.example .env      # then set APP_ENV=local, APP_DEBUG=true, APP_URL=http://127.0.0.1:8000
php artisan key:generate
php artisan serve
```
