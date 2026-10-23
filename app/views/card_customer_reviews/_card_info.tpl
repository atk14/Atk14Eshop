<div class="d-sm-flex mb-3">
	<div class="mr-3 mb-4">
		<a href="{$card|link_to_card}">{render partial="shared/card_image" card=$card}</a>
	</div>
	<div>
	<h3><a href="{$card|link_to_card}">{$card->getName()}</a></h3>
	{if $card->getTeaser()}
		{$card->getTeaser()|markdown|strip_html|truncate:400}
	{/if}
	</div>
</div>

