<?php
/**
 * Vyrenderuje RadioSelect pro vyber varianty i s obrazkem a cenou
 *
 * Napsano tak, ze v choices jsou objekty
 *
 *
 *
 * 	$this->add_field("agreement",new ChoiceField(array(
 * 		"label" => "Do you agree?",
 * 		"widget" => new SelectWithImages(array(
 * 			"choices" => array(
 * 				"1" => Product,
 * 				"2" => Product,
 * 				"3" => Product,
 * 			),
 * 		))
 * 	)));
 *
 */
Atk14Require::Helper("modifier.display_price");
class SelectWithImages extends RadioSelect
{
	var $input_type = "radio";

	function __construct($options = array()){
		$options += array(
			"image_geometry" => "x100",
			"price_fetcher" => null,
			"show_prices" => false,
			"show_sales" => false,
			"prices_with_vat" => true,
		);
		$this->options = $options;

		parent::__construct($options);
	}

	function _renderer($name, $value, $attrs, $choices) {
		$output = array();
		$i = 0;
		foreach ($choices as $k => $v) {
			$ch = new RadioInputWithImage($name, $value, $attrs, $k, $v, $i);
			$ch->options = $this->options;

			$output[] = "<li class=\"list__item\" data-id='$k'>".$ch->render()."</li>";
			$i++;
		}
		$data_api_url = "";
		//$ch && ($data_api_url = Atk14Url::BuildLink(array("namespace" => "api", "controller" => "cards", "action" => "detail", "id" => $ch->object->getCard())));
		//return "<ul class=\"radios\" data-api_detail_url=\"".$data_api_url."\">\n".implode("\n", $output)."\n</ul>";
		return "<ul class=\"list list--radios\">\n".implode("\n", $output)."\n</ul>";
	}
}


/**
 * Widget pro radio button s obrazkem varianty produktu
 *
 */
class RadioInputWithImage {
	var $input_type = "radio";

	function __construct($name, $value, $attrs, $key, $choice, $index) {
		$this->object = $choice;
		$this->key = $key;
		$this->name = $name;
		$this->value = $value;
		$this->attrs = $attrs;
		$this->index = $index;
	}

	function is_checked() {
		return $this->value == $this->key;
	}

	function tag() {
		if (isset($this->attrs['id'])) {
			$this->attrs['id'] = $this->attrs['id'].'_'.$this->index;
		}
		$final_attrs = forms_array_merge($this->attrs, array(
			'type' => $this->input_type,
			'name' => $this->name,
			'value' => $this->key
		));
		if ($this->is_checked()) {
			$final_attrs['checked'] = 'checked';
		}

		# pokud je napojena dopravni sluzba, potrebujeme zvolit pobocku
		$final_attrs["data-branch_needed"] = !is_null($this->object->dm) && $this->object->dm->hasKey("delivery_service_id") && !is_null($this->object->dm->getDeliveryServiceId());
		
		#$final_attrs["data-can_be_ordered"] = $this->object->canBeOrdered() ? "true" : "false";
		return '<input'.flatatt($final_attrs).' />';
	}

	function image() {
		$image = $this->object->getImage();
		$title = forms_htmlspecialchars($this->object->getLabel());
		if ($image) {
			if(is_object($image)) {
				$image = $image->getUrl();
			}
			$p = new Pupiq($image,$api_key);
			return sprintf("<img src='%s' alt='%s'>",$p->getUrl($this->options["image_geometry"]),$title);
		} else {
			return '';
		}
	}

	function caption() {
		return '<span class="v-name">'.forms_htmlspecialchars($this->object->getLabel()).'</span>';
	}

	function hint() {
		$hint = $this->object->getHint();
		if(!$hint) { return ''; };
		return "<span class='v-hint'><span class='v-hint-title'>{$this->object->getHintTitle()}</span>$hint</span>";
	}

	function price() {
		$price = $this->object->getPrice();
		if($price === null) { return ''; };
		if($price === 0) { return "<span class='v-price for-free'>"._('Zdarma') . '</span>'; };
		return "<span class='v-price'>$price</span>";
	}

	function branchAddress() {
		if (is_null($this->options["controller"])) {
			return "";
		}
		$basket = $this->options["controller"]->basket;
		$current_dm = $this->object->dm;
		$basket_dm = $basket->getDeliveryMethod();

		$branch = null;

		if ($current_dm && $basket_dm && !is_null($current_dm->getDeliveryServiceId()) && ($current_dm->getDeliveryServiceId()===$basket_dm->getDeliveryServiceId())) {
			$branch = $basket->getDeliveryServiceBranch();
		}

		$out = smarty_function_render(array("partial" => "delivery_service_branch_field", "branch" => $branch, "delivery_method" => $current_dm), $this->options["controller"]->_get_smarty());
		return $out;
	}

	function render() {
		$attr = [
			// TODO: code review needed: tohle upravil Mattez
			"for" => $this->attrs['id'].'_'.$this->index,
		];
		return '<div class="radio">'.$this->tag().'<label'.flatatt($attr).'>'.$this->image() . $this->caption() . $this->hint() . $this->price(). '</label></div>'.$this->branchAddress();
	}
}
