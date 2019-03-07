<?php
class WarehouseItemsController extends AdminController {

	function index(){
		$warehouse = $this->warehouse;

		$this->page_title = sprintf(_("Products in warehouse %s"),$warehouse->getName());

		$conditions = $bind_ar = [];

		$this->form->set_hidden_field("warehouse_id",$warehouse->getId());

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions[] = "warehouse_id=:warehouse";
		$bind_ar[":warehouse"] = $warehouse;

		$_catalog_id = "(SELECT catalog_id FROM products WHERE products.id=warehouse_items.product_id)";
		$_name = "(SELECT body FROM translations WHERE table_name='cards' AND record_id=(SELECT card_id FROM products WHERE products.id=warehouse_items.product_id) AND key='name' AND lang='$this->lang')";
		$_std_sorting = "$_catalog_id";

		if($d["search"] && ($conds = FullTextSearchQueryLike::GetQuery("UPPER($_catalog_id||' '||COALESCE($_name,''))",Translate::Upper($d["search"]),$bind_ar))){
			$this->sorting->add("UPPER($_catalog_id)=UPPER(:search) DESC, UPPER($_catalog_id) LIKE UPPER(:search)||'%' DESC, $_catalog_id, $_std_sorting");
			$bind_ar[":search"] = $d["search"];
			$conditions[] = $conds;
		}

		$this->sorting->add("catalog_id","$_catalog_id ASC, $_std_sorting","$_catalog_id DESC, $_std_sorting");
		$this->sorting->add("stockcount","stockcount, $_catalog_id, $_std_sorting","stockcount DESC, $_catalog_id DESC, $_std_sorting");
		$this->sorting->add("name","$_name, $_catalog_id, $_std_sorting","$_name DESC, $_catalog_id DESC, $_std_sorting");

		$this->tpl_data["finder"] = WarehouseItem::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
			"offset" => $this->params->getInt("offset"),
		]);
	}

	function create_new(){
		$this->_create_new([
			"page_title" => _("New warehouse entry"),
			"create_closure" => function($d) {
				$d["warehouse_id"] = $this->warehouse;
				return WarehouseItem::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Edit warehouse entry")
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		$warehouse = null;

		if(in_array($this->action,["index","create_new"])){
			$warehouse = $this->_find("warehouse","warehouse_id");
		}

		if($this->action=="edit"){
			$item = $this->_find("warehouse_item");
			if($item){
				$warehouse = $this->warehouse = $this->tpl_data["warehouse"] = $item->getWarehouse();
				$this->tpl_data["product"] = $item->getProduct();
			}
		}

		if($warehouse){
			$this->breadcrumbs[] = [$warehouse->getName(),$this->_link_to(["action" => "warehouse_items/index", "warehouse_id" => $warehouse])];
		}
	}
}
