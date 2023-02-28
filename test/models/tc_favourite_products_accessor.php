<?php
/**
 *
 * @fixture users
 * @fixture products
 * @fixture cards
 */
class TcFavouriteProductsAccessor extends TcBase {

	function test(){
		$session = new Atk14Session();
		$session2 = new Atk14Session();

		$fpa = new FavouriteProductsAccessor(null,$session);
		$fpa_same = new FavouriteProductsAccessor(null,$session);
		$fpa_another = new FavouriteProductsAccessor(null,$session2);
		$fpa_user = new FavouriteProductsAccessor($this->users["rambo"]);

		$this->assertEquals([],$fpa->getFavouriteProducts());
		$this->assertEquals(false,$fpa->isFavouriteProduct($this->products["black_tea"]));
		$this->assertEquals(false,$fpa->isFavouriteProduct($this->products["green_tea"]));
		$this->assertEquals(false,$fpa->isFavouriteCard($this->cards["tea"]));
		$this->assertEquals(false,$fpa->isFavourite($this->products["black_tea"]));
		$this->assertEquals(false,$fpa->isFavourite($this->products["green_tea"]));
		$this->assertEquals(false,$fpa->isFavourite($this->cards["tea"]));

		$fpa->addProduct($this->products["black_tea"]);

		$fav_products = $fpa->getFavouriteProducts();
		$this->assertEquals(1,sizeof($fav_products));
		$this->assertEquals($fav_products[0]->getProductId(),$this->products["black_tea"]->getId());

		$this->assertEquals(true,$fpa->isFavouriteProduct($this->products["black_tea"]));
		$this->assertEquals(false,$fpa->isFavouriteProduct($this->products["green_tea"]));
		$this->assertEquals(true,$fpa->isFavouriteCard($this->cards["tea"]));
		$this->assertEquals(true,$fpa->isFavourite($this->products["black_tea"]));
		$this->assertEquals(false,$fpa->isFavourite($this->products["green_tea"]));
		$this->assertEquals(true,$fpa->isFavourite($this->cards["tea"]));

		$this->assertEquals(true,$fpa_same->isFavouriteProduct($this->products["black_tea"]));
		$this->assertEquals(false,$fpa_same->isFavouriteProduct($this->products["green_tea"]));
		$this->assertEquals(true,$fpa_same->isFavouriteCard($this->cards["tea"]));

		$this->assertEquals(false,$fpa_another->isFavouriteProduct($this->products["black_tea"]));
		$this->assertEquals(false,$fpa_another->isFavouriteProduct($this->products["green_tea"]));
		$this->assertEquals(false,$fpa_another->isFavouriteCard($this->cards["tea"]));

		$fpa->delProduct($this->products["black_tea"]);

		$this->assertEquals([],$fpa->getFavouriteProducts());

		// merge

		$fpa_another->addProduct($this->products["mint_tea"]);
		$fpa_another->addProduct($this->products["book"]);

		$fpa_user->addProduct($this->products["book"]);
		$fpa_user->addProduct($this->products["wooden_button"]);

		$fpa_user->mergeFavouriteProductsAccessor($fpa_another);

		$fav_products = $fpa_user->getFavouriteProducts();
		$this->assertEquals(3,sizeof($fav_products));
		$this->assertEquals($fav_products[0]->getProductId(),$this->products["mint_tea"]->getId());
		$this->assertEquals($fav_products[1]->getProductId(),$this->products["wooden_button"]->getId());
		$this->assertEquals($fav_products[2]->getProductId(),$this->products["book"]->getId());

		$this->assertEquals(2,sizeof($fpa_another->getFavouriteProducts()));
		$fpa_another->destroy();
		$this->assertEquals(0,sizeof($fpa_another->getFavouriteProducts()));
	}
}
