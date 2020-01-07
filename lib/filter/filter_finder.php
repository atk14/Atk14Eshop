<?php
/**
 * Finder pro filtry.
 * new FilterFinder($filter);
 * new FilterFinder($filter, ['pager' => $pager ] ); //change template etc. to send the proper data as response for xhr request, if it's apropriate
 */
class FilterFinder extends TableRecord_Finder {

	const DEFAULT_ORDER = '('; #a value that is not valid

	function __construct($filter, $options = []) {
		$this->filter = $filter;
		$this->_Records = null;
    $this->options = $options += array(
			"class_name" => $filter->getModel(),
      "use_cache" => TABLERECORD_USE_CACHE_BY_DEFAULT,
			"sql_options" => [],
			"postprocess" => null,
			"pager" => null  #AjaxPager object - if it is set, it's handled automaticly
		);

		$sql_options = $options['sql_options'];
		if($options['pager']) {
			$sql_options['limit'] = $options['pager']->getLimit();
			$sql_options['offset'] = $options['pager']->getOffset();
			$order = $options['pager']->getSqlOrder();
			if($order && $order!=self::DEFAULT_ORDER) { $sql_options['order'] = $order ; }
		}

		$this->result = $filter->result(['sql_options' => $sql_options]);
		list($query, $bind) = $this->result->distinctOnSelect( $filter->getIdField() );
		$this->query=$query;
		$this->bind=$bind;

		$query_options = array_diff_key($options, [
				'class_name' => false,
				'use_cache' => false,
				'sql_options' => false
		]);
		$class_name = $options['class_name'];
		$dbmole = $class_name::GetDbMole();

    parent::__construct(array(
      "class_name" => $class_name,
      "query" => $query,
      "query_count" => '(not used)',
      "options" => $query_options, // options for querying
      "bind_ar" => $bind,
      "use_cache" => $options['use_cache']
		),$dbmole);

		if($this->getPager()) {
			$this->getPager()->xhr($this);
		}
	}

	function debug() {
		var_dump($this->query);
		var_dump(ApplicationModel::ObjToId($this->bind));
	}

	/** Automatic caching, as is in tablerecord->_finder() **/
	function getRecordIds() {
		$out = parent::getRecordIds();

		static $cache=null;
		if($cache === null) {
			if($this->options['use_cache']) {
	      Cache::Prepare($this->options['class_name'],$out);
			}
			$cache = false;
		}
		return $out;
	}

	function getRecords() {
		$this->_ReadRecords();
		return $this->_Records;
	}

	function _ReadRecords() {
		if(!$this->_Records) {
			$this->_RawRecords = parent::getRecords();
			if($this->options['postprocess']) {
				$fce = $this->options['postprocess'];
				$this->_Records = $fce($this->_RawRecords);
			} else {
				$this->_Records = $this->_RawRecords;
			}
		}
	}

	function getRawRecords() {
		$this->_ReadRecords();
		return $this->_RawRecords;
	}

	/** This number is needed in the filter. Use it to avoid doubling expensive SQL query. **/
	function getRecordsCount() {
		return $this->filter->getRecordsCount();
	}

	/** Limit is given by sql options applied on the result, not by the params passed to TableRecord_Finder **/
	function getLimit() {
		return $this->result->sqlOptions['limit'];
	}

	function getPager() {
		return $this->options['pager'];
	}
}
