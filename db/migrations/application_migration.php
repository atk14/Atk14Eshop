<?php
/**
 * The base class for all PHP migrations
 *
 * The perfect place for common methods (e.g. lorem ipsum generator)
 */
class ApplicationMigration extends Atk14Migration{

	/**
	 * Returns random lorem_ipsum paragraphs
	 *
	 * It uses www.lipsum.com API.
	 */
	protected function _lipsumParagraphs($amount = 2, $connector = "\n\n"){
		$uf = new UrlFetcher("http://www.lipsum.com/feed/xml?amount=$amount&what=paras&start=0");
		$lipsum = simplexml_load_string($uf->getContent())->lipsum;
		return str_replace("\n",$connector,$lipsum);
	}

	function _link_to($params){
		return Atk14Url::BuildLink($params);
	}

	function _link_to_page($code){
		Atk14Require::Helper("modifier.link_to_page");
		return smarty_modifier_link_to_page($code);
	}

	function _link_to_category($code){
		Atk14Require::Helper("modifier.link_to_category");
		return smarty_modifier_link_to_category($code);
	}

	/**
	 *
	 *	$this->_appendNextOrderStatuses("ready_for_pickup",["delivered","returned","cancelled"]);
	 */
	function _appendNextOrderStatuses($code,$next_codes){
		$os = OrderStatus::GetInstanceByCode($code);
		$lister = $os->getAllowedNextOrderStatusesLister();
		foreach($next_codes as $next_code){
			$next_os = OrderStatus::GetInstanceByCode($next_code);
			if($lister->contains($next_os)){ continue; }
			$lister->append($next_os);
		}
	}
}
