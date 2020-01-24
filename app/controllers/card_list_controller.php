<?php
abstract class CardListController extends ApplicationController {
	var $page_size = 30;

	function _setup_category($options) {
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
		list($cond, $bind) = $category->sqlConditionForCardsIdBranch('cards.id');
		$bind[':sort_category'] = $category;
		$this->_setup_category_breadcrumbs($options);

		return [ $cond, $bind ];
	}

	function _setup_category_breadcrumbs($options) {
			$_first = true;
			$first_breadcrumb_title = $options["first_breadcrumb_title"];

			foreach($this->parent_categories as $ppath => $pc){

				if($_first){
					$_first = false;
					$_pc_name = $first_breadcrumb_title ? $first_breadcrumb_title : $pc->getName();
				}else{
					$_pc_name = $pc->getName();
				}

				$_url = $this->_link_to(array("path" => $ppath));
				$this->breadcrumbs[] = array($_pc_name,$_url);

				$this->go_back_url = $_url;
				$this->go_back_url_title = sprintf(_("Zpět do %s"),strip_tags($_pc_name));
			}
			$this->breadcrumbs[] = (!$this->parent_categories && $first_breadcrumb_title) ? $first_breadcrumb_title : $this->category->getName();
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
		#$options['materialize_fields'][] = 'price';
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
			'default_order' => 'cards.id DESC',
			"first_breadcrumb_title" => "", // "" -> auto, "Novinky", "Slevy"
			"materialize_fields" => []
		];
		if($options['category']) {
			$out = $this->_setup_category($options);
			if(!$out) return;
			list($cond, $bind) = $out;
		} else {
			$this->category = false;
			$cond = $bind = [];
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
				'materialize_fields' => array_merge($options['materialize_fields']),
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
			'pager' => $pager
		]);

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
	}

	function _before_filter(){
		// index neukazujeme
		//$this->breadcrumbs[] = array(_("Categories"),$this->_link_to("index"));
	}

}
