<div class="row">
	<div class="col-sm-1">
		{render partial="shared/list_thumbnail" image=$product->getImage() image_class="img-responsive"}
	</div>
	<div class="col-sm-11">
		<dl class="dl-horizontal">
			<dt>{t}Název produktu{/t}:</dt><dd>{$product->getName()}</dd>
			<dt>{t}Kód produktu{/t}:</dt><dd>{$product->getCatalogId()}</dd>
			<dt>{t}Jednotka{/t}:</dt><dd>{$product->getUnit()}</dd>
			<dt>{t}Sazba DPH{/t}:</dt><dd>{$product->getVatPercent()}%</dd>
		</dl>
	</div>
</div>
