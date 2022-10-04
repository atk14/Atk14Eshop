{assign analytics_tracking_id "app.trackers.google.analytics.tracking_id"|system_parameter}
{assign analytics_tracking_id "/[, ;]/"|preg_split:"$analytics_tracking_id"|array_filter}
{assign settings CookieConsent::GetSettings()}

{if $analytics_tracking_id}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$analytics_tracking_id.0}"></script>
<script>
{literal}
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
{/literal}
	{* Vychozi nastaveni souhlasu - vsechno zakazane *}
{literal}
	gtag('consent', 'default', {
		'ad_storage': 'denied',
		'analytics_storage': 'denied',
		'functionality_storage': 'denied',
		'personalization_storage': 'denied'
	});
	gtag('set', 'ads_data_redaction', true);
{/literal}
	gtag('js', new Date());
	{foreach $analytics_tracking_id as $tracking_id}
	gtag('config', '{$tracking_id}');
	{/foreach}
	gtag('consent', 'update', {!$settings->getGtmGrantedConsents()|json_encode} );
	{if $settings->needsToBeConfirmed()}
		document.addEventListener( "consentupdate", function( ev ) \{
			gtag( 'consent', 'update', ev.grantedConsents );
		} );
	{/if}

</script>

{/if}
