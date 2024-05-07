<div class="card card--store js-store-item" data-storeid="{$store->getID()}">
	<div class="d-none js-search-data">
		{$store->getName()} {!$store->getAddress()} {to_ascii}{$store->getName()} {!$store->getAddress()}{/to_ascii}
	</div>
	{a action="detail" id=$store _class="card__image" _aria-label=$store->getName()}{!$store->getImageUrl()|pupiq_img:"!400x300":"class='card-img-top'"}
	{if $store->isOpen()}
		<div class="card__flags"><span class="badge badge-success">{t}Právě otevřeno{/t}</span></div>
	{/if}
	{/a}
	<div class="card-body">
		<h2 class="card-title">{$store->getName()}</h2>
		<address>{!$store->getAddress()|h|nl2br|replace:'<br />':'<br>'}</address>
		<div class="card-text">{$store->getTeaser()}</div>
	</div>
	<div class="card-footer card-footer--buttons">
		{a action="detail" id=$store _class="btn btn-sm btn-outline-primary"}<span class="card-footer__icon">{!"info-circle"|icon}</span> <span>{t escape=no}Informace o&nbsp;prodejně{/t}</span>{/a}
		{if $store->getLocationLat() && $store->getLocationLng()}
		<a href="#allstores_map" class="btn btn-sm btn-outline-primary js-store-mapbtn" data-storeid="{$store->getID()}"><span class="card-footer__icon">{!"map"|icon}</span> <span>{t escape=no}Ukázat na&nbsp;mapě{/t}</span></a>
		{/if}
	</div>
</div>
