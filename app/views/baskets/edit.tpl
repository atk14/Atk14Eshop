{render partial="shared/checkout_navigation"}

<h1>{t}Košík{/t}</h1>

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
				<th class="sr-only">{t}Produkt{/t}</th>
				<th>{t}Popis{/t}</th>
				<th class="text-center">{t}Kód{/t}</th>
				<th class="text-right text--nowrap">{t}Cena [cm/ks]{/t}</th>
				<th class="text-center text--nowrap">{t}Mn. [cm/ks]{/t}</th>
				<th class="text-right">{t}Celkem{/t}</th>
				<th><span class="sr-only">Actions</span></th>
			</tr>
		</thead>

		{render partial="tbody"}

		{render partial="tfoot"}
	</table>
</div>
<div class="form__footer">
	{a action="categories/index" _class="btn btn-lg btn-primary btn--back btn--arrow-l"}{t}Zpět ke zboží{/t}{/a}
	<button type="submit" class="btn btn-default btn-lg nojs-only">{t}Přepočítat obsah košíku{/t}</button>
	<button type="submit" name="continue" class="btn btn--cta btn-lg">{t}Pokračovat na výběr dodání a platby{/t}</button>
</div>

{/form}
