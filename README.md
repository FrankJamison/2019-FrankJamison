# 2019-FrankJamison Portfolio Site

A personal portfolio / resume site with a set of included portfolio subprojects.

## What’s in here

- **Main site pages**
  - `index.html`: primary resume/portfolio landing page
  - `404.html`: static 404 page (template-based)
- **Contact mail endpoint (PHP)**
  - `include/sendmail.php`: simple JSON mail sender used by the site’s contact UI (requires PHP + a working mail transport on the server)
- **Assets**
  - `style/`: site stylesheets
  - `js/`: site JavaScript (jQuery + plugins)
  - `images/`: site images
- **Portfolio subprojects**
  - `portfolio/`: a collection of standalone mini-projects (HTML/CSS/JS and some PHP projects), each with its own entry page(s)

## Requirements

### Viewing the main site

- **To view pages**: any modern browser.
- **To use the contact form/email feature**: a web server that can execute **PHP**.

### Sending email (PHP)

`include/sendmail.php` uses PHP’s built-in `mail()` function. For this to work, your hosting/server must be configured to send mail (this is environment-specific).

If mail is not configured, the endpoint will return an error JSON response.

## Running the site

### Option 1: Browser-only preview (no PHP)

You can open `index.html` directly in a browser for a quick preview.

- The **visual site** will load.
- Any **server-side features** (like sending mail) will not work without PHP.

### Option 2: Serve it from a PHP-capable web server

Serve the repository folder from any web server that supports PHP, and then open the site URL your server provides.

Notes:
- The contact endpoint is `include/sendmail.php`.
- Email delivery depends on the server’s mail configuration.

## Configuring contact email

The destination email address is hard-coded in `include/sendmail.php`:

- Update `$contact_email` to the address that should receive messages.

## Security notes (recommended)

The current `include/sendmail.php` implementation is intentionally small, but it is also very permissive.

If you plan to deploy this publicly, consider tightening it by:
- Validating and sanitizing input (`user_name`, `user_email`, `user_msg`).
- Adding basic rate-limiting / CAPTCHA to reduce spam.
- Avoiding using user-provided data directly in mail headers.

## Project layout

Top-level:

- `index.html` — main page
- `404.html` — 404 page
- `include/` — PHP includes (mail endpoint)
- `images/` — images
- `js/` — scripts
- `style/` — styles
- `portfolio/` — subprojects

## Portfolio subprojects

Each folder under `portfolio/` is intended to be browsed as a standalone project. Most contain an `index.html` (or `index.php`) entry file.

Examples:
- `portfolio/Personal-DnD5e-Stat-Roller/`
- `portfolio/UC-Davis-WEB5xx-*` (course projects)

## Troubleshooting

- **Contact form says “Error send message!”**
  - PHP `mail()` is failing (server mail transport not configured or blocked).
- **Images don’t load**
  - Make sure you are serving the site with the repository folder as the web root, and that file paths haven’t been changed.
