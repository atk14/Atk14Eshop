<?php
class SpecialOpeningHoursController extends AdminController {

	function index(){
		$this->page_title = sprintf(_("Mimořádná otevírací doba pro prodejnu %s"),$this->store->getName());

		$conditions = $bind_ar = [];

		$conditions[] = "store_id=:store";
		$bind_ar[":store"] = $this->store;

		$this->sorting->add("date",["reverse" => true]);

		$this->tpl_data["finder"] = SpecialOpeningHour::Finder([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => $this->sorting,
		]);
	}

	function create_new(){
		$store = $this->store;
		$form = $this->form;

		$this->_create_new([
			"page_title" => sprintf(_("Vytvoření mimořádné otevírací doby pro prodejnu %s"),$this->store->getName()),
			"create_closure" => function($d) use($store,$form){
				if(SpecialOpeningHour::FindFirst("store_id",$store,"date",$d["date"])){
					$form->set_error("date",_("Pro tento datum již záznam existuje"));
					return;
				}
				$d["store_id"] = $store;
				return SpecialOpeningHour::CreateNewRecord($d);
			}
		]);
	}

	function edit(){
		$this->_edit([
			"page_title" => _("Editace mimořádné otevírací doby"),
		]);
	}

	function destroy(){
		$this->_destroy();
	}

	function _before_filter(){
		$store = null;
		if(in_array($this->action,["index","create_new"])){
			$store = $this->_find("store","store_id");
		}
		if(in_array($this->action,["edit"])){
			$soh = $this->_find("special_opening_hour");
			$soh && ($store = $soh->getStore());
		}

		if($store){
			$this->breadcrumbs[] = ["$store",$this->_link_to(["action" => "stores/edit", "id" => $store])];
			$this->breadcrumbs[] = [_("Mimořádná otevírací doba"),$this->_link_to(["action" => "special_opening_hours/index", "store_id" => $store])];
		}
	}
}
