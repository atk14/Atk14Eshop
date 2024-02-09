<?php

/**
 * Generator pro dataLayer pro objednavku
 *
 * Dedi zakladni DatalayerGenerator, pro tento pripad to staci, dokud zpravu posilame 'postaru'
 * @todo upravit pro enhanced ecomm ecommerce:
 * - upravit klice v seznamu produktu
 * - v kontroleru v metode finish misto measureOtherObject pouzit measurePurchase (pripadne jinou podle aktualniho stavu knihovny)
 * - upravit nastaveni v GTM
 *
 * @todo jako bombonek doplnit kontrolu existence 'track_order' v session a podle toho odpoved vygenerovat nebo ne.
 */
class CustomProductDetail extends DatalayerGenerator\MessageGenerators\ProductDetail implements DatalayerGenerator\MessageGenerators\iMessage {

	function getActivityData() {
		$options = $this->options;

		$out = [];
		foreach($this->getObject()->getProducts() as $_p) {
			$objDT = \DatalayerGenerator\Datatypes\ecDatatype::CreateProduct($_p, $options);
			if ($_out = $objDT->getData()) {
				$out[] = $_out;
			}
		}
		return ["products" => $out];
	}

	function getActionField() {
		return [
			"list" => "product",
		];
	}
}
