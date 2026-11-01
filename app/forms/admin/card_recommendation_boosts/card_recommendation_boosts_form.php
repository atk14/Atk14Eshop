<?php
class CardRecommendationBoostsForm extends AdminForm {
	function set_up() {
		$this->add_field("card_id", new CardField(array(
			"label" => _("Product")
		)));

		$this->add_field("negative", new BooleanField(array(
			"label" => _("Negativní boost (potlačit v doporučeních)"),
			"required" => false,
			"initial" => false,
		)));
	}
}
