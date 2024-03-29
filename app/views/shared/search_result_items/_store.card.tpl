<div class="card card--search card--search--store">
	<div class="card__image">
		{a action="stores/detail" id=$store}
			{if $store->getImageUrl()}
				{!$store->getImageUrl()|pupiq_img:"400x300x#ffffff":"class='card-img-top'"}
			{else}
				<img src="{$public}dist/images/default_store_400x300.svg" width="400" height="300" title="{t}no image{/t}" alt="" class="card-img-top default-image">
			{/if}
		{/a}


		<div class="card__label">
			{t}Prodejna{/t}
		</div>
	</div>
	
	<div class="card-body">
	
		<h4 class="card-title">
			{a action="stores/detail" id=$store}{highlight_keywords keywords=$params.q tag="<mark>"}{$store->getName()}{/highlight_keywords}{/a}
		</h4>
		
		{if $store->isOpen()}
			<p><span class="is-open"><span class="badge badge-success">{t}Právě otevřeno{/t}</span></span></p>
		{/if}
		
		<div class="card-text">
			<p>
				{highlight_keywords keywords=$params.q tag="<mark>"}
				{$store->getAddressStreet()}, {$store->getAddressCity()}<br>
				{t}tel:{/t} {$store->getPhone()}<br>
				{t}e-mail:{/t} {$store->getEmail()}
				{/highlight_keywords}
			</p>
		</div>
			
	</div>
	
	<div class="card-footer">
		{a action="stores/detail" id=$store _class="btn btn-primary btn-sm"}{t}Informace o prodejně{/t} <i class="icon ion-ios-arrow-forward"></i>{/a}
	</div>
	
</div>
