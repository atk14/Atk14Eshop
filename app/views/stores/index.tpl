{render partial="shared/layout/content_header" title=$page_title}

{if !$stores}

	<p>{t}Currently we have no store.{/t}</p>

{else}


{capture assign="jsdata"}
var storeLocatorData = [
	{foreach from=$stores item=$store}
	{if $store->getLocationLat() && $store->getLocationLng()}
	{
		id: {$store->getID()},
		image: "{!$store->getImageUrl()|img_url:"140x140xcrop"}",
		title: "{$store->getName()}",
		address: "{$store->getAddress()|h|nl2br|replace:'<br />':'<br>'|escape:"url"|strip}",
		detailURL: "{$store|link_to_store}",
		lat: {$store->getLocationLat()},
		lng: {$store->getLocationLng()},
		isOpen: {if $store->isOpen()}"{t}Otevřeno{/t}"{else}false{/if},
	},
	{/if}
	{/foreach}
];
{/capture}
			{*<pre>{!$jsdata}</pre>*}
			{javascript_tag}
				{!$jsdata}
			{/javascript_tag}

	
	{*
		Map container: 
		data-enable_clusters: set true to enable marker clusters
		data-cluster_distance: set max distance for markers to make cluster
	*}
	<div class="stores-index__map" id="allstores_map" data-enable_clusters="true" data-cluster_distance="30"></div>

	<div class="card-deck card-deck--sized-4 js-stores-cards">
		{render partial="store_item" from=$stores item=store}
	</div>

{/if}

{render partial="shared/mapy_cz_api_loader"}