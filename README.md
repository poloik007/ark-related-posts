# Ark Related Posts

A WordPress plugin that automatically displays related posts at the bottom of single post pages, based on shared tags. Falls back to latest posts when no tag matches are found.

## Features

- **Tag-based matching** — finds posts that share tags with the current post
- **Automatic fallback** — shows latest posts when no tag matches exist
- **Transient caching** — 24-hour cache per post to reduce database queries
- **Responsive layout** — flexbox grid that collapses to a single column on mobile (≤782px)
- **Featured images** — displays post thumbnails alongside titles
- **Zero configuration** — works automatically on all single post pages after activation

## Requirements

- WordPress 3.0+
- PHP 5.3+

## Installation

### Option 1 — Upload via WordPress Admin

1. Download this repository as a `.zip` file (GitHub → **Code** → **Download ZIP**)
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**
3. Choose the downloaded `.zip` file and click **Install Now**
4. Click **Activate Plugin**

### Option 2 — Manual FTP/SFTP Upload

1. Download or clone this repository
2. Upload the `ark-related-posts` folder to your server's `wp-content/plugins/` directory
3. In your WordPress admin, go to **Plugins** and activate **Arkon related posts**

### Option 3 — WP-CLI

```bash
wp plugin install https://github.com/poloik007/ark-related-posts/archive/refs/heads/main.zip --activate
```

## Usage

No configuration is needed. Once activated, the plugin automatically appends a "Related Posts" section to every single post page.

Posts must have **tags** assigned for tag-based matching to work. If a post has no tags, or no other posts share its tags, the section will display the three most recent posts instead.

## File Structure

```
ark-related-posts/
├── ark-related-posts.php                  # Plugin entry point — registers hooks
├── class.ark-related-posts-query.php      # Query logic and caching
├── view/
│   └── ark-related-posts-template.php    # HTML template
├── _inc/
│   ├── src/
│   │   └── style.scss                    # Source styles
│   └── dist/
│       └── style.css                     # Compiled CSS (loaded on the front-end)
├── webpack.config.js                      # Build configuration
└── package.json                           # NPM dependencies
```

## Development

The CSS is compiled from SCSS using Webpack and Sass.

```bash
# Install dependencies
npm install

# One-time production build
npm run build

# Watch for changes during development
npm run watch
```

Output is written to `_inc/dist/style.css`.

## How It Works

1. The plugin hooks into `the_content` filter and runs only on single post pages.
2. `Ark_Related_Posts` queries for posts sharing at least one tag with the current post (up to 3 results), caching the result for 24 hours using WordPress transients.
3. If no tagged matches exist, it falls back to the 3 most recent posts (also cached for 24 hours).
4. The `view/ark-related-posts-template.php` template renders the results and the HTML is appended to the post content.

## Author

Gabriel Del Fiaco

## License

This project is open source. See the repository for license details.
