{**
 * Custom code for body is preferred over the basic one based only on a container_id.
 *}
{assign container_id "app.trackers.google.tag_manager.container_id"|system_parameter}
{assign custom_code "app.trackers.google.tag_manager.custom_code.body"|system_parameter}
{if $custom_code}
{!$custom_code}
{elseif $container_id}
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$container_id}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
{/if}
