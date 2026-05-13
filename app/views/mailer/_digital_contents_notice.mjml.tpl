{if $order->canBeFulfilled() && $order->hasDigitalContents()}
<mj-text>
{capture assign=digital_contents_url}{link_to namespace="" action="digital_contents/index" order_token=$order->getToken(DigitalContent::GetOrderTokenOptions()) _with_hostname=$region->getDefaultDomain() _ssl=$PRODUCTION}{/capture}<br/><br/>
	
	{t}Zakoupené digitální produkty stáhnete na adrese:{/t}<br/>
	<br/>
</mj-text>
<mj-button href="{$digital_contents_url}">{t}Stáhnout digitální obsah{/t}</mj-button>

<mj-text>
	<p style="text-align: center;"><small><a href="{$digital_contents_url}" class="muted">{$digital_contents_url}</a></small></p>
</mj-text>
{/if}
