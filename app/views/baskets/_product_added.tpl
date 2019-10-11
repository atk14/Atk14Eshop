{assign add_more $basket->getAddMoreToGetFreeDelivery()}
{assign currency $basket->getCurrency()}

<div class="section__surface">
	<p>{t name=$product->getName()|strip_tags}Do košíku jste úspěšně přidali produkt "%1".{/t}</p>
	{if $add_more}
	<p>
		{t add_more=$add_more|display_price:"$currency,summary" escape=no}Nakupte ještě za %1 a dostanete dopravu zdarma.{/t}
	</p>
	{/if}
</div>
<div class="section__navigation">
	<button class="btn btn-secondary btn--back" data-dismiss="modal">{t}Vybrat další produkt{/t}</button>
	<a href="{link_to action="baskets/edit"}" class="btn btn-primary btn--cta">{t}K pokladně{/t}</a>
</div>
