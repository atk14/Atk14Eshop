<?php
class MainController extends AdminController{

	function index(){
		$this->page_title = _("Administration");

		// Number of today's order
		$this->tpl_data["number_of_todays_orders"] = $this->dbmole->selectInt("SELECT COUNT(*) FROM orders WHERE created_at>=:today",[":today" => date("Y-m-d 00:00:00")]);

		// Orders in progress
		$this->tpl_data["total_orders_in_progress"] = $this->dbmole->selectInt("SELECT COUNT(*) FROM orders WHERE order_status_id IN (SELECT id FROM order_statuses WHERE NOT (finished_successfully	OR finished_unsuccessfully OR finishing_successfully OR finishing_unsuccessfully))");

		// Orders stats
		$min_date = Date::ByDate((date("Y")-2)."-01-01");
		$rows = $this->tpl_data["orders_stat"] = $this->dbmole->selectIntoAssociativeArray("
			SELECT created_at::DATE,COUNT(*) FROM orders WHERE created_at>:min_date GROUP BY created_at::DATE ORDER BY created_at::DATE
		",[":min_date" => $min_date]);

		$daily_orders_stats = [];
		$monthly_orders_stats = [];
		$yearly_orders_stats = [];
		//
		$date = $min_date;
		while(1){
			$cnt = isset($rows["$min_date"]) ? (int)$rows["$min_date"] : 0;
			// keys are timestamps in miliseconds
			$y = strtotime($date->toString("Y-01-01 12:00:00")) * 1000;
			$m = strtotime($date->toString("Y-m-01 12:00:00")) * 1000;
			$t = strtotime("$date 12:00:00") * 1000;

			if(!isset($yearly_orders_stats[$y])){ $yearly_orders_stats[$y] = 0; }
			if(!isset($monthly_orders_stats[$m])){ $monthly_orders_stats[$m] = 0; }

			$daily_orders_stats[$t] = $cnt;
			$yearly_orders_stats[$y] += $cnt;
			$monthly_orders_stats[$m] += $cnt;

			if($date->isToday()){ break; }
			$date->addDay();
		}
		//
		$this->tpl_data["daily_orders_stats"] = $daily_orders_stats;
		$this->tpl_data["yearly_orders_stats"] = $yearly_orders_stats;
		$this->tpl_data["monthly_orders_stats"] = $monthly_orders_stats;

		// Unfinished baskets
		$limit_date = date("Y-m-d H:i:s",time() - 60 * 60 * 12);
		$unfinished_baskets_ids = $this->dbmole->selectIntoArray("
			SELECT DISTINCT(basket_id) FROM (
				SELECT id AS basket_id FROM baskets WHERE COALESCE(updated_at,created_at)>:limit_date
				UNION
				SELECT basket_id FROM basket_items WHERE COALESCE(updated_at,created_at)>:limit_date
			)q
		",[":limit_date" => $limit_date]);
		$unfinished_baskets = Cache::Get("Basket",$unfinished_baskets_ids);
		$this->tpl_data["unfinished_baskets_count"] = sizeof($unfinished_baskets);
		$this->tpl_data["unfinished_baskets"] = $unfinished_baskets;
	}
}
