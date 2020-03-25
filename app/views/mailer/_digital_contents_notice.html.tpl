{if $order->canBeFulfilled() && $order->hasDigitalContents()}
	{capture assign=digital_contents_url}{link_to namespace="" action="digital_contents/index" order_token=$order->getToken(DigitalContent::GetOrderTokenOptions()) _with_hostname=$region->getDefaultDomain() _ssl=$PRODUCTION}{/capture}
	<br/><br/>
	{t}Zakoupené digitální produkty stáhnete na adrese:{/t}<br/>
	<a href="{$digital_contents_url}" style="{$link_style}">{$digital_contents_url}</a>
{/if}
