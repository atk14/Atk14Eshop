<h1>{button_create_new slider_id=$slider}{t}Add new image{/t}{/button_create_new} {$page_title}</h1>

{if $slider_items}
	<ul class="list-group list-sortable" data-sortable-url="{link_to action="slider_items/set_rank"}">
	
		{foreach $slider_items as $slider_item}
			
			<li class="list-group-item" data-id="{$slider_item->getId()}">
				<div class="item__properties">
					<div class="item__title">
					{render partial="shared/list_thumbnail" image=$slider_item->getImageUrl()}
					{$slider_item->getTitle()|default:$mdash}
					</div>
					<span class="item__visibility-properties">
						{if !$slider_item->g("visible")}<span class="item__visibility">{!"eye-slash"|icon} {t}invisible{/t}</span>{/if}
					</span>
					<span class="item__properties">
						{if $slider_item->getDisplayFrom() || $slider_item->getDisplayTo()}
							<small>{t}Displayed{/t}</small>
							{if $slider_item->getDisplayFrom()}<br>{strip_html}{t from=$slider_item->getDisplayFrom()|format_datetime escape=no}<!-- Displayed --> from %1{/t}{/strip_html}{/if}
							{if $slider_item->getDisplayTo()}<br>{strip_html}{t to=$slider_item->getDisplayTo()|format_datetime escape=no}<!-- Displayed --> to %1{/t}{/strip_html}{/if}
						{/if}
					</span>
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
