{dropdown_menu clearfix=false}
	{a action="special_opening_hours/index" store_id=$store}{!"list"|icon} {t}Special opening hours{/t}{/a}
	{if $store->isVisible()}
		{a namespace="" action="stores/detail" id=$store}{!"eye-open"|icon} {t}Visit public link{/t}{/a}
	{/if}
{/dropdown_menu}

<h1>{$page_title}</h1>

{render partial="shared/form"}

<hr>

{render partial="shared/image_gallery" object=$store}
