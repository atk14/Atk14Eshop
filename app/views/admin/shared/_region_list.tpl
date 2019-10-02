{*
 * {render partial="shared/region_list" regions=$delivery_method->getRegions()}
 *}
{foreach $regions as $region}
	{$region->getName()}{if !$region@last}, {/if}
{/foreach}
