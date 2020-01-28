<?php
/***
 * Range field, used by FilterRangeSection
 ***/


Class FilterRangeField extends RangeField implements IFilterFormField {

	function __construct($options = []){
		$this->section = $options['filter_section'];
		$options += [
			"required" => false,
			"autocorrect" => true,
			"unbounded" => true,
			"initial" => $this->section->getPossibleRange()
		];
		parent::__construct($options);
	}

	function update_by_filter() {
		$range = $this->section->getAvailableRange();
		if($range) {
				if($range['min'] == $range['max']) {
					$this->widget->disabled = true;
					$range['min']-=0.000001;
				}
				$this->set_range($range, 'widget');
		} else {
				$this->widget->disabled = true;
		}
	}
}
