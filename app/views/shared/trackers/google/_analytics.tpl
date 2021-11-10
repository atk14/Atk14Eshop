{assign analytics_tracking_id "app.trackers.google.analytics.tracking_id"|system_parameter}
{assign analytics_tracking_id "/[, ;]/"|preg_split:$analytics_tracking_id|array_filter}

{if $analytics_tracking_id}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$analytics_tracking_id.0}"></script>
<script>
{literal}
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
{/literal}
	{foreach $analytics_tracking_id as $tracking_id}
  gtag('config', '{$tracking_id}');
	{/foreach}
</script>

{/if}
