{**
 * Various optimizations to speedup loading resources
 *
 * Recommended by https://web.dev/lighthouse-performance/
*}

{preload_link_tag file="$public/dist/styles/vendor.min.css" as="style"}
{preload_link_tag file="$public/dist/styles/application.min.css" as="style"}

{preload_link_tag file="$public/dist/scripts/vendor.min.js" as="script"}
{preload_link_tag file="$public/dist/scripts/application.min.js" as="script"}

{if PUPIQ_API_KEY}
	{assign ppq_proxy "PUPIQ_PROXY_HOSTNAME"|dump_constant}
	{assign ppq_img_hostname "PUPIQ_IMG_HOSTNAME"|dump_constant}
	{if $ppq_proxy}
		{assign ppq_hostname $ppq_proxy}
	{elseif $ppq_img_hostname}
		{assign ppq_hostname $ppq_img_hostname}
	{/if}
	{if $ppq_hostname && $ppq_hostname!==$request->getHttpHost()}
		<link rel="preconnect" href="//{$ppq_hostname}">
	{/if}
{/if}
{assign analytics_tracking_id "app.trackers.google.analytics.tracking_id"|system_parameter}
{assign container_id "app.trackers.google.tag_manager.container_id"|system_parameter}
{if $analytics_tracking_id}
<link rel="preconnect" href="https://www.google-analytics.com">
{/if}
{**
 * googletagmanager.com je pouzita pri pouziti google analytics ve forme gtag,
 * coz je vychozi aktualne pouzivana metoda vkladani google analytics kodu.
 *}
{if $container_id || $analytics_tracking_id}
<link rel="preconnect" href="https://www.googletagmanager.com">
{/if}
<link rel="preconnect" href="https://fonts.gstatic.com/">
<link rel="preload" as="font" type="font/woff2" href="/public/dist/webfonts/fa-regular-400.woff2" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="/public/dist/webfonts/fa-solid-900.woff2" crossorigin>
