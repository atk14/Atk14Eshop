	{capture assign=page_title}{t}Děkujeme{/t}{/capture}
	{capture assign=teaser}{t}…za Váš nákup, vraťte se brzy :){/t}{/capture}
	{render partial="shared/layout/content_header" title=$page_title teaser=$teaser}

	{* TODO: Zakomentovavame fb tlacitko - nemame totiz verejny detail
	<p class="lead">{t}Pochlubte se přátelům s Vaším nákupem.{/t}</p>
	<div>
		<a href="#" class="btn btn--social-fb">{t}Sdílet{/t}</a>
	</div>
	*}
