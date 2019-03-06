<?php
class PricelistItemsController extends AdminController {

	function index(){
		$pricelist = $this->pricelist;

		$this->page_title = sprintf(_("Ceny v ceníku %s"),$pricelist->getName());

		$conditions = $bind_ar = [];

		$this->form->set_hidden_field("pricelist_id",$pricelist->getId());

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions[] = "pricelist_id=:pricelist";
		$bind_ar[":pricelist"] = $pricelist;

		$_catalog_id = "(SELECT catalog_id FROM products WHERE products.id=pricelist_items.product_id)";
		$_name = "(SELECT body FROM translations WHERE table_name='cards' AND record_id=(SELECT card_id FROM products WHERE products.id=pricelist_items.product_id) AND key='name' AND lang='$this->lang')";
		$_std_sorting = "$_catalog_id, minimum_quantity, price";

		if($d["search"] && ($conds = FullTextSearchQueryLike::GetQuery("UPPER($_catalog_id||' '||COALESCE($_name,''))",Translate::Upper($d["search"]),$bind_ar))){
			$this->sorting->add("UPPER($_catalog_id)=UPPER(:search) DESC, UPPER($_catalog_id) LIKE UPPER(:search)||'%' DESC, $_catalog_id, $_std_sorting");
			$bind_ar[":search"] = $d["search"];
			$conditions[] = $conds;
		}

		$this->sorting->add("catalog_id","$_catalog_id ASC, $_std_sorting","$_catalog_id DESC, $_std_sorting");
		$this->sorting->add("price","price, $_catalog_id, $_std_sorting","price DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("minimum_quantity","minimum_quantity, $_catalog_id, $_std_sorting","minimum_quantity DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("name","$_name, $_catalog_id, $_std_sorting","$_name DESC, $_catalog_id DESC, $_std_sorting");

		$this->tpl_data["finder"] = PricelistItem::Finder([
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
				$d["pricelist_id"] = $this->pricelist;
				return PricelistItem::CreateNewRecord($d);
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
		if(in_array($this->action,["index","create_new"])){
			$this->_find("pricelist","pricelist_id");
		}

		if($this->action=="edit"){
			$item = $this->_find("pricelist_item");
			if($item){
				$this->pricelist = $this->tpl_data["pricelist"] = $item->getPricelist();
				$this->tpl_data["product"] = $item->getProduct();
			}
		}
	}
}
