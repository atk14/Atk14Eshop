{*
 *	{render partial="shared/object_status" object=$claim}	
 *	{render partial="shared/object_status" object_status=$claim->getClaimStatus()}
 *}

{if $object}
	{assign object_status $object->getStatus()}
{/if}

{assign object_status_str $object_status->toString()}
{if $lowerize}
	{assign object_status_str $object_status_str|lower}
{/if}

{if $object_status->finishedSuccessfully()}
	<span class="text-success">{!"check"|icon} <strong>{$object_status_str}</strong></span>
{elseif $object_status->finishedUnsuccessfully()}
	<span class="text-danger">{!"times"|icon} <strong>{$object_status_str}</strong></span>
{else}
	{$object_status_str}
{/if}
