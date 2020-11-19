<?php
class RefreshMvCardCategoriesRobot extends ApplicationRobot {

	function run(){
		// CONCURRENTLY requires at least one unique index on the materialized view
		// see db/migrations/0114_adding_unique_index_on_mv_card_categories.sql
		$this->dbmole->doQuery('
			REFRESH MATERIALIZED VIEW CONCURRENTLY mv_card_categories
	  ');
	}
}
