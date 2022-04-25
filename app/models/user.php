<?php
/**
 * Model class for user records
 *
 * Uses lib/myblowfish.php for passwords hashing.
 * See test/models/tc_user.php for basic usage.
 */
class User extends ApplicationModel{

	const ID_SUPERADMIN = 1;
	const ID_ANONYMOUS = 2; // see db/migrations/0117_altering_users.sql
	const ID_ROBOT = 3;

	/**
	 * Returns user when a correct combination of login and password is given.
	 * 
	 * $user = User::Login("rambo","secret"); // returns user when login and password are correct
	 */
	static function Login($login,$password,&$bad_password = false){
		$bad_password = false;
	  $user = User::FindByLogin($login);
		if(!$user){ return; }
		if(!$user->isActive()){ return; }
	  if($user->isPasswordCorrect($password)){
			return $user;
		}
		$bad_password = true;
	}

	/**
	 * $user = User::CreateNewRecord(array(
	 *  "login" => "rambo",
	 *  "password" => "secret"
	 * )); // returns user with hashed password
	 */
	static function CreateNewRecord($values,$options = array()){
		global $ATK14_GLOBAL;

		if(isset($values["password"])){
			$values["password"] = MyBlowfish::Filter($values["password"]);
		}

		$anonymous = self::GetAnonymousUser();
		if($anonymous){
			$values += [
				"pricelist_id" => $anonymous->g("pricelist_id"),
				"base_pricelist_id" => $anonymous->g("base_pricelist_id"),
				"language" => $ATK14_GLOBAL->getLang(), // when the anonymous user exists, the field users.language also exists
			];
		}

	  return parent::CreateNewRecord($values,$options);
	}

	static function GetAnonymousUser(){
		return Cache::Get("User",User::ID_ANONYMOUS);
	}

	/**
	 * On a record update it provides transparent password hashing
	 *
	 * A new password won't be stored in database in plain form:
	 *
	 *	 $rambo->setValues(array("password" => "secret123"));
	 *	 // or $rambo->setValue("password","secret123");
	 *	 // or $rambo->s("password","secret123");
	 */
	function setValues($values,$options = array()){
		if(isset($values["password"])){
			$values["password"] = MyBlowfish::Filter($values["password"]);
		}
		return parent::setValues($values,$options);
	}

	function isPasswordCorrect($password){
		return MyBlowfish::CheckPassword($password,$this->getPassword());
	}

	function getName(){
		$name = trim($this->getFirstname()." ".$this->getLastname());
		if(strlen($name)){ return $name; }
		return $this->getLogin();
	}

	function isAdmin(){ return $this->getIsAdmin(); }

	function isSuperAdmin(){ return $this->getId()==self::ID_SUPERADMIN; }

	function isAnonymous(){ return $this->getId()==self::ID_ANONYMOUS; }

	function toString(){ return (string)$this->getName(); }

	function isActive(){ return $this->g("active"); }

	function isDeletable(){ return !in_array($this->getId(),array(self::ID_SUPERADMIN,self::ID_ANONYMOUS)); }

	function getPricelist(){
		return Cache::Get("Pricelist",$this->getPricelistId());
	}

	function getBasePricelist(){
		return Cache::Get("Pricelist",$this->getBasePricelistId());
	}

	function getCustomerGroups(){
		static $ALL_CUSTOMER_GROUPS;
		if(!$ALL_CUSTOMER_GROUPS){
			$ALL_CUSTOMER_GROUPS = CustomerGroup::FindAll(["use_cache" => true]);
		}

		$lister = $this->getLister("CustomerGroups");
		$ids = $lister->getRecordIds(); // groups saved in db

		$ids[] = CustomerGroup::GetInstanceByCode($this->isAnonymous() ? "unregistered" : "registered"); // unregistered or registered group is not saved in db

		// Here is the place for other application-specific customer groups...
	
		$ids = TableRecord::ObjToId($ids);
		$out = [];
		foreach($ALL_CUSTOMER_GROUPS as $cg){
			if(in_array($cg->getId(),$ids)){
				$out[] = $cg;
			}
		}
		
		return $out;
	}

	/**
	 *
	 *	$user->isInCustomerGroup("vip_customers"); // code
	 *	// or
	 *	$user->isInCustomerGroup($id); // integer
	 *	// or
	 *	$user->isInCustomerGroup($customer_group); // object of CustomerGroup
	 */
	function isInCustomerGroup($group){
		if(is_numeric($group) && ($g = Cache::Get("CustomerGroup",$group))){
			$group = $g;
		}elseif(!is_object($group)){
			$group = CustomerGroup::GetInstanceByCode($group);
		}
		if(!$group){
			return false;
		}
		foreach($this->getCustomerGroups() as $g){
			if($g->getId()==$group->getId()){
				return true;
			}
		}
		return false;
	}

	/**
	 * Safely sets only customer groups which can be set manually
	 */
	function setManuallyAssignableCustomerGroups($groups){
		$lister = $this->getLister("CustomerGroups");

		$ids = TableRecord::ObjToId($groups);
		foreach(CustomerGroup::FindAll() as $cg){
			if(!$cg->isManuallyAssignable()){ continue; }
			if($lister->contains($cg) && !in_array($cg->getId(),$ids)){
				$lister->remove($cg);
			}elseif(!$lister->contains($cg) && in_array($cg->getId(),$ids)){
				$lister->append($cg);
			}
		}
	}

	function toHumanReadableString(){
		$out = [];
		$out[] = trim($this->getFirstname()." ".$this->getLastname());
		$out[] = $this->getCompany();
		if(!$this->isActive()){
			$out[] = _("inactive user");
		}
		if($this->isAdmin()){
			$out[] = _("administrator");
		}
		$out = array_filter($out);
		
		return sprintf("%s (%s)",$this->getLogin(),join(", ",$out));
	}
}
