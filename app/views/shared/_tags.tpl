{if is_array($tags)}
	{render partial="shared/tag_item" from=$tags}
{elseif $tags}
	{* $tags must be a previously rendered HTML snippet *}
	{!$tags}
{/if}
