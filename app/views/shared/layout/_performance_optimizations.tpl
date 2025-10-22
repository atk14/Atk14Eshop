{**
 * Various optimizations to speedup loading resources
 *
 * Recommended by https://web.dev/lighthouse-performance/
*}

{preload_link_tag file="$public/dist/styles/vendor.css" as="style"}
{preload_link_tag file="$public/dist/styles/application_styles.css" as="style"}

{preload_link_tag file="$public/dist/scripts/vendor.min.js" as="script"}
{preload_link_tag file="$public/dist/scripts/application.min.js" as="script"}

<link rel="preconnect" href="https://fonts.gstatic.com/">
<link rel="preload" as="font" type="font/woff2" href="/public/dist/webfonts/fa-regular-400.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="/public/dist/webfonts/fa-solid-900.woff2" crossorigin>
