<?php
class OrdersController extends AdminController {

	function index(){
		$this->page_title = _("Seznam objednávek");

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$conditions = $bind_ar = array();

		if($d["date_from"]){
			$conditions[] = "created_at >= :date_from ";
			$bind_ar[":date_from"] = $d["date_from"];
		}

		if($d["date_to"]){
			$conditions[] = "created_at < :date_to::date + 1 ";
			$bind_ar[":date_to"] = $d["date_to"];
		}

		if ($d["order_status"]) {
			if($d["order_status"]=="in_progress"){
				$conditions[] = "order_status_id IN (SELECT id FROM order_statuses WHERE NOT (finished_successfully	OR finished_unsuccessfully OR finishing_successfully OR finishing_unsuccessfully))";
			}else{
				$conditions[] = "order_status_id=:order_status_id";
				$bind_ar[":order_status_id"] = $d["order_status"];
			}
		}

		if ($d["delivery_method_id"]) {
			$conditions[] = "delivery_method_id=:delivery_method_id";
			$bind_ar[":delivery_method_id"] = $d["delivery_method_id"];
		}

		if ($d["payment_method_id"]) {
			$conditions[] = "payment_method_id=:payment_method_id";
			$bind_ar[":payment_method_id"] = $d["payment_method_id"];
		}

		if(trim($d['catalog_id'])) {
			$conditions[] = "id IN (select order_id from order_items WHERE product_id IN
				(SELECT id FROM products WHERE catalog_id LIKE :catalog_id))";
			$bind_ar[':catalog_id'] = "%".trim($d['catalog_id'])."%";
		}

		if ($d["payment_status_id"]) {
			$conditions[] = "id IN (SELECT order_id FROM payment_transactions WHERE payment_status_id=:payment_status_id)";
			$bind_ar[":payment_status_id"] = $d["payment_status_id"];
		}

		if($d["search"]){
			$search = Translate::Upper($d["search"]);

			$_ar = array();
			foreach(array(
				//"CAST(id AS TEXT)",
				"order_no",
				"company",
				"company_number",
				"vat_id",
				"firstname",
				"lastname",
				"email",
				"address_street",
				"address_street2",
				"address_city",
				"address_state",
				"address_zip",
				"address_country",
				"address_note",
				"phone",
				"note",
				"(SELECT string_agg(voucher_code, ' ') FROM vouchers v , order_vouchers ov WHERE ov.voucher_id=v.id AND ov.order_id= orders.id)",
				"(SELECT login FROM users WHERE id=orders.user_id)",
			) as $f){
				$_ar[] = "COALESCE($f,'')";
			}

			$condition = FullTextSearchQueryLike::GetQuery("UPPER(".join("||' '||",$_ar).")",$search,$bind_ar);

			if($condition){
				$conditions[] = $condition;
				$this->sorting->add("search","order_no LIKE :search||'%' DESC, created_at DESC");
				$bind_ar[":search"] = $search;
			}
		}

		$this->_initialize_prepared_sorting("created_at");
		$this->sorting->add("updated_at","COALESCE(GREATEST(updated_at,order_status_set_at),order_status_set_at) DESC","COALESCE(GREATEST(updated_at,order_status_set_at),order_status_set_at) ASC");
		$this->sorting->add("order_no");

		$this->tpl_data["finder"] = Order::Finder(array(
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"offset" => $this->params->getInt("offset"),
			"order" => $this->sorting,
			"offset" => $this->params->getInt("offset"),
		));
	}

	function detail(){
		$order = $this->order;
		$this->page_title = sprintf(_("Objednávka %s"),$order->getOrderNo());

		if($vat_id = $order->getVatId()){
			$vies = new MyVies();
			$vat_id = $vies->filterVat($vat_id);
			$countryCode = substr($vat_id,0,2);
			$vatNumber = substr($vat_id,2);


			$country = new Country($countryCode);
			if($country->isEuCountry() && !$country->isCzechRepublic()){
				$this->tpl_data["show_cross_border_transactions_within_eu_info"] = true;
				$this->tpl_data["vat_id_validation_url"] = "http://ec.europa.eu/taxation_customs/vies/vatResponse.html?memberStateCode=".urlencode($countryCode)."&number=".urlencode($vatNumber)."&traderName=&traderStreet=&traderPostalCode=&traderCity=&requesterMemberStateCode=&requesterNumber=&action=check&check=Verify";
			}
		}

		$has_digital_contents = $this->tpl_data["has_digital_contents"] = !!DigitalContent::GetInstancesByOrder($order);
		if($has_digital_contents){
			$this->tpl_data["digital_contents_url"] = $order->canBeFulfilled() ? $this->_link_to(["namespace" => "", "action" => "digital_contents/index", "order_token" => $order->getToken(DigitalContent::GetOrderTokenOptions())],["with_hostname" => $order->getRegion()->getDefaultDomain(), "ssl" => PRODUCTION]) : null;
		}

		$this->tpl_data["ordered_vouchers"] = Voucher::FindAll([
			"conditions" => "originator_order_item_id IN (SELECT id FROM order_items WHERE order_id=:order)",
			"bind_ar" => [":order" => $order],
			"order_by" => "id ASC",
		]);
	}

	function edit(){
		$order = $this->order;

		$this->breadcrumbs[] = [
			sprintf("Objednávka %s",$order->getOrderNo()),
			$this->_link_to(["action" => "detail", "id" => $order]),
		];

		$this->_edit([
			"page_title" => sprintf(_("Editace objednávky %s"),$order->getOrderNo()),
			"update_closure" => function($order,$d){
				$ret = $order->s($d);
				$order->recalculatePriceToPay();
				return $ret;
			}
		]);
	}

	function set_responsible_user() {
		$this->_save_return_uri();

		$this->page_title = _("Zodpovědná osoba");
		$this->form->set_initial($this->order);

		if ($this->request->post() && ($d=$this->form->validate($this->params))) {
			$this->order->setResponsibleUser($d["responsible_user_id"]);
			$this->flash->success(_("Zodpovědná osoba nastavena"));
			return $this->_redirect_back();
		}
	}

	/**
	 * Import cisel zasilek pro sledovani.
	 */
	function import_tracking_numbers() {
		$this->page_title = _("Import čísel pro sledování zásilek");
		if ($this->request->post() && ($d=$this->form->validate($this->params))) {

			$content = "";
			# soubor od ceske posty neobsahuje zahlavi, tak si ho nafejkujeme
			if ($d["service"] == "cp") {
				$_fields_count = $this->_get_csv_fields_count($d["csv_file"]->getTmpFilename());
				$additional_header_cp = [];
				for($i=0;$i<$_fields_count;$i++) {
					$additional_header_cp[] = "field_${i}";
				}
				$additional_header_cp[0] = "cislo_zasilky";
				$additional_header_cp[22] = "var_symbol";
				$content = join(";", $additional_header_cp)."\n";
			}

			$content .= file_get_contents($d["csv_file"]->getTmpFilename());
			$import = CsvImport::FromData($content, ["check_fields_count" => false]);
			if ($import->hasError()) {
				foreach($import->getError() as $_err) {
					$k = key($_err);
					$this->flash->error($_err[$k]);
				}
				return;
			}

			list($imported, $not_imported) = Order::ImportTrackingInfoCsvFile($import, ["service" => $d["service"]]);
			$d["csv_file"]->cleanup();
			if (is_null($imported) && is_null($not_imported)) {
				$this->flash->error(_("Chybná data v souboru"));
				return;
			}
			$this->tpl_data["imported_packets"] = $imported;
			$this->tpl_data["not_imported_packets"] = $not_imported;

			if ($imported) {
				$this->flash->success(_("Zásilky byly naimportovány"));
			}
		}
	}


	/**
	 * Vrati pocet poli na radku
	 *
	 * Pouziva se pro Ceskou Postu. Obcas dostaneme soubor s ruznym poctem poli.
	 * Asi proto, ze nektere hodnoty na konci radku nejsou vyplnene,
	 * tak pri exportu souboru z Ceske Posty dojde ke zkraceni.
	 */
	protected function _get_csv_fields_count($csv_filename) {
		$_csv_import = CsvImport::FromFile($csv_filename, ["read_header" => false]);
		$_row = $_csv_import[0];
		return sizeof($_row);
	}

	function _before_filter() {
		if (in_array($this->action, array("detail","edit","set_responsible_user"))) {
			$this->_find("order");
		}
	}
}
