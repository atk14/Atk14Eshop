<?php
class FilterCheckboxSelectMultiple extends SelectMultiple
{
	/**
	 * @param array $options
	 * - **escape_labels** - escaping html in checkbox labels [default: true]
	 *
	 */
	function __construct($options = array())
	{
		$options += array(
			"escape_labels" => true
		);
		$this->escape_labels = $options["escape_labels"];
		$this->filter_section = $options['filter_section'];
		parent::__construct($options);
	}

	function render($name, $value, $options=array())
	{
		$options = forms_array_merge(array('attrs'=>null, 'choices'=>array()), $options);
		if (is_null($value) || $value==="" || !is_array($value)) {
			$value = array();
		}
		$has_id = is_array($options['attrs']) && isset($options['attrs']['id']);
		$final_attrs = $this->build_attrs($options['attrs']);

		// pouzity markup vychazi z http://activa.localhost/public/styleguides/docs/4.1/components/forms/index.html#checkboxes-and-radios-1
		$output = [];
		$output[] = '<ul class="list list--checkboxes">';
		$choices = my_array_merge(array($this->choices, $options['choices']));


		$disableds = array_flip($this->disabled_choices);
		$values = array_flip($value);

		$i = 0;
		$id = '';

		global $HTTP_REQUEST;
	  $params = $HTTP_REQUEST->getAllGetVars();

		foreach ($choices as $option_value => $option_label) {
			if ($has_id) {
				$id="{$options['attrs']['id']}_$i";
			}else{
				$id = "{$name}_".uniqid()."_$i";
			}
			$label = $this->escape_labels ? forms_htmlspecialchars($option_label) : $option_label;
			$checked = key_exists($option_value, $values);
			$value = $checked ? ' checked':'';
			$disabled = key_exists($option_value, $disableds)?' disabled':'';
			$checkbox = "<input type='checkbox' name='{$name}[]'$value$disabled value=$option_value class='custom-control-input' id='$id'>";

			$output[] = '<li class="list__item">';
			$output[] = "<div class=\"custom-control custom-checkbox\">";
			if($disabled) {
				//$output[] = "<li class='checkbox$disabled'>$checkbox <label>$label</label></li>";
				$output[] = "$checkbox <label class='custom-control-label' for='$id'>$label</label>";
			} else {
				$p = $values;
				if($checked) {
					unset($p[$option_value]);
				} else {
					$p[$option_value] = 'on';
				}
				$param = $params;
				$param[$name] = array_keys($p);
				$href = Atk14Url::BuildLink($param);
				$rel = "";
				if (preg_match("/\/\?.+$/", $href)) {
					$rel = ' rel="nofollow"';
				}

				//$output[] = "<li class='checkbox$disabled'>$checkbox <label><a class='js-filter-checkbox-label' href='$href'>$label</a></label></li>";
				$output[] = "$checkbox <label class='custom-control-label' for='$id'><a class='js-filter-checkbox-label' href='$href'${rel}>$label</a></label>";
			}
			$output[] = "</div>";
			$output[] = "</li>";

			$i++;
		}
		$output[] = '</ul>';

		return join("\n",$output);
	}

	var $disabled_choices = [];

	function set_disabled_choices($choices){
		$this->disabled_choices = $choices;
	}
}
