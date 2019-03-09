<?php
class RefreshMvCardCategoriesRobot extends ApplicationRobot {
	function run(){
		$this->dbmole->doQuery('
			REFRESH MATERIALIZED VIEW mv_card_categories
	  ');
	}
}
