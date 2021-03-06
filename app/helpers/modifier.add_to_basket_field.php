<?php
/**
 * Vyrenderuje ad hoc formularove policko pro pridani daneho produktu do furmulare
 *
 *	<form action="{link_to action="baskets/add_product"}" method="post">
 *		{!$product|add_to_basket_field}
 *		<button type="submit">Pridat do kosiku</button>
 *	</form>
 */
function smarty_modifier_add_to_basket_field($product){
	$form = new ApplicationForm();
	$field = $form->add_field("amount", new OrderQuantityField($product));
	$field->widget->attrs["id"] = "id_amount_".$product->getId(); // we must have unique ids on one page when more product variants are displayed
	return $form->get_field("amount")->as_widget();
}
