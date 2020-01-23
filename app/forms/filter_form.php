<?php
/**
 * Common form for filters
 */
class FilterForm extends ApplicationForm {

	function set_up(){
		$this->set_button_text(_("Filtrovat"));
		$this->set_attr('id', 'filter_form');
		$this->set_attr('autocomplete', 'off');

		$this->top_fields = ['f_flags' => 'f_flags'];
	}

	function set_up_filter($filter, $params, $options = []) {
		$options += [
			'action' => null,
			'update_choices' => true
		];

		if($options['action']) {
			$this->set_action($options['action']);
		}
		$this->init_by_filter($filter);
		$this->parse_params($params);
		//in some xhr requests it doesn't need to be done
		if($options['update_choices']) {
			$this->update_choices($params);
		}
	}

	/**
	 * Create form fields according to the filter
	 */
	function init_by_filter($filter) {
		$this->filter = $filter;

		$add = [];
		foreach($filter->sections as $section) {
			$add += $section->createFormFields($this);
		}
		foreach($add as $name => $field) {
			$this->add_field($name, $field);
		}
	}

	/**
	 * Validate the data and set up the filter accordingly
	 */
	function parse_params($params) {
		//Validate data
		$data = $this->validate($params);
		if(!$data) { $data = []; }

		//Parse data by filter
		$this->filter->parse($data);
	}

	/**
	 * Update the form by the information given
	 * from parsed data (e.g. disable options for which no results exists)
	 **/
	function update_choices() {
		//Update state of fields (e.g. disable options for which no valid item exists)
		foreach($this->fields as $field) {
			if($field instanceof IFilterFormField) {
				$field->update_by_filter($this->filter);
			}
		}
	}

	function clean() {
		list($error, $data) = parent::clean();
		if($data) {
			$this->data = $data;
		}
		return array($error, $data);
	}

	function get_tab_fields() {
		$out = $this->get_fields();
		return array_diff_key($out, $this->top_fields);
	}

	function top_fields() {
		return array_intersect_key($this->top_fields, $this->get_fields());
	}

}
