{assign add_more $basket->getAddMoreToGetFreeDelivery()}
{assign currency $basket->getCurrency()}
{assign unit $product->getUnit()}

<div class="section__surface">
	<p>{t name=$product->getName()|strip_html}Do košíku jste úspěšně přidali produkt "%1".{/t}</p>

	{if $original_amount && $current_amount>$original_amount}
		<p>{t}Váš nákupní košík již tento produkt obsahuje. Množství bylo upraveno.{/t}</p>
		<p class="modal__quantity-change">
			<span class="quantity"><span class="badge badge-secondary rounded-pill">{$original_amount}&nbsp;{$unit}</span> <i class="fas fa-arrow-right"></i> <span class="badge badge-primary rounded-pill">{$current_amount}&nbsp;{$unit}</span></span>
			{a_remote action="set_product_amount" product_id=$product amount=$amount _class="quantity-edit-link" _method=post}{t amount=$amount unit=$unit}Upravit množství na %1 %2?{/t}{/a_remote}
		</p>
	{/if}

	{if $add_more}
	<p>
		{t add_more=$add_more|display_price:"$currency,summary" escape=no}Nakupte ještě za %1 a dostanete dopravu zdarma.{/t}
	</p>
	{/if}
</div>
<div class="section__navigation">
	<button class="btn btn-secondary btn--back" data-bs-dismiss="modal">{t}Vybrat další produkt{/t}</button>
	<a href="{link_to action="baskets/edit"}" class="btn btn-primary btn--cta">{t}K pokladně{/t}</a>
</div>
