{if CookieConsent::Accepted("advertising")}

{assign seznam_sklik_id "app.trackers.seznam.sklik.conversion_id"|system_parameter}

{if $seznam_sklik_id && $track_order}
<!-- Měřicí kód Sklik.cz -->
{javascript_tag}
var seznam_cId = {$seznam_sklik_id};
var seznam_value = {$order->getPriceToPay()};
{/javascript_tag}
<script type="text/javascript" src="https://www.seznam.cz/rs/static/rc.js" async></script>
{/if}

{/if}
