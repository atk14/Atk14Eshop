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

	function export(){
		$warehouse = $this->warehouse;
		$this->page_title = sprintf(_("Export entries from warehouse %s"),$warehouse->getName());

		if($this->params->defined("format") && ($d = $this->form->validate($this->params))){
			$format = $d["format"];

			$rows = $this->dbmole->selectRows("
				SELECT * FROM (
					SELECT warehouse_items.product_id,warehouse_items.stockcount, products.catalog_id
					FROM warehouse_items, products
					WHERE
						warehouse_items.warehouse_id=:warehouse_id AND
						products.id=warehouse_items.product_id
					".($d["export_all_products"] ? "
					UNION
					SELECT id, NULL AS stockcount, catalog_id
 					FROM products
					WHERE
						NOT deleted AND
						id NOT IN (SELECT product_id FROM warehouse_items WHERE warehouse_id=:warehouse_id) AND
						(code IS NULL OR code!='price_rounding')
					" : "")."	
				)q	
				ORDER BY catalog_id	
			",[":warehouse_id" => $this->warehouse]);

			$product_ids = array_map(function($row){ return $row["product_id"]; },$rows);
			Cache::Prepare("Product",$product_ids);

			$writer = new CsvWriter();
			
			foreach($rows as $row){
				$product = Cache::Get("Product",$row["product_id"]);
				$writer->addRow([
					"catalog_id" => $product->g("catalog_id"), // $product->getCatalogId() is not good for deleted products
					"stockcount" => $row["stockcount"],
					"unit" => (string)$product->getUnit(),
					"name" => $product->getName(),
				]);
			}

			$this->render_template = false;
			$this->response->setContentType($format == "xlsx" ? "application/vnd.ms-excel" : "text/csv");
			$this->response->setContentCharset("");
			$filename = String4::ToObject($this->warehouse->getName())->toAscii()->gsub('/\s+/',' ')->gsub('/[^a-zA-Z0-9\.-]/','_')->substr(0,60)->append(".$format")->toString();
			$this->response->setHeader("Content-disposition", "attachment; filename=\"{$filename}\"");
			$this->response->write($writer->writeToString(["with_header" => [_("Catalog number"),_("Stockcount"),_("Unit"),_("Product name")], "format" => $format]));
		}
	}

	function import(){
		$warehouse = $this->warehouse;
		$this->page_title = sprintf(_("Import entries from CSV into warehouse %s"),$warehouse->getName());

		$this->_save_return_uri();

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$reader = CsvReader::FromData($d["csv"]);

			if($reader->getColumnCount()<2){
				$this->form->set_error("csv",_("There must be at least 2 columns in the CSV data"));
				return;
			}
			
			$skipped = 0;
			$unchanged = 0;
			$created = 0;
			$updated = 0;
			$deleted = 0;

			$update_ary = [];

			$line = 0;
			foreach($reader->getAssociativeRows(["keys" => ["catalog_id","stockcount"]]) as $row){
				$line++;
				if(!is_numeric($row["stockcount"]) && $row["stockcount"]!==""){
					if($line==1){ continue; } // perhaps header
					$this->form->set_error("csv",sprintf(_("Line %s: the second value must be a numeric value"),$line));
					return;
				}
				$product = Product::GetInstanceByCatalogId($row["catalog_id"]);
				if(!$product){
					if($d["ignore_unknown_products"]){ $skipped++; continue; }
					$this->form->set_error("csv",sprintf(_("Line %s: product %s was not found"),$line,h($row["catalog_id"])));
					return;
				}

				$update_ary[$product->getId()] = $row["stockcount"];
			}

			$existing_ary = $this->dbmole->selectIntoAssociativeArray("SELECT product_id, stockcount FROM warehouse_items WHERE warehouse_id=:warehouse_id",[":warehouse_id" => $warehouse]);

			foreach($update_ary as $product_id => $stockcount){
				if(isset($existing_ary[$product_id]) && $existing_ary[$product_id]==$stockcount){
					unset($existing_ary[$product_id]);
					$unchanged++;
					continue;
				}
				if($stockcount===""){
					if(isset($existing_ary[$product_id])){
						unset($existing_ary[$product_id]);
						$wi = WarehouseItem::FindFirst("warehouse_id",$warehouse,"product_id",$product_id);
						$wi->destroy();
						$deleted++;
					}
					continue;
				}
				if(isset($existing_ary[$product_id])){
					unset($existing_ary[$product_id]);
					$wi = WarehouseItem::FindFirst("warehouse_id",$warehouse,"product_id",$product_id);
					$wi->s("stockcount",$stockcount);
					$updated++;
					continue;
				}
				WarehouseItem::CreateNewRecord([
					"warehouse_id" => $warehouse,
					"product_id" => $product_id,
					"stockcount" => $stockcount,
				]);
				$created++;
			}

			if($d["delete_unlisted_entries"]){
				foreach(array_keys($existing_ary) as $product_id){
					$this->dbmole->doQuery("DELETE FROM warehouse_items WHERE warehouse_id=:warehouse AND product_id=:product_id",[":warehouse" => $warehouse, ":product_id" => $product_id]);
					$deleted++;
				}
			}

			$this->flash->success(_("The import was completed successfully")."<ul><li>".join("</li><li>",[
				sprintf(_("entries imported: %s"),$created + $updated),
				sprintf(_("entries unchanged: %s"),$unchanged),
				sprintf(_("entries deleted: %s"),$deleted),
				// sprintf(_("entries skipped: %s"),$skipped) // may be confusing
			])."</li></ul>");

			$this->_redirect_back();
		}
	}

	function _before_filter(){
		$warehouse = null;

		if(in_array($this->action,["index","create_new","export","import"])){
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
