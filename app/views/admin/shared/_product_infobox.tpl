<div class="row">
	<div class="col-sm-1">
		{render partial="shared/list_thumbnail" image=$product->getImage() image_class="img-responsive"}
	</div>
	<div class="col-sm-11">
		{t}Název produktu{/t}: {$product->getName()}<br>
		{t}Kód produktu{/t}: {$product->getCatalogId()}<br>
		{t}Jednotka{/t}: {$product->getUnit()}<br>
		{t}Sazba DPH{/t}: {$product->getVatPercent()}%
	</div>
</div>
