{render partial="shared/checkout_navigation"}
{capture assign=page_title}{t}Košík{/t}{/capture}
{render partial="shared/layout/content_header" title=$page_title}

{assign currency $basket->getCurrency()}
{assign basket_vouchers $basket->getBasketVouchers()}
{assign basket_campaigns $basket->getBasketCampaigns()}
{assign vouchers_anchor_set 0}

{form} {* Tento formular nesmi mit nastaveno novalidate *}

{render partial="error_messages"}

{render partial="add_more_to_get_free_delivery_message"}

<div class="form__body">
	<table class="table-products table-products--main">
		<thead>
			<tr>
				<th class="table-products__image"><span class="sr-only">{t}Obrázek{/t}</span></th>
				<th class="table-products__title">{t}Produkt{/t}<span class="d-block d-lg-none">{t}Kód{/t}</span></th>
				<th class="table-products__id"><span class="d-none d-lg-inline">{t}Kód{/t}</span></th>
				<th class="table-products__unit-price">{t}Jedn. cena{/t}</th>
				<th class="table-products__amount">{t}Množství{/t}</th>
				<th class="table-products__price">{t}Celkem{/t}</th>
				<th class="table-products__actions"><span class="sr-only">Actions</span></th>
			</tr>
		</thead>

		{render partial="tbody"}

		{render partial="tfoot"}
	</table>
</div>
<div class="form__footer">
	{a action="categories/index" _class="btn btn-lg btn-secondary btn--back btn--arrow-l"}{t}Back to catalog{/t}{/a}
	<button type="submit" class="btn btn-secondary btn-lg nojs-only">{t}Recalculate basket content{/t}</button>
	<button type="submit" name="continue" class="btn btn-primary btn-lg">{t}Select shipping and payment{/t}</button>
</div>

{/form}
