{assign add_more $basket->getAddMoreToGetFreeDelivery()}
{assign currency $basket->getCurrency()}

<div id="add_more_to_get_free_delivery_message">

{if $add_more}
	<div class="alert alert-info">
		{t add_more=$add_more|display_price:"$currency,summary" escape=no}Nakupte ještě za %1 a dostanete dopravu zdarma.{/t}
	</div>
{/if}

</div>
