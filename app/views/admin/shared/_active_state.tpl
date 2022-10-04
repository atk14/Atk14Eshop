{*
 *	{render partial="shared/active_state" object=$voucher}
 *}

{if !$object}
	<span class="text-warning" title="{t}unknown active state{/t}">{!"question"|icon}</span>
{elseif $object->isActive()}
	<span class="text-success" title="{t}active{/t}">{!"check-circle"|icon}</span>
{else}
	<span class="text-danger" title="{t}not active{/t}">{!"ban"|icon}</span>
{/if}
