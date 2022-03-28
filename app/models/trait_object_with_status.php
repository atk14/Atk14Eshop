<?php
Trait TraitObjectWithStatus {
	
	static function CreateNewRecord($values,$options = []){
		list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_called_class());

		$status_new = $status_class::FindByCode("new");
		$now = now();

		$values += [
			"created_at" => $now,
		];
		$values += [
			"{$prefix}_status_id" => $status_new,
			"{$prefix}_status_set_at" => $values["created_at"],
		];

		$record = parent::CreateNewRecord($values,$options);

		$history_class_name::CreateNewRecord([
			"{$prefix}_id" => $record,
			"{$prefix}_status_id" => $record->g("{$prefix}_status_id"),
			"{$prefix}_status_set_at" => $record->g("{$prefix}_status_set_at"),
			"{$prefix}_status_set_by_user_id" => $record->g("{$prefix}_status_set_by_user_id"),
		]);

		return $record;
	}

	function getStatus(){
		list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_called_class());
		return Cache::Get($status_class,$this->g("{$prefix}_status_id"));
	}

	/**
	 *
	 *	$history_items = $claim->getClaimItems();
	 *	echo $history_items[0]->getCode(); // "new"
	 *
	 * 	$history_items = $claim->getClaimItems(["reverse" => true]);
	 *	echo $history_items[0]->getCode(); // "delivered"
	 */
	function getStatusHistoryItems($options = array()) {
		list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_class($this));

		$options += array(
			"limit" => null,
			"reverse" => false,
			"order_by" => null,
		);

		if(is_null($options["order_by"])){
			$options["order_by"] = $options["reverse"] ? "{$prefix}_status_set_at DESC, id DESC" : "{$prefix}_status_set_at ASC, id ASC";
		}
		unset($options["reverse"]);

		return $history_class_name::FindAll("{$prefix}_id", $this, $options);
	}


	/**
	 * Nastaveni noveho stavu reklamace.
	 *
	 * ```
	 * $this->setNewClaimStatus(array(
	 * 	"claim_status_id" => 13,
	 * 	"claim_status_set_by_user_id" => 1
	 * );
	 * ```
	 *
	 * ```
	 * $this->setNewClaimStatus("payment_accepted");
	 * ```
	 *
	 * ```
	 * $this->setNewClaimStatus(13);
	 * ```
	 *
	 * @param mixed $new_status_values
	 * @returns ClaimStatus current claim status
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
	 * 2) Zapise zaznam do claim_history_item
	 * 3) Zmeni vsechny nasledující stavy v claim_history, které neměnily
	 *     stav (tedy zmeny responsible_user_id)
	 */
	function setNewStatus($new_status_values=array(),$options = []) {
		global $ATK14_GLOBAL;

		list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_class($this));

		$options += [
			"mailer" => null,
		];

		if (is_string($new_status_values)) {
			$new_status_values = array(
				"{$prefix}_status_id" => $status_class::GetInstanceByCode($new_status_values),
			);
		} elseif (is_integer($new_status_values)) {
			$new_status_values = array(
				"{$prefix}_status_id" => Cache::Get($status_class,$new_status_values),
			);
		} elseif (is_object($new_status_values)) {
			$new_status_values = array(
				"{$prefix}_status_id" => $new_status_values,
			);
		}

		$new_status = $new_status_values["{$prefix}_status_id"];
		if(!is_object($new_status)){
			$new_status = Cache::Get($status_class,$new_status);
		}

		$logged_user_id = ApplicationModel::_GetLoggedUserId();
		$logged_user = Cache::Get("User",$logged_user_id);

		$not_now = key_exists("{$prefix}_status_set_at", $new_status_values);
		$new_status_values += [
			"{$prefix}_status_set_at" => now(),
			"{$prefix}_status_set_by_user_id" => $logged_user && $logged_user->isAdmin() && $ATK14_GLOBAL->getValue("namespace")=="admin" ? $logged_user : null,
			"{$prefix}_status_note" => null,
		];

		# aby nedoslo k prepsani jine hodnoty v objednavce, ktera se netyka statusu
		$new_status_values = array_intersect_key($new_status_values, array_flip(array("{$prefix}_status_id", "{$prefix}_status_set_at", "{$prefix}_status_set_by_user_id", "{$prefix}_status_note")));

		$_fn = "get$status_class"; // getClaimStatus()
		$orig_status = $this->$_fn();

		# cas nastaveni stavu aktualniho (v claims.claim_status_set_at)
		$current_status_time = strtotime($this->g("{$prefix}_status_set_at"));
		# cas importovaneho stavu (pujde do claim_history.claim_status_set_at
		$new_status_time = strtotime($new_status_values["{$prefix}_status_set_at"]);

		# novy stav chceme nastavit jen kdyz je cas v 'claim_status_set_at' novejsi nez je u aktualniho stavu
		if ($new_status_time>=$current_status_time) {
			$this->s($new_status_values, array("set_update_time" => false));
		}
		$new_status_values["note"] = $new_status_values["{$prefix}_status_note"];

		unset($new_status_values["{$prefix}_status_note"]);

		$history_item = $this->createStatusHistoryItem(
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
				$i->g("{$prefix}_status_id") == $prevState->g("{$prefix}_status_id")
			) {
				$i->s("{$prefix}_status_id", $history_item->g("{$prefix}_status_id"));
			}
		}

		$_fn = "get{$class_name}Status";
		$claim_status = $this->$_fn();
		if($claim_status && $claim_status->notificationEnabled() && $claim_status->getId()!=$orig_status->getId()){
			$mailer = $options["mailer"] ? $options["mailer"] : Atk14MailerProxy::GetInstance();
			$lang = $this->getLanguage();
			$prev_lang = Atk14Locale::Initialize($lang);
			$_fn = "notify_{$prefix}_status_update";
			$mailer->$_fn($this);
			Atk14Locale::Initialize($prev_lang);
		}

		return $claim_status;
	}

	/**
	 * Vytvori zaznam v order_history. Hodnoty, ktere nedostane, si vytahne
	 * z te same tabulky (z "nejnovejsiho starsiho zaznamu")
	 */
	function createStatusHistoryItem( $values = null) {
		list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_class($this));

		if( $values === null ) {
			$values = $this;
		}
		if( $values instanceof Claim ) {
			$values = [
				"{$prefix}_id" => $values,
				"{$prefix}_status_set_at" => $values->g("{$prefix}_status_set_at"),
				"{$prefix}_status_set_by_user_id" => $values->g("{$prefix}_status_set_by_user_id"),
				"note" => $values->getClaimStatusNote(),
				"{$prefix}_status_id" => $values->getClaimStatusId(),
			];
		} else {
			$values += [
				"{$prefix}_id" => $this,
				"{$prefix}_status_set_at" => now(),
				"{$prefix}_status_set_by_user_id" => ApplicationModel::_GetLoggedUserId(),
				"note" => '',
			];
			$ovalues = $this->dbmole->selectRow("SELECT
							{$prefix}_status_id
							FROM {$prefix}_history WHERE {$prefix}_id = :id AND {$prefix}_status_set_at <= :at
							ORDER BY {$prefix}_status_set_at DESC LIMIT 1
							", [
								':id' => $values["{$prefix}_id"],
								':at' => $values["{$prefix}_status_set_at"],
			]);
			if ($ovalues) {
				$values+=$ovalues;
			}
		}
		$history = $history_class_name::CreateNewRecord($values);
		return $history;
	}

	/**
	 *
	 * 	list($prefix,$status_class,$history_class_name,$class_name) = self::_GetStatusNames(get_class($this));
	 */
	static protected function _GetStatusNames($class_name = null){
		if(is_null($class_name)){
			$class_name = get_called_class(); // "Order", "Claim", "SaleRegistration"
		}
		$history_class_name = "{$class_name}History"; // "OrderHistory", "ClaimHistory", "SaleRegistrationHistory"
		$prefix = String4::ToObject($class_name)->underscore()->toString(); // "order", "claim", "sale_registration"
		$status_class = "{$class_name}Status"; // "OrderStatus", "ClaimStatus", "SaleRegistrationStatus"

		return [$prefix,$status_class,$history_class_name,$class_name];
	}
}
