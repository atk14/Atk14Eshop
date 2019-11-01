{assign analytics_tracking_id "app.trackers.google.analytics.tracking_id"|system_parameter}
{if $analytics_tracking_id}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$analytics_tracking_id}"></script>
<script>
{literal}
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
{/literal}
  gtag('config', '{$analytics_tracking_id}');
</script>

{/if}
