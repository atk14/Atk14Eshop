{render partial="shared/layout/content_header" title=$page_title}
<section>
	{render partial="shared/form"}
	
	<p class="float-left pr-4">{a action="users/create_new"}{t}New Registration{/t}{/a}</p>
	<p class="float-left">{a action="password_recoveries/create_new" _rel="nofollow"}{t}Forgotten password{/t}{/a}</p>
</section>
