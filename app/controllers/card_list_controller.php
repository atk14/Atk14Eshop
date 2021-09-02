<?php
abstract class CardListController extends ApplicationController {
	var $page_size = 24;

	function _setup_category(&$options) {
		$path = $this->params->getString("path");
		if(!($category = Category::GetInstanceByPath($path)) || !$category->isVisible() || $category->isFilter() || (($p = $category->getParentCategory()) && $p->isFilter())){
			return $this->_execute_action("error404");
		}

		if(!$path) {
			$category = Category::FindByCode("catalog");
			if(!$category) {
				$this->_error404();
				return false;
			}
			$this->_redirect_to(['path' => $category->getPath()]);
			return false;
		}

		// vytiskneme do <head></head> element <link rel="canonical">
		if($path!=($_path = $category->getPath())){
				$this->tpl_data["canonical_path"] = $_path;
		}

		$parent_categories = Category::GetInstancesOnPath($path);
		$this->catalog = reset( $parent_categories );
		$this->tpl_data["category"] = $category = $this->category =
					$category = array_pop($parent_categories);
		$this->parent_categories = $parent_categories;
		$this->tpl_data['path'] = $path;
		$this->tpl_data["parent_categories"] = $parent_categories;

		if(!$category || !$category->isVisible() || $category->isFilter() || (($p = $category->getParentCategory()) && $p->isFilter())){
			return $this->_execute_action("error404");
		}
		list($cond, $bind, $ctable) = $category->sqlConditionForCardsIdBranch('cards.id', ['categories_table' => true]);
		$bind[':sort_category'] = $category;
		$do = new \SqlBuilder\SqlJoinOrder("order_a, order_b, cards.id ASC",
				"JOIN (SELECT NOT category_id = :sort_category, row_number() over(partition by category_id order by rank, card_id ASC), card_id from category_cards WHERE category_id IN (SELECT * from $ctable)) order_t(order_a,order_b) ON (order_t.card_id = cards.id)");
		$options += ['default_order' => ['asc' => $do, 'desc' => $do->reversed() ]];
		$this->_add_category_to_breadcrumbs($this->category,[
			"path" => $path,
			"first_breadcrumb_title" => $options["first_breadcrumb_title"],
		]);
		return [ $cond, $bind ];
	}

	function _add_category_to_breadcrumbs($category,$options = []) {
		$options += [
			"path" => "",
			"first_breadcrumb_title" => "", // "" -> auto, "Novinky", "Slevy"
		];

		$path = $options["path"] ? $options["path"] : $category->getPath();
		$categories = Category::GetInstancesOnPath($path);

		$_first = true;
		$first_breadcrumb_title = $options["first_breadcrumb_title"];

		foreach($categories as $ppath => $pc){

			if($_first){
				$_first = false;
				$_pc_name = $first_breadcrumb_title ? $first_breadcrumb_title : $pc->getName();
			}else{
				$_pc_name = $pc->getName();
			}
			
			$_url = $this->_link_to(array("action" => "categories/detail", "path" => $ppath));
			$this->breadcrumbs[] = array($_pc_name,$_url);
		}
	}

	function _setup_child_categories($options) {
			if(!$this->request->xhr()) {
				$category_filter = clone $this->filter;
				// child categories
				$this->tpl_data["child_categories"] = new CategoryTree(
					$this->category,
					['direct_children_only' => true,
					 'is_filter' => false,
					 'visible' => true,
					 'has_cards' => true,
					 'return_cards_count' => true,
					 'count' => true,
					 'cards_filter' => $category_filter
				 ]
			 );
			}
	}

	function _setup_sorting(&$options) {
		$sorting = $this->pager->getSorting();
		//$sorting['default'] = FilterFinder::DEFAULT_ORDER;
		$sorting['default'] = $options['default_order'];
		#$sorting['price'] = '(SELECT ROW(price, NOW() - sorting_date) FROM prepared_cards WHERE id=cards.id)';
		#$sorting['price_desc'] = '(SELECT ROW(-price, sorting_date) FROM prepared_cards WHERE id=cards.id)';
		#$options['materialized_fields'][] = 'price';
		$sorting['popularity'] = '(SELECT ROW(-rating, NOW() - sorting_date) FROM prepared_cards WHERE id=cards.id)';
		$sorting['name'] = "(SELECT body FROM translations WHERE record_id=cards.id AND table_name='cards' AND key='name' AND lang=:lang)";
		$sorting['code'] = "(SELECT public_catalog_id(catalog_id) FROM products WHERE card_id = cards.id)";
	}

	function _setup_page_title($options) {
		if($this->category) {
			$this->page_title = $this->category->getPageTitle();
			$this->tpl_data['h1'] = $this->page_title;
			$this->page_description = $this->category->getPageDescription();
		}
	}

	function _detail($options=[]){
		$options += [
			'conditions' => '',
			'bind' => [],
			'category' => true,
			"first_breadcrumb_title" => "", // "" -> auto, "Novinky", "Slevy"
			"materialized_fields" => []
		];
		if($options['category']) {
			$out = $this->_setup_category($options);
			if(!$out) return;
			list($cond, $bind) = $out;
		} else {
			$this->category = false;
			$cond = $bind = [];
			$options += ['default_order' => 'cards.id DESC'];
		}

		if($options['conditions']) {
			$cond += $options['conditions'];
		}
		$bind += $options['bind'];

		#$bind[':lang'] = $this->lang;
		#$cond[] = "(regions->>'$this->current_region')::BOOLEAN"; // "(regions->>'CR')::BOOLEAN"

		if($options['conditions']){
			$cond[] = $options['conditions'];
		}

		$this->form = $this->tpl_data['form'] = $this->_get_form("FilterForm");
		$this->tpl_data['pager'] = $this->pager = $pager = new CardsAjaxPager($this, [
			'form' => $this->_get_form("CardListPagingForm"),
			'page_size' => $this->page_size
		]);
		$this->tpl_data["paging_form"] = $pager->form;

		$this->_setup_sorting($options);

		$this->filter = $filter = new FilterForCards($this->effective_user, [
				'conditions' => $cond,
				'bind' => $bind,
				'category' => $this->category,
				'materialized_fields' => array_merge($options['materialized_fields']),
				#'currency' => $this->basket->getCurrency()
		]);
		$this->tpl_data['page_params'] = array_filter($this->params->toArray(),function($k) { return substr($k,0,2) !== 'f_'; }, ARRAY_FILTER_USE_KEY);

		if($options['category']) {
				$this->_setup_child_categories($options);
		}

		$this->form->set_up_filter($filter, $this->params, [
				#'action' => $this->_link_to([ 'path' => $path ]),
				'update_choices' => !$pager->isXhr()
		]);
		$this->finder = $this->tpl_data['finder'] = $finder = new FilterFinder($this->form->filter, [
			'pager' => $pager,
			'use_cache' => true
		]);
		$this->finder->getRecordIds();
		//var_dump($this->dbmole->getQuery());
		$afp = $this->params->g('active_filter_page');
		if(!$afp || !key_exists($afp, $this->form->get_tab_fields())) {
			$fk = $this->form->get_tab_fields();
			$afp = key($fk);
		}
		$this->tpl_data['active_filter_page'] = $afp;

		$this->_setup_page_title($options);

		if(!$pager->isXhr()) {
			$this->tpl_data['filtered'] = true;
			if(!$this->form->fields){
				// formular nema zadne policka - nebudeme ho zobrazovat
				$this->form = null;
			}
			if($this->request->xhr()) {
				$this->template_name = 'shared/filter/detail.xhr';
				$params = $this->params->toArray();
				$this->tpl_data['pageUrl'] = $this->_link_to($params);
			}
		}
		return true;
		/*$this->finder->getRecords();
		$ctable = ($this->category->sqlConditionForCardsIdBranch('cards.id', ['categories_table' => true])[2]);
		var_dump($this->dbmole->selectRows("SELECT
			(SELECT rec FROM (SELECT row(NOT category_id = :sort_category, row_number() over(partition by category_id order by rank, card_id DESC)) as rec, card_id FROM category_cards WHERE category_id IN
			(SELECT * from $ctable)) _q WHERE card_id = cards.id ORDER BY 1 LIMIT 1),
			cards.id
				FROM
						cards
				WHERE
						id IN :ids
						ORDER BY 1,2", [':ids' => $this->finder->getRecordIds()] + $bind));*/
	}

	function _before_filter(){
		// index neukazujeme
		//$this->breadcrumbs[] = array(_("Categories"),$this->_link_to("index"));
	}

}
