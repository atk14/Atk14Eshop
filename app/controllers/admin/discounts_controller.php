<?php
class DiscountsController extends AdminController {

	function index(){
		$this->page_title = _("List of discounts");
		$conditions = $bind_ar = [];

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		if ($d["holder"]) { // "product", "category"
			$conditions[] = "$d[holder]_id IS NOT NULL";
		}

		$q_low = Translate::Lower($d["search"]);

		if($ft_cond = FullTextSearchQueryLike::GetQuery("LOWER(".join("||' '||",array(
				"id",
				"discount_percent",

				// cards
				"COALESCE((SELECT body FROM translations WHERE record_id=(SELECT card_id FROM products WHERE products.id=discounts.product_id) AND table_name='cards' AND key='name' AND lang=:lang),'')",
				"COALESCE((SELECT body FROM translations WHERE record_id=(SELECT card_id FROM products WHERE products.id=discounts.product_id) AND table_name='cards' AND key='teaser' AND lang=:lang),'')",

				// products
				"COALESCE((SELECT catalog_id FROM products WHERE products.id=discounts.product_id),'')",
				"COALESCE((SELECT body FROM translations WHERE record_id=discounts.product_id AND table_name='products' AND key='name' AND lang=:lang),'')",
				"COALESCE((SELECT body FROM translations WHERE record_id=discounts.product_id AND table_name='products' AND key='label' AND lang=:lang),'')",
				"COALESCE((SELECT body FROM translations WHERE record_id=discounts.product_id AND table_name='products' AND key='description' AND lang=:lang),'')",

				// categories
				"COALESCE((SELECT body FROM translations WHERE record_id=discounts.category_id AND table_name='categories' AND key='name' AND lang=:lang),'')",
				"COALESCE((SELECT body FROM translations WHERE record_id=discounts.category_id AND table_name='categories' AND key='long_name' AND lang=:lang),'')",

			)).")",$q_low,$bind_ar)
		){
			$bind_ar[":lang"] = $this->lang;
			$conditions[] = $ft_cond;

			$this->sorting->add("search","
				LOWER(COALESCE((SELECT catalog_id FROM products WHERE products.id=discounts.product_id),'')) LIKE :q_low||'%' DESC, -- catalog_id from the beginning
				LOWER(COALESCE((SELECT catalog_id FROM products WHERE products.id=discounts.product_id),'')) LIKE '%'||:q_low||'%' DESC, -- catalog_id from anywhere
				created_at DESC,
				id ASC
			");
			$bind_ar[":q_low"] = $q_low;
		}

		$this->sorting->add("created_at","created_at DESC, id DESC","created_at ASC, id ASC");
		$this->sorting->add("discount_percent","discount_percent DESC, created_at DESC, id DESC","discount_percent ASC, created_at ASC, id ASC");

		$this->tpl_data["finder"] = Discount::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("offset"),
			"order_by" => $this->sorting,
		]);
	}
	
	function create_new(){
		$this->_create_new();
	}

	function edit(){
		$this->_edit();
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filder(){
		if(in_array($this->action,"edit")){
			$this->_find("discount"); // Potrebujeme $this->discount ve EditForm
		}
	}
}
