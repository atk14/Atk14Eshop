{if $tags}
{foreach $tags as $tag}
	{if !$tag@first} {/if}
	<span class="badge tag-item{if $tag->getCode()} tag--{$tag->getCode()|slugify}{/if}{if $tag->getColor()} tag--bg-{$tag->getColor()}{else} tag--bg-primary{/if}">{!"tag"|icon} {$tag->getTagLocalized()}</span>
{/foreach}
{/if}
