{*a action="detail" id=$store _class="card card--store js-store-item" _data-storeid=$store->getID()*}
<div class="card card--store js-store-item" data-storeid="{$store->getID()}">
	{!$store->getImageUrl()|pupiq_img:"!400x300":"class='card-img-top'"}
	{if $store->isOpen()}
		<div class="flags"><span class="badge badge-success">{t}Právě otevřeno{/t}</span></div>
	{/if}
	<div class="card-body">
		<h4 class="card-title">{$store->getName()}</h4>
		<address>{!$store->getAddress()|h|nl2br|replace:'<br />':'<br>'}</address>
		<div class="card-text">{$store->getTeaser()}</div>
	</div>
	<div class="card-footer card-footer--buttons">
		{a action="detail" id=$store}<span class="card-footer__icon">{!"info-circle"|icon}</span> <span>{t escape=no}Informace o&nbsp;prodejně{/t}</span>{/a}
		<a href="#allstores_map" class="js-store-mapbtn" data-storeid="{$store->getID()}"><span class="card-footer__icon">{!"map"|icon}</span> <span>{t escape=no}Ukázat na&nbsp;mapě{/t}</span></a>
	</div>
{*/a*}
</div>