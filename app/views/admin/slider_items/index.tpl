<h1>{button_create_new slider_id=$slider}{t}Add new image{/t}{/button_create_new} {$page_title}</h1>

{if $slider_items}
	<ul class="list-group list-sortable" data-sortable-url="{link_to action="slider_items/set_rank"}">
	
		{foreach $slider_items as $slider_item}
			
			<li class="list-group-item" data-id="{$slider_item->getId()}">
				<div class="d-flex justify-content-between align-items-center">
					<div>
					{render partial="shared/list_thumbnail" image=$slider_item->getImageUrl()}
					{$slider_item->getTitle()|default:$mdash}
					{if !$slider_item->isVisible()}<em>({!"eye-slash"|icon} {t}invisible{/t})</em>{/if}
					</div>
					<div>
						{dropdown_menu}
							{a action="slider_items/edit" id=$slider_item}{icon glyph="edit"} {t}Upravit{/t}{/a}
							{a_destroy action="slider_items/destroy" id=$slider_item}{icon glyph="remove"} {t}Smazat{/t}{/a_destroy}
						{/dropdown_menu}
					</div>
				</div>
			</li>
		{/foreach}

	</ul>
{else}

	<p>{t}Zatím tady není žádný obrázek.{/t}</p>

{/if}
