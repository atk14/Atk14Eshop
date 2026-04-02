{if CookieConsent::Accepted("advertising")}

{assign seznam_retargeting_id "app.trackers.seznam.retargeting.retargeting_id"|system_parameter}

{if $seznam_retargeting_id}
{javascript_tag}
var seznam_retargeting_id = {$seznam_retargeting_id};
{/javascript_tag}
<script type="text/javascript" src="//c.imedia.cz/js/retargeting.js"></script>
{/if}

{/if}
