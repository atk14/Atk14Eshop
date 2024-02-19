{*
 * {render partial="shared/region_list" regions=$delivery_method->getRegions()}
 *}
{foreach $regions as $region}
	{$region->getShortName()}{if !$region@last}, {/if}
{/foreach}
