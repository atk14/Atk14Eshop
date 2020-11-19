<li class="search-results-item">
	<div class="search-results-item--image">
		{if $store->getImageUrl()}
			{a action="stores/detail" id=$store}
				{!$store->getImageUrl()|pupiq_img:"600x450":"class='img-fluid'"}
			{/a}
		{else}
		{/if}
		
	</div>
	<div class="search-results-item--body">
		<div>
			<h4 class="search-result-title">
				{a action="stores/detail" id=$store}{$store->getName()}{/a}<br>
			</h4>
			{if $store->isOpen()}
				<span class="is-open"><span class="badge badge-success">{t}Právě otevřeno{/t}</span></span>
			{/if}
			<p class="search-result-description">
				{$store->getAddressStreet()}, {$store->getAddressCity()}<br>
				{t}tel:{/t} {$store->getPhone()}<br>
				{t}e-mail:{/t} {$store->getEmail()}
			</p>
		</div>
		<div class="search-results-item--actions">
			{a action="stores/detail" id=$store _class="btn btn-primary btn-sm"}{t}Informace o prodejně{/t} <i class="icon ion-ios-arrow-forward"></i>{/a}
	{*<a class="btn btn-primary btn-sm" href="{link_to_map service="seznam" lat=$store->getLocationLat() lng=$store->getLocationLng()}">{t}Ukázat na mapě{/t} <i class="icon ion-android-pin"></i></a>*}
		</div>
	</div>
	<div class="search-results-item--tag">
		{t}Prodejna{/t}
	</div>
</li>
