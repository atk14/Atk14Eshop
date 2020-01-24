{*
 * {render partial="shared/order_status" order=$order}
 * {render partial="shared/order_status" order=$order lowerize=true}
 *}

{assign order_status $order->getOrderStatus()}
{assign order_status_str $order->getOrderStatus()}
{if $lowerize}
	{assign order_status_str $order_status_str|lower}
{/if}

{if $order_status->isFinishingSuccessfully()}
	<span class="text-secondary">{!"check"|icon}</span> {$order_status_str}
{elseif $order_status->finishedSuccessfully()}
	<span class="text-success">{!"check"|icon} <strong>{$order_status_str}</strong></span>
{elseif $order_status->isFinishingUnsuccessfully()}
	<span class="text-secondary">{!"times"|icon}</span> {$order_status_str}
{elseif $order_status->finishedUnsuccessfully()}
	<span class="text-danger">{!"times"|icon} <strong>{$order_status_str}</strong></span>
{else}
	{$order_status_str}
{/if}
