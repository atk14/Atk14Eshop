<?php
/**
 *
 *	$fpa = new FavouriteProductsAccessor($user);
 *	// or
 *	$fpa = new FavouriteProductsAccessor(null,$session);
 *
 *	$fpa->addProduct($product);
 *	(bool)$fpa->isFavouriteProduct($product); // true
 */
class FavouriteProductsAccessor {
	
	protected $user;
	protected $session;

	protected $CACHED_AR;

	function __construct($user,$session = null){
		if(!$user){
			$user = User::GetAnonymousUser();
		}
		
		$this->user = $user;
		$this->session = $session;
	}

	/**
	 *
	 * @return FavouriteProduct[]
	 */
	function getFavouriteProducts(){
		$this->_prepareCahedAr();
		return Cache::Get("FavouriteProduct",array_values($this->CACHED_AR));
	}

	/**
	 *
	 * @return int
	 */
	function getFavouriteProductsCount(){
		$this->_prepareCahedAr();
		return sizeof($this->CACHED_AR);
	}

	function mergeFavouriteProductsAccessor($favourite_products_accessor){
		foreach($favourite_products_accessor->getFavouriteProducts() as $fp){
			$this->addProduct($fp->getProduct());
		}
	}

	function destroy(){
		foreach($this->getFavouriteProducts() as $fp){
			$fp->destroy();
		}
		$this->CACHED_AR = [];
	}

	function addProduct($product){
		if(!$fp = $this->isFavouriteProduct($product,true)){
			$session_salt = $this->_getSessionSalt(true);
			$fp = FavouriteProduct::CreateNewRecord([
				"user_id" => $this->user,
				"session_salt" => $session_salt,
				"product_id" => $product,
			]);
			$p_id = TableRecord::ObjToId($product);

			// associative unshift
			$keys = array_keys($this->CACHED_AR);
			$values = array_values($this->CACHED_AR);
			array_unshift($keys,$p_id);
			array_unshift($values,$fp->getId());
			$this->CACHED_AR = array_combine($keys,$values);

			//$this->CACHED_AR[$p_id] = $fp->getId();
		}
		return $fp;
	}

	function delProduct($product){
		$fp = $this->isFavouriteProduct($product,true);
		if($fp){
			$p_id = TableRecord::ObjToId($product);
			unset($this->CACHED_AR[$p_id]);
			$fp->destroy();
		}
	}

	function isFavouriteProduct($product,$return_favourite_product = false){
		$this->_prepareCahedAr();

		$p_id = TableRecord::ObjToId($product);
		if($return_favourite_product){
			if(isset($this->CACHED_AR[$p_id])){
				return Cache::Get("FavouriteProduct",$this->CACHED_AR[$p_id]);
			}
			return null;
		}

		return isset($this->CACHED_AR[$p_id]);
	}

	function isFavouriteCard($card){
		foreach($card->getProducts() as $product){
			if($this->isFavouriteProduct($product)){ return true; }
		}
		return false;
	}

	function isFavourite($object){
		if(is_a($object,"Product")){
			return $this->isFavouriteProduct($object);
		}
		if(is_a($object,"Card")){
			return $this->isFavouriteCard($object);
		}
		return false;
	}

	protected function _getSessionSalt($create_if_not_exists = false){
		if(!$this->user->isAnonymous()){
			return "";
		}
		$session_salt = $this->session->g("favourite_products_salt");
		if(strlen((string)$session_salt)==0){
			$session_salt = null;
		}
		if(!$session_salt && $create_if_not_exists){
			$session_salt = "anon_".time()."_".uniqid();
			$this->session->s("favourite_products_salt",$session_salt);
		}
		return $session_salt;
	}

	protected function _prepareCahedAr(){
		if(!is_null($this->CACHED_AR)){ return; }

		$this->CACHED_AR = [];
		$session_salt = $this->_getSessionSalt(false);
		if(is_null($session_salt)){
			return;
		}

		$conditions = $bind_ar = [];
		$conditions[] = "session_salt=:session_salt";
		$bind_ar[":session_salt"] = $session_salt;
		if($this->user){
			$conditions[] = "user_id=:user";
			$bind_ar[":user"] = $this->user;
		}else{
			$conditions[] = "user_id IS NULL";
		}
		
		$dbmole = FavouriteProduct::GetDbmole();
		$this->CACHED_AR = $dbmole->selectIntoAssociativeArray("SELECT product_id,id FROM favourite_products WHERE ".join(" AND ",$conditions)." ORDER BY created_at DESC, id DESC",$bind_ar);
	}
}
