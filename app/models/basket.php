<?php
class Basket extends BasketOrOrder {

	const ID_DUMMY = 1;

	protected $basket_items;

	static function CreateNewRecord($values,$options = []){
		$values += [
			"user_id" => null,
			"region_id" => Region::GetDefaultRegion(),
			"currency_id" => null,
		];

		$region = is_object($values["region_id"]) ? $values["region_id"] : Cache::Get("Region",$values["region_id"]);

		if(is_null($values["currency_id"])){
			$values["currency_id"] = $region->getDefaultCurrency();
		}

		if(!is_null($values["user_id"])){
			$user = User::FindById($values["user_id"]);
			$values["email"] = $user->g("email");

			// !! Fakturacni adresa nastavime, kdyz ma uzivatel vyplnene IC nebo DIC
			if($user->g("vat_id") || $user->g("company_number")){
				foreach(self::GetAddressFields(["company_data" => true, "phone" => false]) as $k => $req){
					$values["$k"] = $user->g("$k");
				}
			}

			// Dorucovaci adresa
			if($da = DeliveryAddress::GetMostRecentRecord($user,$region)){
				foreach(self::GetAddressFields(["phone" => true, "note" => true]) as $k => $req){
					$values["delivery_$k"] = $da->g("$k");
				}
			}else{
				foreach(self::GetAddressFields(["phone" => true, "note" => false]) as $k => $req){
					$values["delivery_$k"] = $user->g("$k");
				}
			}
		}

		return parent::CreateNewRecord($values,$options);
	}

	static function GetDummyBasket($region = null){
		if(!$region){ $region = Region::GetDefaultRegion(); }
		$basket = Cache::Get("Basket",self::ID_DUMMY);

		$out = clone($basket);
		$out->setValuesVirtually([
			"region_id" => $region->getId(),
			"currency_id" => $region->getDefaultCurrency()->getId()
		]);

		return $out;
	}

	function isDummy(){
		return $this->getId()==self::ID_DUMMY;
	}

	function getUser(){
		return Cache::Get("User",$this->getUserId());
	}

	function getRegion(){
		return Cache::Get("Region",$this->getRegionId());
	}

	function getBasketItems(){
		if(is_null($this->basket_items)){
			$this->basket_items = new BasketItems($this);
		}
		return $this->basket_items;
	}

	function getItems(){
		return $this->getBasketItems();
	}

	function isEmpty(){
		return sizeof($this->getBasketItems())==0;
	}

	function getPriceFinder(){
		return PriceFinder::GetInstance($this->getUser(),$this->getCurrency());
	}

	function setProductAmount($product,$amount = 1,$options = array()){
		$options += [ 'update_rank' => false ];
		return $this->addProduct($product, $amount, $options);
	}

	/**
	 * Prida produkt do kosiku. Pokud uz tam je, nastavit pocet na $amount.
	 * Dana pokozka bude prvni v poradi.
	 *
	 * $basket->addProduct($product); // 1ks
	 * $basket->addProduct($product,10);
	 * $basket->addProduct($product,0); // smazani produktu z kosiku
	 */
	function addProduct($product,$amount = 1,$options = array()){
		if($this->isDummy()){ return; }

		$bi = $this->basket_items;
		$this->basket_items = null; // vynulovani cache

		$options += array(
			"update_rank" => true, // private stuff
		);

		if(!$amount) {
			$item = BasketItem::FindFirst("basket_id",$this,"product_id",$product,array("use_cache" => true));
			if($item) {
				$item->destroy();
			}
			return;
		}
		if($bi) {
			$bi = array_map(function($v) {return $v->getId();}, iterator_to_array($bi));
		}
		Cache::Clear("BasketItem", $bi);

		$bind_ar = array(
			":basket_id" => $this->getId(),
			":product_id" => $product->getId(),
			":amount" => $amount,
		);

		$update_sql="UPDATE basket_items SET amount = :amount WHERE basket_id = :basket_id AND product_id = :product_id ";
		$sql = "DO $$ BEGIN
			WITH updated AS ($update_sql RETURNING id)
			INSERT INTO basket_items(id, basket_id, product_id, amount)
				 SELECT NEXTVAL('seq_basket_items'), :basket_id, :product_id, :amount
				 WHERE (SELECT COUNT(*) FROM updated) = 0;
			EXCEPTION WHEN unique_violation THEN
			   $update_sql;
			END $$;
		";
		$this->dbmole->doQuery($sql, $bind_ar);
		$item = BasketItem::FindFirst("basket_id",$this,"product_id",$product);

		if($options["update_rank"]){
			$item->setRank(0);
		}

		return $item;
	}

	function getProductAmount($product){
		$product = self::ObjToId($product);
		foreach($this->getItems() as $item){
			if($item->getProductId()==$product){
				return $item->getAmount();
			}
		}
		return 0;
	}

	function containsProduct($product){
		return $this->getProductAmount($product)>0;
	}

	function getDeliveryMethod(){
		return Cache::Get("DeliveryMethod",$this->getDeliveryMethodId());
	}

	/**
	 * Vraci cenu v dane mene
	 */
	function getDeliveryFee($incl_vat = false){
		if($incl_vat){
			return $this->getDeliveryFeeInclVat();
		}
		if($this->freeShipping()){ return 0.0; }
		if($delivery = $this->getDeliveryMethod()){
			$country = $this->_getDeliveryCountry();
			return $delivery->getPrice($country) / $this->getCurrency()->getRate();
		}
	}

	/**
	 * Vraci cenu v dane mene
	 */
	function getDeliveryFeeInclVat(){
		if($this->freeShipping()){ return 0.0; }
		if($delivery = $this->getDeliveryMethod()){
			$country = $this->_getDeliveryCountry();
			return $delivery->getPriceInclVat($country) / $this->getCurrency()->getRate();
		}
	}

	function getPaymentMethod(){
		return Cache::Get("PaymentMethod",$this->getPaymentMethodId());
	}

	/**
	 * Vraci cenu v dane mene
	 */
	function getPaymentFee($incl_vat = false){
		if($incl_vat){
			return $this->getPaymentFeeInclVat();
		}
		if($this->freeShipping()){ return 0.0; }
		if($payment = $this->getPaymentMethod()){
			return $payment->getPrice() / $this->getCurrency()->getRate();
		}
	}

	/**
	 * Vraci cenu v dane mene
	 */
	function getPaymentFeeInclVat(){
		if($this->freeShipping()){ return 0.0; }
		if($payment = $this->getPaymentMethod()){
			return $payment->getPriceInclVat() / $this->getCurrency()->getRate();
		}
	}

	/**
	 * Je vyzadovana pouze online platba?
	 */
	function onlinePaymentMethodRequired(){
		return 0<$this->dbmole->selectInt("
			SELECT COUNT(*) FROM
				basket_items,
				products,
				category_cards,
				categories
			WHERE
				basket_items.basket_id=:basket AND
				products.id=basket_items.product_id AND
				category_cards.card_id=products.card_id AND
				categories.id=category_cards.category_id AND
				categories.code=:code
		",[":basket" => $this, ":code" => "gift_vouchers"]);
	}

	function getPriceToPay($incl_vat = true, &$price_without_rounding = null){

		$currency = $this->getCurrency();

		$price = $this->getItemsPrice($incl_vat);

		$price += $this->getDeliveryFee($incl_vat);
		$price += $this->getPaymentFee($incl_vat);
		$price -= $this->getVouchersDiscountAmount($incl_vat);
		$price -= $this->getCampaignsDiscountAmount($incl_vat);

		$price_without_rounding = $price;

		$price = round($price,$currency->getDecimalsSummary());
		return $price;
	}

	/**
	 * Castka, za kterou je nutne jeste nakoupit, aby byla doprava zdarma.
 	 *
	 *	$add_more = $basket->getAddMoreToGetFreeDelivery();
	 *	// 99.0 - jeste 99.0 penez v dane mene pro dopravu zdarma!
	 *	// 0.0 - pro dopravu zdarma uz neni treba nic do kosiku pridavat
	 *	// null - kampan pro dopravu zdarma neexistuje
	 */
	function getAddMoreToGetFreeDelivery(){
		$region = $this->getRegion();
		$user = $this->getUser();
		$current_price = $this->getItemsPriceInclVat();

		$conditions = [
			"active",
			"free_shipping",
			"(regions->>:region_code)::BOOLEAN",
			"valid_from IS NULL OR valid_from<=:now",
			"valid_to IS NULL OR valid_to>=:now",
		];
		if(!$user){
			$conditions[] = "NOT user_registration_required";
		}

		$bind_ar = [
			":region_code" => $region->getCode(),
			":now" => now(),
		];

		$campaign = Campaign::FindFirst([
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order_by" => "minimal_items_price_incl_vat",
		]);

		if($campaign){
			$currency = $this->getCurrency();
			$required_price = $campaign->getMinimalItemsPriceInclVat() / $currency->getRate();

			$add_more = $required_price - $current_price;
			if($add_more<0.0){
				return 0.0;
			}
			return $add_more;
		}
	}

	/**
	 * Ma kosik nastavenou fakturacni adresu?
	 */
	function hasAddressSet(){
		foreach(self::GetAddressFields() as $k => $req){
			if($req && strlen($this->g("$k"))==0){ return false; }
		}
		return true;
	}

	/**
	 * Ma kosik nastavenou dorucovaci adresu?
	 */
	function hasDeliveryAddressSet(){
		foreach(self::GetAddressFields(["prefix" => "delivery_"]) as $k => $req){
			if($req && strlen($this->g("$k"))==0){ return false; }
		}
		return true;
	}

	function getVouchersLister(){
		return $this->getLister("Vouchers");
	}

	/**
	 * !! Pozor !! Toto nevraci Voucher[], ale BasketVoucher[]
	 */
	function getVouchers(){
		return $this->getBasketVouchers();
		//return $this->getVouchersLister()->getRecords();
	}

	/**
	 * Pozor!! Toto nevraci Voucher[], ale BasketItem[]
	 *
	 * @return BasketVoucher[]
	 */
	function getBasketVouchers(){
		return Cache::Get("BasketVoucher",$this->getVouchersLister()->getIds());
	}

	/**
	 * Alias pro getBasketCampaigns()
	 * 
	 * !! Pozor !! Toto nevraci Campaigns[], ale BasketCampaign[]
	 */
	function getCampaigns(){
		return $this->getBasketCampaigns();
	}

	/**
	 *
	 *	$campaigns = $basket->getBasketCampaigns();
	 *	$campaigns = $basket->getBasketCampaigns($delivery_method); // tady lze ziskat kampane, ktere by se tykaly kosiku, pokud by v nem byla nastavena jina $delivery_method
	 */
	function getBasketCampaigns($considered_delivery_method = null){
		$out = [];

		$currency = $this->getCurrency();
		$user = $this->getUser();
		$region = $this->getRegion();
		$delivery_method = $considered_delivery_method ? $considered_delivery_method : $this->getDeliveryMethod();
		$items_price_incl_vat = $this->getItemsPriceInclVat() * $currency->getRate();
		$now = now();

		// Zakladni podminky
		$conditions = $bind_ar = [];
		$conditions[] = "(regions->>:region_code)::BOOLEAN";
		$bind_ar[":region_code"] = $region->getCode(); 
		$conditions[] = "active";
		$conditions[] = "valid_from IS NULL OR valid_from<:now";
		$conditions[] = "valid_to IS NULL OR valid_to>:now";
		$bind_ar[":now"] = $now;
		if(!$user){
			$conditions[] = "NOT user_registration_required";
		}
		if($delivery_method){
			$conditions[] = "delivery_method_id IS NULL OR delivery_method_id=:delivery_method";
			$bind_ar[":delivery_method"] = $delivery_method;
		}else{
			$conditions[] = "delivery_method_id IS NULL";
		}
		$conditions[] = "minimal_items_price_incl_vat<=:items_price_incl_vat";
		$bind_ar[":items_price_incl_vat"] = $items_price_incl_vat;

		// Napred hledame kampan s nejvyhodnejsi procentrni slevou
		$_conditions = $conditions;
		$_bind_ar = $bind_ar;
		$_conditions[] = "discount_percent>0.0";
		$campaign = Campaign::FindFirst([
			"conditions" => $_conditions,
			"bind_ar" => $_bind_ar,
			"order_by" => "discount_percent DESC", // nejvyssi sleva jako prvni
		],[
			"use_cache" => true,
		]);
		if($campaign){
			$out[] = new BasketCampaign($this,$campaign);
		}

		// Ted kampan s dopravou zdarma
		$_conditions = $conditions;
		$_bind_ar = $bind_ar;
		$_conditions[] = "free_shipping";
		$campaign = Campaign::FindFirst([
			"conditions" => $_conditions,
			"bind_ar" => $_bind_ar,
		],[
			"use_cache" => true,
		]);
		if($campaign){
			$out[] = new BasketCampaign($this,$campaign);
		}

		return $out;
	}

	/**
	 * Ma tento kosik dopravu zdarma?
	 *
	 * Tj. uz je aktivni kampan na dopravu zdarma nebo je v kosiku voucher na dopravu zdarma.
	 */
	function freeShipping($considered_delivery_method = null){

		if(is_null($considered_delivery_method)){ $considered_delivery_method = $this->getDeliveryMethod(); }
		
		foreach($this->getBasketCampaigns($considered_delivery_method) as $bc){
			if($bc->freeShipping()){
				return true;
			}
		}

		foreach($this->getBasketVouchers() as $bv){
			$voucher = $bv->getVoucher();
			if($voucher->freeShipping()){
				return true;
			}
		}

		return false;
	}

	/**
	 * Zmena obsahu kosiku zmenu jeho checksum
	 * 
	 * Pouziva se pri vytvareni objednavky.
	 * Chceme mit totiz jistotu, ze uzivatel vytvari objednavku podle toho, co vidi v sumarizaci kosiku.
	 */
	function getChecksum(){
		$ary = [];
		foreach($this->getItems() as $item){
			$ary[] = [$item->getProductId(),$item->getAmount()];
		}

		return md5(serialize($ary));
	}

	function canOrderBeCreated(&$messages = [],$options = []){
		$messages = [];

		if($this->isEmpty()){
			$messages[] = new BasketErrorMessage(_("Košík je prázdný"));
			return false;
		}

		foreach($this->getItems() as $item){
			$product = $item->getProduct();

			$price = $item->getProductPrice();
			if(!$price->priceExists()){
				$messages[] = new BasketErrorMessage(
					sprintf(_("Produkt <em>%s (%s)</em> byl vyřazen z našeho ceníku"),h($product->getName()),h($product->getCatalogId())),
					[
						"correction_text" => _("odebrat z košíku"),
						"correction_url" => $this->_buildLink(["action" => "basket_items/destroy", "id" => $item->getId()]),
					]
				);
				continue;
			}

			$max_quantity = $product->getCalculatedMaximumQuantityToOrder();
			$min_quantity = $product->getCalculatedMinimumQuantityToOrder();
			$step = $product->getOrderQuantityStep();
			$amount = $item->getAmount();

			if($max_quantity<=0){
				$messages[] = new BasketErrorMessage(sprintf(_("Produkt <em>%s (%s)</em> není skladem"),h($product->getName()),h($product->getCatalogId())),
					[
						"correction_text" => _("odebrat z košíku"),
						"correction_url" => $this->_buildLink(["action" => "basket_items/destroy", "id" => $item->getId()]),
					]
				);
				continue;
			}

			if($amount>$max_quantity){
				$messages[] = new BasketErrorMessage(sprintf(_("Produkt <em>%s (%s)</em> lze objednat v počtu nejvýše: %s"),h($product->getName()),h($product->getCatalogId()),$max_quantity),
					[
						"correction_text" => sprintf(_("změnit množství na %s"),$max_quantity),
						"correction_url" => $this->_buildLink(["action" => "basket_items/edit", "id" => $item->getId(), "amount" => $max_quantity]),
					]
				);
				continue;
			}

			if($amount<$min_quantity){
				$messages[] = new BasketErrorMessage(sprintf(_("Produkt <em>%s (%s)</em> lze objednat v počtu nejméně: %s"),h($product->getName()),h($product->getCatalogId()),$min_quantity),
					[
						"correction_text" => sprintf(_("změnit množství na %s"),$min_quantity),
						"correction_url" => $this->_buildLink(["action" => "basket_items/edit", "id" => $item->getId(), "amount" => $min_quantity]),
					]
				);
				continue;
			}

			if($amount%$step!==0){
				$new_quantity = ceil($amount / $step) * $step;
				$messages[] = new BasketErrorMessage(sprintf(_("Množství u produktu <em>%s (%s)</em> musí být násobkem čísla %s"),h($product->getName()),h($product->getCatalogId()),$min_quantity,$amount),
					[
						"correction_text" => sprintf(_("změnit množství na %s"),$new_quantity),
						"correction_url" => $this->_buildLink(["action" => "basket_items/edit", "id" => $item->getId(), "amount" => $new_quantity]),
					]
				);
				continue;
			}
		}

		foreach($this->getBasketVouchers() as $b_voucher){
			$voucher = $b_voucher->getVoucher();
			if(!$voucher->isApplicable($this,$msg)){
				$messages[] = new BasketErrorMessage($msg,[
					"correction_text" => sprintf(_("odstranit voucher")),
					"correction_url" => $this->_buildLink(["action" => "basket_vouchers/destroy", "id" => $b_voucher->getId()])
				]);
			}
		}

		$currency = $this->getCurrency();
		if($this->getPriceToPay()<0.0){
			$messages[] = new BasketErrorMessage(_("Celková cena nesmí být záporná. Přihoďte do košíku ještě něco malého :)"),[
				"correction_text" => sprintf(_("přejít do katalogu")),
				"correction_url" => $this->_buildLink(["action" => "categories/index"])
			]);
		}elseif($this->getPriceToPay()<$currency->getLowestOrderPrice()){
			Atk14Require::Helper("modifier.display_price");
			$messages[] = new BasketErrorMessage(sprintf(_("Celková cena musí být alespoň %s. Přihoďte do košíku ještě něco malého :)"),smarty_modifier_display_price($currency->getLowestOrderPrice(),["currency" => $currency, "format" => "plain", "summary" => true])),[
				"correction_text" => sprintf(_("přejít do katalogu")),
				"correction_url" => $this->_buildLink(["action" => "categories/index"])
			]);
		}

		if($this->onlinePaymentMethodRequired() && $this->getPaymentMethod() && !$this->getPaymentMethod()->isOnlineMethod()){
			$messages[] = new BasketErrorMessage(_("Musí být vybrána online platební metoda"));
		}

		$delivery_method = $this->getDeliveryMethod();
		if($delivery_method && ($required_tag = $delivery_method->getRequiredTag())){
			if(!$this->hasEveryProductTag($required_tag)){
				$messages[] = new  BasketErrorMessage(sprintf(_("Doručovací metoda <em>%s</em> nemůže být vybrána"),h($delivery_method->getLabel())));
			}
		}

		if($messages){
			return false;
		}

		return true;
	}

	protected function _buildLink($params){
		$params += [
			"namespace" => "",
		];
		return Atk14Url::BuildLink($params);
	}

	/**
	 * Vytvori objednavku z tohoto kosiku
	 *
	 *	$order = $basket->createOrder();
	 *
	 * Vytvoreni objednavky bez DPH
	 *
	 *	$order = $basket->createOrder([
	 *		"without_vat" => true
	 *	]);
	 */
	function createOrder($options = []){
		$options += [
			"without_vat" => false,
			"gdpr" => null,
		];

		$without_vat = !!$options["without_vat"];
		$incl_vat = !$without_vat;

		$gdpr = $options["gdpr"];

		$values = $this->toArray();

		foreach([
			"id",
			"created_from_addr",
			"updated_from_addr",
			"created_at",
			"updated_at",
			"subscribe_to_newsletter",
		] as $key){
			unset($values[$key]);
		}

		$values["without_vat"] = $without_vat;

		// Toto zajisti, ze pokud neni nastavena fakturacni adresa, pouzije se dorucovaci.
		// Osetreno to je to v jednotlivych funkcich getAddressStreet(), getAddressCity().
		$address_fields = array_keys(Basket::GetAddressFields());
		foreach($address_fields as $key){
			$method = String4::ToObject($key)->camelize()->prepend("get")->toString(); // "address_zip" -> "getAddressZip"
			$values[$key] = $this->$method();
		}

		$payment_method = $this->getPaymentMethod();
		$payment_gateway = $payment_method->getPaymentGateway();

		$values["delivery_method_data"] = $this->g("delivery_method_data");

		$values["delivery_fee"] = $this->getDeliveryFee();
		$values["delivery_fee_incl_vat"] = $this->getDeliveryFee($incl_vat);

		$values["payment_fee"] = $this->getPaymentFee();
		$values["payment_fee_incl_vat"] = $this->getPaymentFee($incl_vat);

		$values["price_to_pay"] = $price_to_pay = $this->getPriceToPay($incl_vat,$price_to_pay_without_rounding);

		$values["creation_notified"] = false; // zpozdeni emailove notifikace

		$values["gdpr"] = $gdpr;

		$order = Order::CreateNewRecord($values);
		$order->setNewOrderStatus(OrderStatus::DetermineInitialStatus($values["payment_method_id"])->getCode());

		foreach($this->getItems() as $item){
			$p_price = $item->getProductPrice();
			OrderItem::CreateNewRecord([
				"order_id" => $order,
				"product_id" => $item->getProductId(),
				"amount" => $item->getAmount(),
				"unit_price" => $p_price->getRawUnitPrice(),
				"unit_price_before_discount" => $p_price->getRawUnitPriceBeforeDiscount(),
				"vat_percent" => $incl_vat ? $item->getVatPercent() : 0.0,
				# zda byla poskytnuta sleva v kampani nebo pri pouziti poukazu (vouchers)
				# napr. u zlevneneho zbozi se neposkytuje
				"campaign_discount_applied" => (($this->getCampaignsDiscountAmount()>0) || ($this->getVouchersDiscountAmount(null, ["free_shipping" => false, "discount_amount" => false])>0)) && !$item->discounted(),
			]);

			$product = $item->getProduct();

			// Blokace skladove zasoby
			// Blokace se uz vybira z view v_stockcount_blocations
			/*
			if($product->considerStockcount()){
				StockcountBlocation::CreateNewRecord([
					"order_id" => $order,
					"product_id" => $item->getProductId(),
					"stockcount" => $item->getAmount(),
				]);
			}
			*/
		}

		// Pridani polozky "Zaokrouhlení"
		$currency = $this->getCurrency();
		$delta = $price_to_pay - $price_to_pay_without_rounding;
		$delta = $currency->roundPrice($delta);
		if(abs($delta)>=$currency->getLowestPrice()){
			$amount = $delta > 0.0 ? 1 : -1;
			$delta_product = Product::FindByCode("price_rounding");
			$delta_vat_percent = $incl_vat ? $delta_product->getVatPercent() : 0.0;
			$delta_price = abs($delta);
			$delta_price_with_no_vat = ($delta_price / (100.0 + $delta_vat_percent)) * 100.0;

			OrderItem::CreateNewRecord([
				"order_id" => $order,
				"product_id" => $delta_product,
				"amount" => $amount,
				"unit_price" => $delta_price_with_no_vat,
				"vat_percent" => $delta_vat_percent,
			]);
		}

		// Vouchery
		foreach($this->getBasketVouchers() as $b_voucher){
			OrderVoucher::CreateNewRecord([
				"order_id" => $order,
				"voucher_id" => $b_voucher->getVoucherId(),
				"discount_amount" => $b_voucher->getDiscountAmount($incl_vat),
			]);
		}

		// Kampane
		foreach($this->getBasketCampaigns() as $b_campaign){
			OrderCampaign::CreateNewRecord([
				"order_id" => $order,
				"campaign_id" => $b_campaign->getCampaignId(),
				"discount_amount" => $b_campaign->getDiscountAmount($incl_vat),
			]);
		}

		// Vytvoreni platebni transakce
		if($payment_gateway){
			PaymentTransaction::CreateNewRecord([
				"order_id" => $order,
				"payment_gateway_id" => $payment_gateway,
			]);
		}


		# v ApplicationModel se automaticky vyplni prihlaseny uzivatel,
		# kdyz dojde ke zmene stavu diky predchozimu kodu.
		# pri nove vytvorene objednavce to ale nechceme.
		$order->s("updated_by_user_id", null);
		return $order;
	}

	/**
	 * Slouceni dvou kosiku
	 *
	 *	$new_basket->mergeBasket($current_basket);
	 *	// a dale se uz pouziva $new_basket
	 */
	function mergeBasket($basket){

		$update_ar = array();
		foreach(array(
			"payment_method_id",
			"delivery_method_id"
		) as $f){
			$v = $basket->g($f);
			if(!is_null($v)){
				$update_ar[$f] = $v;
			}
		}

		$update_ar && $this->s($update_ar);
		$this->_mergeBasketItems($basket);

		$lister = $this->getVouchersLister();
		foreach($basket->getBasketVouchers() as $b_voucher){
			$voucher = $b_voucher->getVoucher();
			if(!$lister->contains($voucher)){
				$lister->add($voucher);
			}
		}
	}

	function getFirstname(){
		return $this->hasAddressSet() ? $this->g("firstname") : $this->g("delivery_firstname");
	}

	function getLastname(){
		return $this->hasAddressSet() ? $this->g("lastname") : $this->g("delivery_lastname");
	}

	function getCompany(){
		return $this->hasAddressSet() ? $this->g("company") : $this->g("delivery_company");
	}

	function getAddressStreet(){
		return $this->hasAddressSet() ? $this->g("address_street") : $this->g("delivery_address_street");
	}

	function getAddressStreet2(){
		return $this->hasAddressSet() ? $this->g("address_street2") : $this->g("delivery_address_street2");
	}

	function getAddressCity(){
		return $this->hasAddressSet() ? $this->g("address_city") : $this->g("delivery_address_city");
	}

	function getAddressZip(){
		return $this->hasAddressSet() ? $this->g("address_zip") : $this->g("delivery_address_zip");
	}

	function getAddressCountry(){
		return $this->hasAddressSet() ? $this->g("address_country") : $this->g("delivery_address_country");
	}

	/**
	 * Ma kazdy produkt v kosiku dane klicove slovo?
	 */
	function hasEveryProductTag($tag){
		if($this->isEmpty()){ return false; }
		foreach($this->getBasketItems() as $item){
			$product = $item->getProduct();
			$card = $product->getCard();
			if(!in_array($tag->getId(),$card->getTagsLister()->getRecordIds())){
				return false;
			}
		}
		return true;
	}

	/**
	 *
	 *	$basket1->addProduct("1111/11111111",2);
	 *	$basket1->addProduct("2222/22222222",3);
	 *
	 *	$basket2->addProduct("1111/11111111",3);
	 *	$basket2->addProduct("3333/33333333",5);
	 *
	 *	$basket1->mergeBasketItems($basket2);
	 *	// 1111/11111111 3
	 *	// 2222/22222222 3
	 *	// 3333/33333333 5
	 */
	protected function _mergeBasketItems($basket){
		$dbmole = $this->getDbmole();

		$dbmole->doQuery("
			DELETE FROM basket_items WHERE basket_id=:to_id AND product_id IN (SELECT product_id FROM basket_items WHERE basket_id=:from_id);
			CREATE TEMPORARY TABLE temp_basket_items AS SELECT * FROM basket_items WHERE basket_id=:from_id;
			UPDATE temp_basket_items SET basket_id=:to_id, id=NEXTVAL('seq_basket_items'),updated_at=:now;
			INSERT INTO basket_items SELECT * FROM temp_basket_items;
			DROP TABLE temp_basket_items;
		",[
			":from_id" => $basket->getId(),
			":to_id" => $this->getId(),
			":now" => now(),
		]);

		$this->basket_items = null;
	}

	function destroy($options = []){
		if($this->isDummy()){
			throw new Exception("Dummy basket cannot be erased!");
		}

		return parent::destroy($options);
	}

	function setValues($values,$options = []){
		if($this->isDummy()){
			throw new Exception("Dummy basket cannot be updated!");
		}
		return parent::setValues($values,$options);
	}

	protected function _getDeliveryCountry(){
		$country = $this->g("delivery_address_country");
		return is_null($country) ? $this->g("address_country") : $country;
	}

	function getDeliveryMethodData() {
		return json_decode($this->g("delivery_method_data"),true);
	}
}
