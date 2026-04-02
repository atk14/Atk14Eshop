<?php
class BankAccount extends ApplicationModel implements Translatable, Rankable {

	use TraitCodebook;
	use TraitRegions;

	static function GetTranslatableFields(){ return ["name"]; }

	function setRank($rank){
		return $this->_setRank($rank);
	}

	/**
	 * @return Currency[]
	 */
	function getCurrencies(){
		$codes = json_decode($this->g("currencies"),true);

		$currencies = Currency::FindAll("code IN :codes",[":codes" => $codes]);

		$out = [];
		foreach($codes as $code){
			foreach($currencies as $c){
				if($c->getCode()==$code){
					$out[] = $c;
					break;
				}
			}
		}

		return $out;
	}

  function getIban($formatted = false){
    $iban = $this->g("iban");
    if($formatted){
      $c = "[A-Z0-9]";
      $iban = preg_replace("/^($c{4})($c{4})($c{4})($c{4})/",'\1 \2 \3 \4 ',$iban);
    }

    return $iban;
  }

  function getBasicPart(){
    if(preg_match('/^(\d+-|)(\d+)\//',$this->getAccountNumber(),$matches)){
      return $matches[2];
    }
    return "";
  }

  function getPrefix(){
    $ary = explode("-",$this->getAccountNumber());
    return sizeof($ary)>=2 ? $ary[0] : "";
  }

  function getBankCode(){
    $ary = explode("/",$this->getAccountNumber());
    return isset($ary[1]) ? $ary[1] : "";
  }

	function isActive(){
		return $this->g("active");
	}

	function isDeletable(){
		return strlen((string)$this->getCode())==0;
	}

  function toString(){
    return $this->getAccountNumber();
  }
}
