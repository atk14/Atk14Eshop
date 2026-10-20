{**
 * Custom code for body is preferred over the basic one based only on a container_id.
 * The container_id is passed from the controller via tpl_data (gtm_container_id),
 * which allows per-domain configuration. Custom code override is still read
 * from SystemParameter.
 *}
{assign custom_code "app.trackers.google.tag_manager.custom_code.body"|system_parameter}
{if $custom_code}
{!$custom_code}
{elseif $gtm_container_id}
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$gtm_container_id}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
{/if}
