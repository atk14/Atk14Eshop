{* Rendered by SelectWithImages widget *}
{if $delivery_method->getDeliveryService()}
<div class="delivery_service_branch">
	<span class="branch_address">{if $branch}{$branch->getZip()} {$branch->getFullAddress()} ({$branch->getPlace()}){/if}</span>
	<span class="branch_button"> <a href="{link_to action="delivery_service_branches/set_branch" delivery_method_id=$delivery_method}" class="label label-primary remote_link" data-remote="true">{t}zvolit výdejní místo{/t}</a></span>
</div>
{/if}
