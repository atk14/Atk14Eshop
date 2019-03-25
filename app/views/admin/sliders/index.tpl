<h1>{$page_title}</h1>

{foreach $sliders as $slider}
	{$slider->getName()}
	{dropdown_menu}
		{a action="edit" id=$slider}{icon glyph=edit} {t}Upravit{/t}{/a}
	{/dropdown_menu}
{/foreach}
