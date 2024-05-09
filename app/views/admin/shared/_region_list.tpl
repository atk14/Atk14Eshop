{*
 * {render partial="shared/region_list" regions=$delivery_method->getRegions()}
 *}
{trim}
{foreach $regions as $region}
	{$region->getShortName()}{if !$region@last}, {/if}
{/foreach}
{/trim}
