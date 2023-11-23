<?php
use DeliveryService\BranchParser;

class DeliveryService extends ApplicationModel {

	use TraitGetInstanceByCode;

	/**
	 * Vrati seznam pobocek pro dorucovaci sluzbu.
	 */
	function getDeliveryServiceBranches() {
		return DeliveryServiceBranch::FindAll("delivery_service_id", $this, "active", true);
	}

	function getBranches() {
		return $this->getDeliveryServiceBranches();
	}

	/**
	 * Vyhledani pobocek.
	 *
	 * Pokud je v $q cislo, vyhledava se podle zip, radi se podle zip
	 * V pripade textu podle nazvu pobocky, nazvu pobocky s adresou, atd.
	 *
	 * @param string $q
	 */
	function findBranches($q,$options=array()) {
		$options += array(
			"limit" => 150,
			"countries" => [],
		);
		$out = array();
		$q = trim($q);
		if (!strlen($q)) {
			return array();
		}

		$bind_ar = [
			":this" => $this,
		];
		$conditions = [
			"delivery_service_id=:this",
			"active='t'",
		];
		if ($options["countries"]) {
			$conditions[] = "country IN :countries";
			$bind_ar[":countries"] = $options["countries"];
		}

		# pokud zadame jen cislice (pripadne s mezerou), hledame jen podle psc
		if (is_numeric($q) || is_numeric($q_zip = preg_replace("/\s/","",$q))) {
			isset($q_zip) && ($q = $q_zip);

			$order = "zip";
			$conditions[] = "zip like :q_zip";
		} else {
			# normalne hledame podle nazvu nebo adresy
			# dopredu davame posty s nazvem, ktery hledanym vyrazem zacina, nebo posty s adresou, ktera hledanym vyrazem zacina
			# nasleduji posty s hledanym vyrazem kdekoliv v nazvu nebo adrese
			$unaccent_installed = $this->dbmole->selectInt("SELECT COUNT(*) FROM pg_extension WHERE extname=:extname",array(":extname" => "unaccent"));
			if ($unaccent_installed) {
				$order = array(
					"lower(unaccent(name)) like lower(unaccent(:q_zip)) DESC",
					"lower(unaccent(full_address)) like lower(unaccent(:q_zip)) DESC",
					"name",
					"full_address",
					"lower(unaccent(full_address)) like lower(unaccent(:q_zip)) DESC",
				);
			} else {
				$order = array(
					"lower(name) like lower(:q_zip) DESC",
					"lower(full_address) like lower(:q_zip) DESC",
					"name",
					"full_address",
					"lower(full_address) like lower(:q_zip) DESC",
				);
			}
			$order = join(",", $order);

			$_fields = array();
			foreach(array(
				"name",
				"place",
				"full_address"
			) as $_f){
				$_fields[] = $unaccent_installed ? "COALESCE(UNACCENT($_f),'')" : "COALESCE($_f,'')";
			}
			$_q = $this->dbmole->selectString($unaccent_installed ? "SELECT LOWER(UNACCENT(:q))" : "SELECT LOWER(:q)",[":q" => $q]);
			if(!$ft_cond = FullTextSearchQueryLike::GetQuery("LOWER(".join("||' '||",$_fields).")",$_q,$bind_ar)){
				return array();
			}
			$conditions[] = $ft_cond;
		}
		$bind_ar[":q"] = "%$q%";
		$bind_ar[":q_zip"] = "$q%";

		return DeliveryServiceBranch::FindAll(array(
			"conditions" => $conditions,
			"bind_ar" => $bind_ar,
			"order" => $order,
			"limit" => $options["limit"],
		));
	}

	function setParserClass($parser_class) {
		$this->parser_class = $parser_class;
	}

	function getParserClass() {
		if (isset($this->parser_class)) {
			return $this->parser_class;
		}
		$class_name = new String4($this->getCode());
		$class_name->replace("-", "_");
		$this->parser_class = $parserClassName = sprintf("DeliveryService\BranchParser\%s", $class_name->Camelize()->toString());
		return $parserClassName;
	}

	static function ReadBranchesData($code, $options=[], &$error_message=null) {
		if (is_null($delivery_service = static::FindFirst("code", $code))) {
			return false;
		}
		$options += [
			"branches_url" => $delivery_service->getBranchesDownloadUrl(),
		];
		$headers = get_headers($options["branches_url"], true);
		$format = isset($headers["content-type"]) ? $headers["content-type"] : "xml";
		$data = @file_get_contents($options["branches_url"]);

		if ($data===false) {
			$error_message = sprintf("reading file %s failed [code: %s]", $options["branches_url"], $code);
			return false;
		}
		if ($data==="") {
			$error_message = "empty file";
			return false;
		}
		return $data;
	}

	/**
	 * Aktualizace pobocek dorucovaci sluzby.
	 *
	 * Stahne si data z url (branches_download_url) a naimportuje do tabulky delivery_service_branches
	 * Pobocky, ktere se znovu nevyskytuji v poskytnutem seznamu, se deaktivuji.
	 *
	 * ```
	 * DeliveryService::UpdateBranches("zasilkovna");
	 * ```
	 *
	 * @param string $code
	 */
	static function UpdateBranches($code, $options=array(), &$error_message=null) {
		$data = static::ReadBranchesData($code, $options, $error_message);
		if (!$data) {
			return false;
		}

		$delivery_service = static::FindFirst("code", $code);
		return $delivery_service->importData($data, $options);
	}

	protected function _getFeedFormat($options=[]) {
		$options += [
			"branches_url" => $this->getBranchesDownloadUrl(),
		];
		$headers = get_headers($options["branches_url"], true);
		$format = isset($headers["content-type"]) ? $headers["content-type"] : "application/xml";
		$format = explode("/", $format);

		return $format[1];
	}

	/**
	 * Nacteni pobocek z XML souboru.
	 *
	 * Nepouzivame XMole, nebot je prilis narocny.
	 * Data z XML nezvladne nacist.
	 *
	 */
	function importData($data, $options=array()) {
		$options += [
			"logger" => new logger(),
		];

		if (!DeliveryMethod::FindAll("delivery_service_id", $this, "active", true)) {
			$options["logger"] && $options["logger"]->info(sprintf("no active delivery method using delivery service %s. skipping branches import", $this->getName()));
			return false;
		}

		$dbmole = self::GetDbmole();
		$current_branch_ids = $dbmole->selectIntoAssociativeArray("SELECT id as key,external_branch_id FROM delivery_service_branches WHERE delivery_service_id=:this", array(":this" => $this));

		$parserClassName = $this->getParserClass();
#		$format = $this->_getFeedFormat($options);
		$feed_parser = $parserClassName::GetInstance($data);

		$nodes = $feed_parser->_getBranchNodes($options);

		foreach($nodes as $branch_row) {
			$_branchAr = $branch_row->toArray();

			$branch = DeliveryServiceBranch::FindFirst("external_branch_id", $_branchAr["external_branch_id"], "delivery_service_id", $this);
			if ($branch) {
				$_updates = $_conditions = $_bindAr = [];
				# hodnoty budeme menit, jen kdyz budou rozdilne
				# a potom i nastavime hodnotu updated_at
				foreach($_branchAr as $k => $v) {
					$_updates[] = "${k}=:${k}";
					# pozor na policko s json daty
					if ($k=="opening_hours") {
						$_conditions[] = "${k}::jsonb!=:${k}::jsonb";
					} else {
						$_conditions[] = "${k}!=:${k}";
					}
					$_bindAr[":${k}"] = $v;
				}
				$_updates[] = "updated_at='".now()."'";
				$_conditions = ["(".join(" OR ", $_conditions).")"];
				$_conditions[] = "id=:id";
				$_bindAr[":id"] = $branch;
				$_conditions = join(" AND ", $_conditions);
				$_updates = join( ", ", $_updates);

				$q = "UPDATE delivery_service_branches SET ${_updates} WHERE ${_conditions}";
				$dbmole->doQuery($q, $_bindAr);
				$options["logger"] && $options["logger"]->info(sprintf("update branch %s", $_branchAr["external_branch_id"]));
				unset($current_branch_ids[$branch->getId()]);
			} else {
				$_branchAr["delivery_service_id"] = $this;
				DeliveryServiceBranch::CreateNewRecord($_branchAr);
			}
		}

		# deactivate branches not in xml
		foreach($current_branch_ids as $_branch_id => $_external_id) {
			$options["logger"] && $options["logger"]->info("deactivate branch $_external_id [id: {$_branch_id}]");
			$this->dbmole->doQuery("UPDATE delivery_service_branches SET active='f' WHERE id=:id", array(":id" => $_branch_id));
		}

		return true;
	}

	function toString() {
		return $this->getName();
	}

	/**
	 * Overrides generic getBranchesDownloadUrl()
	 *
	 * Adds some generic url processing, such as replacing placeholder for api key.
	 *
	 * @return string
	 */
	function getBranchesDownloadUrl() {
		$className = $this->getParserClass();
		$url = $className::$BRANCHES_DOWNLOAD_URL;
		if (preg_match("/({API_KEY})/", $url)) {
			$_param_name = sprintf("delivery_services.%s.api_key", $this->getCode());
			if ($_sys_param = SystemParameter::ContentOn($_param_name)) {
				$url = preg_replace("/({API_KEY})/", $_sys_param, $url);
			}
		}
		return $url;
	}

	/**
	 * Looks at the branches download url and checks if it can be used
	 *
	 * In case the keyword is not replaced,
	 * it means the api key is not provided so we should not use this service and also the delivery_method using this service.
	 */
	function canBeUsed() {
		$download_url = $this->getBranchesDownloadUrl();
		if (preg_match("/({API_KEY})/", $download_url)) {
			return false;
		}
		return true;
	}

	function getRequirements() {
		$className = $this->getParserClass();
		$requirements = $className::GetRequirements();
		return $requirements;
	}
}
