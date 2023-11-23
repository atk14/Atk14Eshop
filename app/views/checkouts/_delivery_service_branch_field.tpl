{* Rendered by SelectWithImages widget *}
{if $delivery_method->getDeliveryService()}
<div class="delivery_service_branch">
	<span class="branch_button"><a href="{link_to action="delivery_service_branches/set_branch" delivery_method_id=$delivery_method}" class="btn btn-outline-secondary btn-xs remote_link" data-remote="true">{t}zvolit výdejní místo{/t}</a></span>
	<span class="branch_address">{if $branch}{$branch->getAddressStr()}{/if}</span>
	<div class="clearfix"></div>
</div>
{/if}
