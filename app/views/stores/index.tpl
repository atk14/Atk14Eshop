<header>
	<h1>{$page_title}</h1>
</header>

{if !$stores}

	<p>{t}Currently we have no store.{/t}</p>

{else}

	<div class="card-deck card-deck--sized-4">
		{render partial="store_item" from=$stores item=store}
	</div>

{/if}
