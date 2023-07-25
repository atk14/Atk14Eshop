<p>
	{t card=$card->getName()|h}You are about to add the product "%1" to the basket.{/t}
</p>

{form_remote}

	{!$form|field:"product_id"}

	{render partial="shared/form_button" button_text="{t}Add to basket{/t}"}

{/form_remote}
