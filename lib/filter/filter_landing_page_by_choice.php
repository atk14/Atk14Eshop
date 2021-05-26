<?php

class FilterLandingPageByChoice {

	function __construct($options = []) {
		$this->options = $options + [
			'label_string' => ' %s',
			'label_function' => null,
			'label_lowercase' => false
		];
	}

	function setSection($section) {
		$this->section = $section;
	}

	function isLandingPage() {
		$values = $this->section->getValues();
		if(count($values) != 1) {
			return false;
		}
		return true;
	}

	function label() {
		return $this->_label(current($this->section->getValues()));
	}

	function _label($id) {
		if($this->options['label_function']) {
			$fce=$this->options['label_function'];
			return $fce($id);
		} else {
			$label = $this->section->getChoiceLabels()[$id];
			if($this->options['label_lowercase']) {
				$label = mb_strtolower(mb_substr($label, 0, 1)) . mb_substr($label,1);
			}
			return sprintf($this->options['label_string'], strip_tags($label));
		}
	}

	function enumLandingPages() {
		return array_map(function($id) {
			return [
				'params' => [ $this->section->getParamName() => [ $id ] ],
				'label' => $this->_label($id)
			];
		}, $this->section->getPossibleChoices());
	}
}
