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
		$session_salt = $this->_getSessionSalt();
		if(is_null($session_salt)){ return []; }
		return FavouriteProduct::FindAll("user_id",$this->user,"session_salt",$session_salt);
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
	}

	function addProduct($product){
		if(!$fp = $this->isFavouriteProduct($product,true)){
			$session_salt = $this->_getSessionSalt(true);
			$fp = FavouriteProduct::CreateNewRecord([
				"user_id" => $this->user,
				"session_salt" => $session_salt,
				"product_id" => $product,
			]);
		}
		return $fp;
	}

	function delProduct($product){
		$fp = $this->isFavouriteProduct($product,true);
		if($fp){ $fp->destroy(); }
	}

	function isFavouriteProduct($product,$return_favourite_product = false){
		$session_salt = $this->_getSessionSalt();
		if(is_null($session_salt)){ return false; }
		$fp = FavouriteProduct::FindFirst("user_id",$this->user,"session_salt",$session_salt,"product_id",$product);

		return $return_favourite_product ? $fp : !!$fp;
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
		if(strlen($session_salt)==0){
			$session_salt = null;
		}
		if(!$session_salt && $create_if_not_exists){
			$session_salt = "anon_".time()."_".uniqid();
			$this->session->s("favourite_products_salt",$session_salt);
		}
		return $session_salt;
	}
}
