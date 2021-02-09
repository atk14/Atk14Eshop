{assign seznam_retargeting_id "app.trackers.seznam.retargeting.retargeting_id"|system_parameter}

{if $seznam_retargeting_id}
<script type="text/javascript">
/* <![CDATA[ */
var seznam_retargeting_id = {$seznam_retargeting_id};
/* ]]> */
</script>
<script type="text/javascript" src="//c.imedia.cz/js/retargeting.js"></script>
{/if}
