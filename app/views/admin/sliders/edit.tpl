<h1>{$page_title}</h1>

{assign items $slider->getItems()}

{if $items}
	<ul class="list-group list-sortable" data-sortable-url="{link_to action="slider_items/set_rank"}">
	
		{foreach $items as $image}
			
			<li class="list-group-item" data-id="{$image->getId()}">
				<div class="pull-right">
					{dropdown_menu}
						{a action="slider_items/edit" id=$image}{icon glyph="edit"} {t}Upravit{/t}{/a}
						{a_destroy action="slider_items/destroy" id=$image}{icon glyph="remove"} {t}Smazat{/t}{/a_destroy}
					{/dropdown_menu}
				</div>

				{!"$image"|pupiq_img:"100x"}
				{!$image->getTitle()|h|default:"&mdash;"}
			</li>
		{/foreach}

	</ul>
{else}

	<p>{t}Zatím tady není žádný obrázek.{/t}</p>

{/if}

<p>
	{a action="slider_items/create_new" slider_id=$slider _class="btn btn-default"}{icon glyph="plus"} {t}Přidat obrázek{/t}{/a}
</p>
