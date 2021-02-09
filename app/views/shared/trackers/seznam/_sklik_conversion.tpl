{assign seznam_sklik_id "app.trackers.seznam.sklik.conversion_id"|system_parameter}

{if $seznam_sklik_id && $track_order}
<!-- Měřicí kód Sklik.cz -->
<script type="text/javascript">
var seznam_cId = {$seznam_sklik_id};
var seznam_value = {$order->getPriceToPay()};
</script>
<script type="text/javascript" src="https://www.seznam.cz/rs/static/rc.js" async></script>
{/if}
