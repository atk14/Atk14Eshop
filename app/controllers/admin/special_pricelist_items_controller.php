<?php
class SpecialPricelistItemsController extends AdminController {

	function index(){
		$special_pricelist = $this->special_pricelist;

		$this->page_title = sprintf(_("Prices in special_pricelist %s"),$special_pricelist->getName());

		$conditions = $bind_ar = [];

		$this->form->set_hidden_field("special_pricelist_id",$special_pricelist->getId());

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions[] = "special_pricelist_id=:special_pricelist";
		$bind_ar[":special_pricelist"] = $special_pricelist;

		$_catalog_id = "(SELECT catalog_id FROM products WHERE products.id=special_pricelist_items.product_id)";
		$_name = "(SELECT body FROM translations WHERE table_name='cards' AND record_id=(SELECT card_id FROM products WHERE products.id=special_pricelist_items.product_id) AND key='name' AND lang='$this->lang')";
		$_std_sorting = "$_catalog_id, minimum_quantity, price";
		$_price = "price / 100.0 * (100.0 - COALESCE((SELECT vat_percent FROM vat_rates WHERE id=(SELECT vat_rate_id FROM products WHERE id=special_pricelist_items.product_id)),0.0))";

		if($d["search"] && ($conds = FullTextSearchQueryLike::GetQuery("UPPER($_catalog_id||' '||COALESCE($_name,''))",Translate::Upper($d["search"]),$bind_ar))){
			$this->sorting->add("UPPER($_catalog_id)=UPPER(:search) DESC, UPPER($_catalog_id) LIKE UPPER(:search)||'%' DESC, $_catalog_id, $_std_sorting");
			$bind_ar[":search"] = $d["search"];
			$conditions[] = $conds;
		}

		$this->sorting->add("catalog_id","$_catalog_id ASC, $_std_sorting","$_catalog_id DESC, $_std_sorting");
		$this->sorting->add("price_incl_vat","price, $_catalog_id, $_std_sorting","price DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("price","$_price, $_catalog_id, $_std_sorting","$_price DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("minimum_quantity","minimum_quantity, $_catalog_id, $_std_sorting","minimum_quantity DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("name","$_name, $_catalog_id, $_std_sorting","$_name DESC, $_catalog_id DESC, $_std_sorting");

		$this->tpl_data["currency"] = Currency::GetDefaultCurrency();
		$this->tpl_data["finder"] = SpecialPricelistItem::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
			"offset" => $this->params->getInt("offset"),
		]);
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("Nová cena"),
			"create_closure" => function($d) {
				$d["special_pricelist_id"] = $this->special_pricelist;
				return SpecialPricelistItem::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace ceny")
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		$special_pricelist = null;

		if(in_array($this->action,["index","create_new"])){
			$special_pricelist = $this->_find("special_pricelist","special_pricelist_id");
		}

		if($this->action=="edit"){
			$item = $this->_find("special_pricelist_item");
			if($item){
				$special_pricelist = $this->special_pricelist = $this->tpl_data["special_pricelist"] = $item->getSpecialPricelist();
				$this->tpl_data["product"] = $item->getProduct();
			}
		}

		if($special_pricelist){
			$this->breadcrumbs[] = [$special_pricelist->getName(),$this->_link_to(["action" => "special_pricelist_items/index", "special_pricelist_id" => $special_pricelist])];
		}
	}
}
