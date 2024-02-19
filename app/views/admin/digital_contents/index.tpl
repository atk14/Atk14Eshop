<h1>{button_create_new product_id=$product}{/button_create_new} {$page_title}</h1>

<p>{t}Digitální obsah (soubory) si zákazník stáhne po dokončení objednávky.{/t}</p>

{if !$digital_contents}

	<p><em>{t}Pro tento produkt neexistuje žádný digitální obsah.{/t}</em></p>

{else}

<ul class="list-group list-sortable" data-sortable-url="{link_to action="set_rank"}">
	{foreach $digital_contents as $digital_content}
		<li class="list-group-item" data-id="{$digital_content->getId()}">
		{render partial="shared/list_thumbnail" image=$digital_content->getImageUrl()}
		#{$digital_content->getId()}

		{render partial="shared/active_state" object=$digital_content}

		<em>{render partial="shared/region_list" regions=$digital_content->getRegions()}</em> / {$digital_content->getTitle()}
		({if $digital_content->getTitle()!=$digital_content->getFilename()}{$digital_content->getFilename()}, {/if}{$digital_content->getFilesize()|format_bytes})

		{dropdown_menu}
			{a action=edit id=$digital_content}<i class="glyphicon glyphicon-edit"></i> {t}Edit{/t}{/a}
			{a action="digital_contents/detail" id=$digital_content format=raw}{!"download"|icon} {t}Stáhnout soubor{/t}{/a}
			{if $digital_content->isDeletable()}
				{a_destroy id=$digital_content}{!"remove"|icon} {t}Smazat{/t}{/a_destroy}
			{/if}
		{/dropdown_menu}

		</li>
	{/foreach}
</ul>
	

{/if}
