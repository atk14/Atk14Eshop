{*
 *	{render partial="shared/active_state" object=$voucher}
 *}

{if !$object}
	?
{elseif $object->isActive()}
	<span class="text-success">{!"check-circle"|icon}</span>
{else}
	<span class="text-danger">{!"ban"|icon}</span>
{/if}
