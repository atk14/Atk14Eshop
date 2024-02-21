<?php
!defined("ORDER_NO_OFFSET") && define("ORDER_NO_OFFSET","0");

class Order extends BasketOrOrder {

	static function CreateNewRecord($values,$options = []){
		global $ATK14_GLOBAL;
		$values += [
			"id" => Order::GetNextId(),
			"region_id" => Region::GetDefaultRegion()->getId(),
			//
			"order_no" => null,
			//
			"order_status_id" => OrderStatus::FindByCode("new"),
			"order_status_set_at" => now(),
			"order_status_set_by_user_id" => null,
		];

		$region = Cache::Get("Region",$values["region_id"]);

		if(is_null($values["order_no"])){
			$values["order_no"] = self::_CalcOrderNo($values["id"]);
		}

		$values += [
			//"language" => $region->getDefaultLanguage(),
			"language" => $ATK14_GLOBAL->getLang(),
		];

		$out = parent::CreateNewRecord($values,$options);
		$out->createOrderHistoryItem($out);
		return $out;
	}

	static function _CalcOrderNo($id){
		$order_no = ORDER_NO_OFFSET + $id * 10;
		$checksum = $order_no;
		while($checksum>=10){
			$checksum = $checksum % 10 + floor($checksum / 10.0);
		}
		$order_no += $checksum;
		return $order_no;
	}

	function getOrderItems() {
		return OrderItem::FindAll("order_id", $this);
	}

	function getItems() {
		return $this->getOrderItems();
	}

	function getTotalPrice($incl_vat = false,$options = array()){
		$options += array(
			"consider_shipping_fee" => true, // poplatek za dopravu a platbu
		);

		$price = 0.0;
		$price += $this->getItemsPrice($incl_vat);

		if($options["consider_shipping_fee"]){
			$price += $this->getPaymentFee($incl_vat);
			$price += $this->getDeliveryFee($incl_vat);
		}

		return $price;
	}

	function getTotalPriceInclVat($options = array()){
		return $this->getTotalPrice(true,$options);
	}

	function getPaymentFee($incl_vat = false){
		$fee = $this->getPaymentFeeInclVat();
		if(!$incl_vat){
			$fee = $this->_delVat($fee,$this->getPaymentFeeVatPercent());
		}
		return $fee;
	}

	/**
	 * Returns the most recent payment transaction of the order
	 */
	function getPaymentTransaction(){
		return PaymentTransaction::FindFirst("order_id",$this,["order_by" => "
			(payment_status_id IS NOT NULL AND payment_status_id=(SELECT id FROM payment_statuses WHERE code='paid')) DESC,
			rank DESC
		"]);
	}

	function getPaymentTransactionStartUrl(){
		if(!$this->getPaymentTransaction()){
			return;
		}
		return Atk14Url::BuildLink([
			"namespace" => "",
			"action" => "payment_transactions/start",
			"order_token" => $this->getToken(["extra_salt" => "payment_transaction_start", "hash_length" => 10]),
		],[
			"with_hostname" => true,
			"ssl" => REDIRECT_TO_SSL_AUTOMATICALLY,
		]);
	}

	function getDeliveryFee($incl_vat = false){
		$fee = $this->getDeliveryFeeInclVat();
		if(!$incl_vat){
			$fee = $this->_delVat($fee,$this->getDeliveryFeeVatPercent());
		}
		return $fee;
	}

	/**
	 *
	 *	$order->increasePricePaid(10.0);
	 * 	$order->increasePricePaid(22.2);
	 *	echo $order->getPricePaid(); // 33.2
	 */
	function increasePricePaid($price){
		$price = (float)$price;
		$this->dbmole->doQuery("UPDATE orders SET price_paid=COALESCE(price_paid,0.0)+:price WHERE id=:order",[":price" => $price,":order" => $this]);
		$this->_readValues();
	}

	function getPhone(){
		if($phone = $this->g("phone")){
			return $phone;
		}
		if($user = $this->getUser()){
			return $user->getPhone();
		}
	}

	function getPhones() {
		$out = [$this->getPhone(),$this->getDeliveryPhone()];
		$out = array_filter($out);
		$out = array_unique($out);
		$out = array_values($out);
		return $out;
	}

	/**
	 * @param User|integer $user
	 */
	function belongsToUser($user) {
		$user = User::FindById($user);
		return !is_null($user) && ($user->getId()==$this->getUserId());
	}

	private function _getAddressFields() {
		return array(
			"firstname",
			"lastname",
			"company",
			"address_street",
			"address_street2",
			"address_city",
			"address_state",
			"address_zip",
			"address_country",
			"address_note",
			"phone",
		);
	}

	function getDeliveryAddress() {
		foreach($this->_getAddressFields() as $k) {
			$address[$k] = $this->g("delivery_$k");
		}
		return $address;
	}

	function getInvoiceAddress() {
		foreach($this->_getAddressFields() as $k) {
			$address[$k] = $this->g($k);
		}
		return $address;
	}

	function getTaxNumber() {
		return $this->g("vat_id");
	}

	function hasCompanyDataSet() {
		return !!(
			trim((string)$this->getCompany()).
			trim((string)$this->getCompanyNumber()).
			trim((string)$this->getTaxNumber())
		);
	}

	function hasDeliveryAddressSet() {
		return strlen(trim(implode($this->getDeliveryAddress())))>0;
	}

	function getInvoiceCompany() {
		return $this->getCompany();
	}

	function getInvoiceName() {
		return trim(sprintf("%s %s", $this->g("firstname"), $this->g("lastname")));
	}

	function getInvoiceStreet() {
		return $this->getAddressStreet();
	}

	function getInvoiceStreet2() {
		return $this->getAddressStreet2();
	}

	function getInvoiceCity() {
		return $this->getAddressCity();
	}

	function getInvoiceState() {
		return $this->getAddressState();
	}

	function getInvoiceZip() {
		return $this->getAddressZip();
	}

	function getInvoiceCountry() {
		return $this->getAddressCountry();
	}

	function getDeliveryName() {
		return trim(sprintf("%s %s", $this->g("delivery_firstname"), $this->g("delivery_lastname")));
	}

	/**
	 *
	 *	$history_items = $order->getOrderItems();
	 *	echo $history_items[0]->getCode(); // "new"
	 *
	 * 	$history_items = $order->getOrderItems(["reverse" => true]);
	 *	echo $history_items[0]->getCode(); // "delivered"
	 */
	function getOrderHistory($options = array()) {
		$options += array(
			"limit" => null,
			"reverse" => false,
			"order_by" => null,
		);

		if(is_null($options["order_by"])){
			$options["order_by"] = $options["reverse"] ? "order_status_set_at DESC, id DESC" : "order_status_set_at ASC, id ASC";
		}
		unset($options["reverse"]);

		return OrderHistory::FindAll("order_id", $this, $options);
	}

	/**
	 * Returns current order status
	 */
	function getOrderStatus(){
		return Cache::Get("OrderStatus",$this->getOrderStatusId());
	}

	function getCurrentOrderStatus() {
		return $this->getOrderStatus();
	}

	function getCurrentStatus() {
		return $this->getOrderStatus();
	}

	function getPreviousStatus() {
		return $this->getPreviousOrderStatus();
	}

	function getPreviousOrderStatus() {
		$history = $this->getOrderHistory(array("limit" => 1, "offset" => 1, "reverse" => true));
		if(!$history){ return; }
		$history_item = array_pop($history);
		return $history_item->getOrderStatus();
	}

	function getResponsibleUser() {
		return Cache::Get("User",$this->g("responsible_user_id"));
	}

	/**
	 * Has the order given status or had it somewhere in the past
	 *
	 *	if($order->hasOrderStatus("payment_accepted")){ ... }
	 *	// or
	 *	if($order->hasOrderStatus(1){ ... }
	 *	if($order->hasOrderStatus(OrderStatus::GetInstanceByCode("new")){ ... }
	 */
	function hasOrderStatus($order_status){
		if(is_numeric($order_status)){
			$order_status = Cache::Get("OrderStatus",$order_status);
		}elseif(is_string($order_status)){
			$order_status = OrderStatus::GetInstanceByCode($order_status);
		}
		myAssert(is_a($order_status,"OrderStatus"));

		if($this->getOrderStatusId()==$order_status->getId()){
			return true;
		}
		foreach($this->getOrderHistory() as $oh){
			if($oh->getOrderStatusId()==$order_status->getId()){
				return true;
			}
		}
		return false;
	}

	function getAllowedNextOrderStatuses(){
		$current_status = $this->getOrderStatus();
		$payment_method = $this->getPaymentMethod();

		$out = [];
		foreach($this->getOrderStatus()->getAllowedNextOrderStatuses() as $os){
			$out[$os->getCode()] = $os;
		}

		if($payment_method->isCashOnDelivery()){
			unset($out["payment_accepted"]);
		}

		if($current_status->getCode()=="payment_accepted" && $this->hasOrderStatus("processing")){
			unset($out["processing"]);
		}

		return array_values($out);
	}

	/**
	 * Nastaveni noveho stavu objednavky.
	 *
	 * ```
	 * $this->setNewOrderStatus(array(
	 * 	"order_status_id" => 13,
	 * 	"order_status_set_by_user_id" => 1
	 * );
	 * ```
	 *
	 * ```
	 * $this->setNewOrderStatus("payment_accepted");
	 * ```
	 *
	 * ```
	 * $this->setNewOrderStatus(13);
	 * ```
	 *
	 * @param mixed $new_status_values
	 * @returns OrderStaus current order status
	 *
	 * POZOR, změny stavu se dozvídáme asynchronně a tedy nesetříděně dle času. Proto je někdy třeba
	 * "opravit budoucí historii". Typicky, když někdo nastavil responsible_user_id
	 * objednávce, které ještě z winshopu neprotekla změna stavu. Když pak
	 * proteče změna stavu, je třeba opravit stav i u události "změna responsible_user_id".
	 * Ale pozor, nesmí se "opravovat stavy" u následujících událostí změna stavu (např. platební
	 * brána nemění stav přes winshop, ale přímo, a tedy může změnit stav a winshop pak pošle stav
	 * neaktuální, který se pouze zařadí do historie)
	 *
	 * Tedy fce provádí:
	 * 1) Pokud jde o novejsi stav nez nejnovejsi, zmeni stav objednavky
	 * 2) Zapise zaznam do order_history_item
	 * 3) Zmeni vsechny nasledující stavy v order_history, které neměnily
	 *     stav (tedy zmeny responsible_user_id)
	 */
	function setNewOrderStatus($new_status_values=array(),$options = []) {
		global $ATK14_GLOBAL;
		$options += [
			"mailer" => null,
			"disable_notification" => false,
		];

		if (is_string($new_status_values)) {
			$new_status_values = array(
				"order_status_id" => OrderStatus::GetInstanceByCode($new_status_values),
			);
		} elseif (is_integer($new_status_values)) {
			$new_status_values = array(
				"order_status_id" => Cache::Get("OrderStatus",$new_status_values),
			);
		} elseif (is_object($new_status_values)) {
			$new_status_values = array(
				"order_status_id" => $new_status_values,
			);
		}

		$new_status = $new_status_values["order_status_id"];
		if(!is_object($new_status)){
			$new_status = Cache::Get("OrderStatus",$new_status);
		}

		$logged_user_id = ApplicationModel::_GetLoggedUserId();
		$logged_user = Cache::Get("User",$logged_user_id);

		$not_now = key_exists("order_status_set_at", $new_status_values);
		$new_status_values += [
			"order_status_set_at" => now(),
			"order_status_set_by_user_id" => $logged_user && $logged_user->isAdmin() && $ATK14_GLOBAL->getValue("namespace")=="admin" ? $logged_user : null,
			"order_status_note" => null,
		];

		# aby nedoslo k prepsani jine hodnoty v objednavce, ktera se netyka statusu
		$new_status_values = array_intersect_key($new_status_values, array_flip(array("order_status_id", "order_status_set_at", "order_status_set_by_user_id", "order_status_note")));

		$orig_status = $this->getOrderStatus();

		# cas nastaveni stavu aktualniho (v orders.order_status_set_at)
		$current_status_time = strtotime($this->getOrderStatusSetAt());
		# cas importovaneho stavu (pujde do order_history.order_status_set_at
		$new_status_time = strtotime($new_status_values["order_status_set_at"]);

		# novy stav chceme nastavit jen kdyz je cas v 'order_status_set_at' novejsi nez je u aktualniho stavu
		if ($new_status_time>=$current_status_time) {
			$this->s($new_status_values, array("set_update_time" => false));
		}
		$new_status_values['note'] = $new_status_values['order_status_note'];
		$new_status_values['change_responsible_user'] = false;
		$new_status_values['change_status'] = true;

		unset($new_status_values['order_status_note']);

		$history_item = $this->createOrderHistoryItem(
				$new_status_values
		);

		/** Pokud byly založené v historii záznamy se špatným stavem
			(např. nastavením responsible_user_id) opravíme je */
		$prevState = $history_item->getPrevious();
		if($prevState) {
			$i=$history_item->getNext();
			while($i && !$i->getChangeStatus() &&
				//tato kontrola není nutná, pokud je správně nastavený changeStatus,
				//ale pro jistotu
				$i->getOrderStatusId() == $prevState->getOrderStatusId()
			) {
				$i->s('order_status_id', $history_item->getOrderStatusId());
			}
		}

		$order_status = $this->getOrderStatus();
		if(!$options["disable_notification"] && $order_status && $order_status->notificationEnabled() && $order_status->getId()!=$orig_status->getId()){
			$mailer = $options["mailer"] ? $options["mailer"] : Atk14MailerProxy::GetInstance();
			$lang = $this->getLanguage();
			$prev_lang = Atk14Locale::Initialize($lang);
			$mailer->notify_order_status_update($this);
			Atk14Locale::Initialize($prev_lang);
		}

		$warehouse = Warehouse::GetDefaultInstance4Eshop();
		if($warehouse && $orig_status->getId()!=$new_status->getId()){
			if(!$orig_status->reduceStockcount() && $new_status->reduceStockcount()){
				$this->_updateWarehouseItems($warehouse,-1);
			}
			if($orig_status->reduceStockcount() && !$new_status->reduceStockcount()){
				$this->_updateWarehouseItems($warehouse,1);
			}
		}

		return $order_status;
	}

	function _updateWarehouseItems($warehouse,$multiplier = 1){
		foreach($this->getItems() as $item){
			$warehouse->addProduct($item->getProduct(),$multiplier * $item->getAmount());
		}
	}

	/**
	 * Vytvori zaznam v order_history. Hodnoty, ktere nedostane, si vytahne
	 * z te same tabulky (z "nejnovejsiho starsiho zaznamu")
	 */
	function createOrderHistoryItem( $values = null) {
		if( $values === null ) {
			$values = $this;
		}
		if( $values instanceof Order ) {
			$values = [
				"order_id" => $values,
				"order_status_set_at" => $values->getOrderStatusSetAt(),
				"order_status_set_by_user_id" => $values->getOrderStatusSetByUserId(),
				"note" => $values->getOrderStatusNote(),
				"order_status_id" => $values->getOrderStatusId(),
				"responsible_user_id" => $values->getResponsibleUserId(),
				"change_responsible_user" => true,
				"change_status" => true,
			];
		} else {
			$values += [
				"order_id" => $this,
				"order_status_set_at" => now(),
				"order_status_set_by_user_id" => ApplicationModel::_GetLoggedUserId(),
				"note" => '',
			];
			$ovalues = $this->dbmole->selectRow('SELECT
							order_status_id, responsible_user_id
							FROM order_history WHERE order_id = :id AND order_status_set_at <= :at
							ORDER BY order_status_set_at DESC LIMIT 1
							', [
								':id' => $values['order_id'],
								':at' => $values['order_status_set_at'],
			]);
			if ($ovalues) {
				$values+=$ovalues;
			}
		}
		$order_history = OrderHistory::CreateNewRecord($values);
		return $order_history;
	}

	function isPaid(){
		$current_status = $this->getOrderStatus();
		$payment_method = $this->getPaymentMethod();

		foreach($this->getOrderHistory(["reverse" => true]) as $oh){
			$status = $oh->getOrderStatus();
			if(in_array($status->getCode(),OrderStatus::$Codes_Paid)){
				return true;
			}
			if(in_array($status->getCode(),OrderStatus::$Codes_NotPaid)){
				return false;
			}
			if($payment_method->isCashOnDelivery() && ($status->getCode()=="delivered")){
				return true;
			}
		}
		if($order_status = $this->getOrderStatus()){
			if(in_array($order_status->getCode(),OrderStatus::$Codes_Paid)){
				return true;
			}
		}

		$cnt = $this->dbmole->selectInt("
			SELECT COUNT(*) FROM (
				SELECT id FROM order_history WHERE order_id=:id AND order_status_id IN (SELECT id FROM order_statuses WHERE code IN :codes)
				UNION
				SELECT id FROM payment_transactions WHERE order_id=:id AND payment_status_id=(SELECT id FROM payment_statuses WHERE code=:payment_status_paid)
			)q
		",[
			":id" => $this,
			":codes" => OrderStatus::$Codes_Paid,
			":payment_status_paid" => "paid",
		]);
		return $cnt>0;
	}

	/**
	 * Muze dojit k plneni objednavky?
	 *
	 * Toto je uzitecny test pro objednavky digitalnich produktu.
	 */
	function canBeFulfilled(){
		$current_status = $this->getCurrentStatus();
		$payment_method = $this->getPaymentMethod();
		if(!$payment_method->isCashOnDelivery() && $current_status->finishedSuccessfully()){
			return true;
		}
		if($payment_method->isCashOnDelivery() && (in_array($current_status->getCode(),[
			"delivered",
			"finished_successfully"
		]))){
			return true;
		}
		if($current_status->finishedUnsuccessfully() || $current_status->isFinishingUnsuccessfully()){
			return false;
		}

		return $this->getPriceToPay()===0.0 || $this->isPaid();
	}

	/**
	 * Nastavi responsibleUserId a zaradi patricny zaznam do tabulky order_history
	 */
	function setResponsibleUser( $user, $options = [] ) {
		$options += [
			'order_status_set_at' => now() //!!!PRO TESTY - nastaveni responsible
																		 //person v minulosti (mezi statusy) NENI
																     //implementovano
		];
		$this->s('responsible_user_id', $user);
		$this->createOrderHistoryItem([
			'responsible_user_id' => $user,
			'change_status' => false,
			'change_responsible_user' => true,
			'order_status_set_at' => $options['order_status_set_at'],
		]);
	}

	function getOrderStatusSetByUser(){
		return Cache::Get("User",$this->getOrderStatusSetByUserId());
	}

	function getVouchers() {
		return OrderVoucher::FindAll("order_id",$this,["use_cache" => true]);
	}

	function getCampaigns() {
		return OrderCampaign::FindAll("order_id",$this,["use_cache" => true]);
	}

	function getUpdatedByUser(){
		return Cache::Get("User",$this->getUpdatedByUserId());
	}

	function recalculatePriceToPay(){
		Cache::Clear();

		$items = $this->getItems();
		$currency = $this->getCurrency();
		$incl_vat = !$this->g("without_vat");
		$delta_product = Product::FindByCode("price_rounding");

		$current_delta_item = null;
		$is_delta_item_last = false;
		foreach($items as $item){
			$is_delta_item_last = false;
			if($item->getProduct()->getCode()=="price_rounding"){
				$current_delta_item = $item;
				$is_delta_item_last = true;
			}
		}

		$price = $this->getItemsPriceInclVat();
		$price += $this->getDeliveryFeeInclVat();
		$price += $this->getPaymentFeeInclVat();
		$price -= $this->getVouchersDiscountAmount();
		$price -= $this->getCampaignsDiscountAmount();
		if($current_delta_item){
			$price -= $current_delta_item->getPriceInclVat();
		}

		if($price<0.0){
			$price = 0.0;
		}

		$price_without_rounding = $price;
		$price = round($price,$this->getCurrencyDecimalsSummary());

		$delta = $price - $price_without_rounding;
		$delta = $currency->roundPrice($delta);
		if(abs($delta)<$currency->getLowestPrice()){
			$delta = 0.0;
		}

		if($delta==0.0){
			if($current_delta_item){
				$current_delta_item->destroy();
				Cache::Clear();
			}
		}else{
			$amount = $delta > 0.0 ? 1 : -1;
			$delta_vat_percent = $incl_vat ? $delta_product->getVatPercent() : 0.0;
			$delta_price = abs($delta);
			$delta_price_with_no_vat = ($delta_price / (100.0 + $delta_vat_percent)) * 100.0;
			$delta_price_with_no_vat = round($delta_price_with_no_vat,4);
			$delta_values = [
				"order_id" => $this->getId(),
				"product_id" => $delta_product,
				"amount" => $delta > 0.0 ? 1 : -1,
				"unit_price_incl_vat" => $delta_price,
				"vat_percent" => $delta_vat_percent,
			];

			if(!$current_delta_item){
				$current_delta_item = OrderItem::CreateNewRecord($delta_values);
			}else{
				if(
					$current_delta_item->g("amount")!=$delta_values["amount"] ||
					$current_delta_item->getUnitPriceInclVat()!=$delta_values["unit_price_incl_vat"] ||
					$current_delta_item->g("vat_percent")!=$delta_values["vat_percent"]
				){
					$current_delta_item->s($delta_values);
					Cache::Clear();
				}
				if(!$is_delta_item_last){
					$current_delta_item->setRank(sizeof($items)-1);
					Cache::Clear();
				}
			}
		}

		if($price!=$this->getPriceToPay()){
			$this->s("price_to_pay",$price);
			return true;
		}

		return false;
	}

	function getDeliveryMethodData($options = []){
		if(!is_array($options)){
			$options = ["as_json" => $options];
		}
		$options += [
			"as_json" => false,
		];

		$json = $this->g("delivery_method_data");
		if(!$json){ return null; }

		$data = json_decode($json,true);
		if(!$data){ return null; }

		return $options["as_json"] ? $json : $data;
	}

	function getTrackingUrl() {
		if (($tracking_number = $this->getTrackingNumber()) && ($dm = $this->getDeliveryMethod()) && ($url = $dm->getTrackingUrl())) {
			return str_replace("@", urlencode($tracking_number), $url);
		}
		return null;
	}

	function getAllNotes() {
		$notesAr = [
			trim((string)$this->getNote()),
			($dan = trim((string)$this->getDeliveryAddressNote())) ? sprintf(_("Poznámka k doručovací adrese: %s"), $dan) : null,
			($an = trim((string)$this->getAddressNote())) ? sprintf(_("Poznámka k fakturační adrese: %s"), $an) : null,
		];
		return array_filter($notesAr);
	}

	function hasDigitalContents(){
		return !!DigitalContent::GetInstancesByOrder($this);
	}

	function getBankAccount(){
		$region = $this->getRegion();
		$currency = $this->getCurrency();
		foreach(BankAccount::FindAll([
			"conditions" => "active AND (regions->>:region)::BOOLEAN",
			"bind_ar" => [":region" => $region->getCode()],
		]) as $ba){
			if(in_array($currency->getCode(),json_decode($ba->g("currencies"),true))){
				return $ba;
			}
		}

		// Fallback
		return BankAccount::GetInstanceByCode("default");
	}

	/**
	 * Pruchod vsemi zaznamy csv
	 */
	static function ImportTrackingInfoCsvFile(CsvImport $import, $options=[]) {
		$options += [
			"service" => null,
		];
		$column_names = [
			"default" => [
				"order_no" => "var_symbol",
				"tracking_no" => "cislo_zasilky",
			],
			"geis" => [
				"order_no" => "referenční číslo",
				"tracking_no" => "číslo zásilky",
			],
		];
		$service = $options["service"];
		$column_order_no = $column_names["default"]["order_no"];
		$column_tracking_no = $column_names["default"]["tracking_no"];

		if (array_key_exists($service, $column_names)) {
			$column_order_no = $column_names[$service]["order_no"];
			$column_tracking_no = $column_names[$service]["tracking_no"];
		}
		$imported = $not_imported_messages = [];
		foreach($import->associative() as $idx => $row) {
			$order_no = $row[$column_order_no];
			$tracking_no = $row[$column_tracking_no];

			$error_found = false;
			if (!$order_no) {
				$not_imported_ar[] = [
					"tracking_number" => $tracking_no,
					"order_no" => $order_no,
					"message" => _("Chybí číslo objednávky"),
					"line_no" => $idx+1,
				];
				$error_found = true;
			}
			$order = Order::FindFirst("order_no", $order_no);
			if (!$order) {
				$not_imported_messages[] = [
					"tracking_number" => $tracking_no,
					"order_no" => $order_no,
					"message" => _("Objednávka nebyla nalezena v systému"),
					"line_no" => $idx+1,
				];
				$error_found = true;
			}
			if ($error_found) {
				continue;
			}
			$_res = $order->_set_tracking_info($tracking_no, ["line_no" => $idx, "service" => $service], $imported, $not_imported_messages);
			if ($_res === false) {
				$not_imported_messages[sizeof($not_imported_messages)-1]["line_no"] = ($idx+1);
			}
		}
		return [$imported, $not_imported_messages];
	}

	protected function _set_tracking_info($tracking_no, $params, &$imported_ar, &$not_imported_ar) {
		$service_tracking_number_regexp = [
			"cp" => "^[A-Z]{2}[0-9]{9,}[A-Z]?$",
			"ppl" => "^[0-9]{11,}$",
			"geis" => "^[0-9]{10,}$",
		];
		$params += [
			"line_no" => null,
			"service" => null,
		];
		$line_no = $params["line_no"];

		$line_no++;
		$error_found = false;
		if (!$tracking_no) {
			$not_imported_ar[] = [
				"tracking_number" => $tracking_no,
				"order_no" => null,
				"message" => _("Chybí číslo zásilky"),
				"line_no" => $line_no,
			];
			$error_found = true;
		}
		$re = $service_tracking_number_regexp[$params["service"]];
		if (!preg_match("/$re/", $tracking_no)) {
			$not_imported_ar[] = [
				"tracking_number" => $tracking_no,
				"order_no" => null,
				"message" => sprintf(_("Hodnota %s nevypadá jako číslo zásilky"), $tracking_no),
				"line_no" => $line_no,
			];
			$error_found = true;
		}

		# nemame ani cislo objednavky ani sledovaci cislo
		# nema smysl pokracovat
		if ($error_found) {
			return false;
		}

		if ($this->getTrackingNumber()) {
			$not_imported_ar[] = [
				"tracking_number" => $tracking_no,
				"order_no" => $this->getOrderNo(),
				"message" => _("Zásilka již byla importovaná"),
				"line_no" => $line_no,
			];
			$error_found = true;
			return false;
		}

		$this->s("tracking_number", $tracking_no);

		# znovu nactu objednavku,
		# jinak zmena stavu vynuti odeslani emailu a mailer nebude mit cerstve hodnoty v objednavce (konkretne tracking_number)
		$order = Order::FindFirst("order_no", $this->getOrderNo(), ["use_cache" => false]);
		$order->setNewOrderStatus("shipped");
		$imported_ar[] = $order;

		return !$error_found;
	}
}
