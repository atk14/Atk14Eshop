<?php
class FilterCheckboxSelectMultiple extends CheckboxSelectMultiple {

	var $disabled_choices = array();

	function set_disabled_choices($choices){
		$this->disabled_choices = $choices;
	}
	
	function render($name, $value, $options = array()){
		$out = parent::render($name, $value, $options);

		$replaces = [];
		foreach($this->disabled_choices as $v){

			// toto:   <li class="checkbox"><label><input id="id_c_0" type="checkbox" name="c[]" checked="checked" value="3" /> Červená</label></li>
			// konveruje do
			// tohoto: <li class="checkbox disabled"><label><input id="id_c_0" type="checkbox" name="c[]" value="3" disabled="disabled" /> Červená</label></li>
			if(preg_match('/(<li class="checkbox">.*?<.*?value="'.$v.'".*?\/?>.*?<\/li>)/',$out,$matches)){
				$key = $matches[1];
				$replacement = preg_replace('/(type="checkbox".*?)( ?\/?>)/','\1 disabled="disabled"\2',$key);
				$replacement = preg_replace('/ checked="checked"/','',$replacement);
				$replacement = preg_replace('/class="checkbox"/','class="checkbox disabled"',$replacement);
				$replaces[$key] = $replacement;
			}
		}

		$out = strtr($out,$replaces);

		return $out;
	}
}
