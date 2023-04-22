<?php
class Card extends ApplicationModel implements Translatable, iSlug, \Textmit\Indexable {

	use TraitTags;

	static function GetTranslatableFields(){ return array("name","teaser","page_title","page_description"); }

	static function CreateNewRecord($values,$options = array()){
		$collection_id = null;
		if (array_key_exists("collection_id", $values)) {
			$collection_id = $values["collection_id"];
			unset($values["collection_id"]);
		}
		$card = parent::CreateNewRecord($values,$options);
		return $card;
	}

	/**
	 * 
	 */
	static $ProductList;
	static function GetProductsList($cards,$options = array()){
		if(!self::$ProductList) {
			self::$ProductList = new CacheSomething(function($ids) {
				$dbmole = Card::GetDbmole();
				$rows = $dbmole->selectRows("SELECT
							card_id,id,visible,deleted
						FROM
							products WHERE card_id IN :ids ORDER BY rank, id",array(":ids" => $ids));
				Cache::Prepare('Product', array_column($rows, 'id'));
				$out = array_fill_keys($ids, []);
				foreach($rows as $row){
					foreach($row as &$v){
						if(in_array($v,array('t','f'))){ $v = $v=='t'; continue; } // boolean
						if(is_numeric($v)){ $v = (int)$v; continue; } // integer
					}
					$cid = $row["card_id"];
					unset($row["card_id"]);
					$out[$cid][] = $row;
				}
				return $out;
			},
			'Card');
		}
		return self::$ProductList->get($cards, $options);
	}

	function getSlugPattern($lang){
		return $this->g("name_$lang");
	}

	function getProductType(){
		return Cache::Get("ProductType",$this->g("product_type_id"));
	}

	function getPageTitle($lang = null){
		$out = parent::getPageTitle($lang);
		if(strlen((string)$out)){ return $out; }
		$product_type = $this->getProductType();
		return $product_type->generatePageTitleForProduct($this);
	}

	function getPageDescription($lang = null){
		$out = parent::getPageDescription($lang);
		if(strlen((string)$out)){ return $out; }
		$out = $this->getTeaser($lang);
		if(strlen((string)$out)){
			$out = Markdown($out);
			$out = String4::ToObject($out)->stripHtml()->toString();
			return $out;
		}
	}

	function getImages($options = array()){
		if(is_bool($options)){
			$options = ["consider_product_images" => $options];
		}
		$options += array(
			"consider_product_images" => true,
		);

		$images = Image::GetImages($this,$options);

		if(!$this->hasVariants()){ return $images; }

		if($options["consider_product_images"]){
			foreach($this->getProducts() as $p){
				foreach($p->getImages() as $i){
					if($i->displayOnCard()){ $images[] = $i; }
				}
			}
		}

		return $images;
	}

	function getAttachments(){
		return Attachment::GetAttachments($this);
	}

	/**
	 * Najde obrazky z variant produktu.
	 *
	 * Vynecha obrazky, ktere maji nastavenou vlastnost display_on_card na false
	 */
	function getProductImages($options = array()) {
		$images = array();
		foreach($this->getProducts() as $product) {
			$images = array_merge($images, $product->getImages());
		}
		$displayable_images = array();
		foreach($images as &$i) {
			if (!$i->displayOnCard()) {
				continue;
			}
			$displayable_images[] = $i;
		}
		return $displayable_images;
	}

	// Prvni obrazek
	function getImage($options = []){
		if(is_bool($options)){
			$options = ["consider_product_images" => $options];
		}
		$options += [
			"consider_product_images" => true,
		];
	
		// Obrazek z prvni varianty ma prednost pred obrazkem u teto karty
		// TODO: neni jasne proc! :)
		if($options["consider_product_images"] && $this->hasVariants()){
			if(($product = $this->getFirstProduct()) && ($i = $product->getImage(false))){
				return $i;
			}
		}

		$options["limit"] = 1;
		if($ar = $this->getImages($options)){
			return $ar[0];
		}
	}

	function hasVariants(){ return $this->getHasVariants(); }

	function canBeSwitchedToNonVariantMode(){
		$products = $this->getProducts(array("visible" => null));
		return sizeof($products)==0 || (sizeof($products)==1 && $products[0]->isVisible());
	}

	function createProduct($product_values) {
		$product_values["card_id"] = $this;
		$product = Product::CreateNewRecord($product_values);
		return $product;
	}

	/**
	 * $products = $card->getProducts();
	 */
	function getProducts($options = array()){
		return $this->_getProducts($options);
	}

	/**
	 * $product = $card->getFirstProduct();
	 */
	function getFirstProduct($options=array()){
		$options += array(
			"limit" => 1,
		);
		if($products = $this->_getProducts($options)){
			return $products[0];
		}
	}

	function getOrderableProducts($price_finder = null){
		$products = [];
		foreach($this->getProducts() as $product){
			if($product->canBeOrdered($price_finder)){
				$products[] = $product;
			}
		}
		return $products;
	}

	/**
	 * Is it possible to order at least one product on this card ordered?
	 *
	 *	$card->canBeOrdered(["region" => $SK]);
	 */
	function canBeOrdered($options = []){
		foreach($this->getProducts() as $p){
			if($p->canBeOrdered($options)){ return true; }
		}
		return false;
	}

	function toHumanReadableString(){
		return $this->getName();
	}

	protected function _getProducts($options = array()){
		$options += array(
			"deleted" => false, // false, true, null
			"visible" => true, // false, true, null

			"limit" => null,
			"order" => "rank, id",
		);

		$products_lists = Card::GetProductsList($this);

		$ids = array();
		foreach($products_lists as $item){
			if(!is_null($options["deleted"]) && $item["deleted"]!=$options["deleted"]){ continue; }
			if(!is_null($options["visible"]) && $item["visible"]!=$options["visible"]){ continue; }

			$ids[] = $item["id"];
		}

		return Cache::Get("Product",$ids);
	}


	function getCategoriesLister() {
		return $this->getLister("category", array("table_name" => "category_cards", "rank_field_name" => "rank_rev"));
	}

	function addToCategory($category) {
		if(!is_object($category)){ $category = Category::GetInstanceById($category); }
		return $category->addCard($this);
	}

	function removeFromCategory($category){
		if(!is_object($category)){ $category = Category::GetInstanceById($category); }
		$category->removeCard($this);
	}

	function getCategoryIds() {
		return $this->getCategoriesLister()->getRecordIds();
	}

	/**
	 *	$color_filter = Category::FindByCode("filter:color");
	 *	$colors = $card->getCategories(array("root_category" => $color_filter));
	 */
	function getCategories($options = array()) {
		$options += array(
			"consider_invisible_categories" => true,
			"consider_filters" => true,
			"root_category" => null,
			"filters_only" => false,
			"deduplicate" => false, // filters out categories that are listed in the paths of other categories
		);

		$categories = array();
		foreach($this->getCategoriesLister()->getRecords() as $c){
			if(!$options["consider_invisible_categories"] && !$c->isVisible()){ continue; }
			if(!$options["consider_filters"] && ($c->isFilter() || ($c->getParentCategory() && $c->getParentCategory()->isFilter()))){ continue; }
			if($options["filters_only"]){
				if(!$c->getParentCategory() || !$c->getParentCategory()->isFilter()){ continue; }
			}
			if($options["root_category"] && !$c->isDescendantOf($options["root_category"])){ continue; }
			$categories[] = $c;
		}

		if($options["deduplicate"]){
			// getting parents
			$parent_ids = array();
			foreach($categories as $c){
				while($p = $c->getParentCategory()){
					$parent_ids[] = $p->getId();
					$c = $p;
				}
			}
			// filtering
			$categories = array_filter($categories, function($c) use($parent_ids){ return !in_array($c->getId(),$parent_ids); });
			$categories = array_values($categories);
		}

		return $categories;
	}

	function getPrimaryCategory($options = []){
		$options += [
			"consider_invisible_categories" => false,
			"consider_filters" => false,
		];
		$categories = $this->getCategories($options);
		if($categories){
			return $categories[0];
		}
	}

	function getActiveFilters(){
		$categories = $this->getCategories(array(
			"consider_invisible_categories" => false,
			"filters_only" => true,
		));

		$filters = array();
		foreach($categories as $c){
			$filter = $c->getParentCategory();
			$filters[$filter->getId()] = $filter;
		}
		$filters = array_values($filters);

		return $filters;
	}

	function getCardSections(){
		return CardSection::FindAll("card_id",$this,array(
			"order_by" => "rank, id",
			"use_cache" => true,
		));
	}

	/**
	 *
	 *	$card->hasCardSection("tech_spec"); // true or false
	 */
	function hasCardSection($type_code){
		foreach($this->getCardSections() as $section){
			if($section->getTypeCode()==$type_code){ return true; }
		}
		return false;
	}

	/**
	 * Projde vsechny textove sekce a k nim prilozena vlozena videa.
	 * Vrati prvni instanci.
	 *
	 * @return EmbeddedVideo
	 */
	function getFirstEmbeddedVideoFromSections() {
		$embvid = null;
		foreach($this->getCardSections() as $cs) {
			if ($vids = $cs->getEmbeddedVideos()) {
				return array_shift($vids);
			}
		}
		return null;
	}

	function getRelatedCardsLister() {
		return $this->getLister("Card", array(
			"table_name" => "related_cards",
			"owner_field_name" => "card_id",
			"subject_field_name" => "related_card_id",
		));
	}

	function getRelatedCards() {
		return $this->getRelatedCardsLister()->getRecords();
	}

	function addRelatedCard($card) {
		return $this->_addRelatedCard($this->getRelatedCardsLister(),$card);
	}

	function removeRelatedCard($card) {
		return $this->_removeRelatedCard($this->getRelatedCardsLister(),$card);
	}

	function getViewableRelatedCards() {
		return array_filter($this->getRelatedCards(), function ($card) {
			return $card->isViewableInEshop() && $card->isVisible();
		} );
	}

	function getConsumablesLister() {
		return $this->getLister("Card", array(
			"table_name" => "consumables",
			"owner_field_name" => "card_id",
			"subject_field_name" => "consumable_id",
		));
	}

	function getConsumables() {
		return $this->getConsumablesLister()->getRecords();
	}

	function addConsumable($card) {
		return $this->_addRelatedCard($this->getConsumablesLister(),$card);
	}

	function removeConsumable($card) {
		return $this->_removeRelatedCard($this->getConsumablesLister(),$card);
	}

	function getViewableConsumables() {
		return array_filter($this->getConsumables(), function ($card) {
			return $card->isViewableInEshop() && $card->isVisible();
		} );
	}

	function getAccessoriesLister() {
		return $this->getLister("Card", array(
			"table_name" => "accessories",
			"owner_field_name" => "card_id",
			"subject_field_name" => "accessory_id",
		));
	}

	function getAccessories() {
		return $this->getAccessoriesLister()->getRecords();
	}

	function addAccessory($card) {
		return $this->_addRelatedCard($this->getAccessoriesLister(),$card);
	}

	function removeAccessory($card) {
		return $this->_removeRelatedCard($this->getAccessoriesLister(),$card);
	}

	function getViewableAccessories() {
		return array_filter($this->getAccessories(), function ($card) {
			return $card->isViewableInEshop() && $card->isVisible();
		} );
	}

	protected function _addRelatedCard($lister,$card){
		if (!is_object($card)) {
			$card = Card::GetInstanceById($card);
		}
		if ($card->getId() === $this->getId()) {
			throw new SameCardException("Can't insert card $card into itself");
		}
		if (!$lister->contains($card)) {
			return $lister->append($card);
		}
	}

	protected function _removeRelatedCard($lister,$card){
		if (!is_object($card)) {
			$card = Card::GetInstanceById($card);
		}
		if ($lister->contains($card)) {
			return $lister->remove($card);
		}
	}

	function isDeletable(){
		$p = Product::GetInstanceByCode("price_rounding");
		return $this->getId()!=$p->getCardId();
	}

	function isDeleted(){ return $this->getDeleted(); }
	function isVisible(){ return $this->getVisible(); }

	function isViewableInEshop(){
		//if($this->isDeleted()){ return false; }

		$product = $this->getFirstProduct(["deleted" => null, "visible" => null]);

		if($product){
			if(!$product->isVisible() && strlen($product->getCode())){
				// toto je nejaky systemovy produkt - napr. Zaohrouhleni
				return false;
			}
			//if($product->isDeleted()){ return false; }
		}

		return true;
	}

	function getBrand(){
		return Cache::Get("Brand",$this->getBrandId());
	}

	function destroy($delete_for_real = false){
		if($delete_for_real){
			return parent::destroy($delete_for_real);
		}

		if($this->isDeleted()){
			return null;
		}

		foreach($this->getProducts(["deleted" => null, "visible" => null]) as $p){
			$p->destroy();
		}

		foreach($this->getCategories() as $c){
			$c->removeCard($this);
		}

		Slug::DeleteObjectSlugs($this);

		$this->s(array(
			"deleted" => true,
		));
	}

	function getCollectionsLister() {
		return $this->getLister("Collections",array(
			"table_name" => "collection_cards",
		));
	}

	function getCollection() {
		return Collection::FindById($this->getCollectionId());
	}

	function getCollectionId() {
		if ($records = $this->getCollectionsLister()->getRecordIds()) {
			return $records[0];
		}
		return null;
	}

	function setCollection($collection) {
		$collection = Collection::FindById($collection);

		$lister = $this->getCollectionsLister();
		if ($_current_colection=$this->getCollection()) {
			$_current_colection->getCardsLister()->remove($this);
		}
		if (!is_null($collection)) {
			$lister->append($collection);
		}
	}

	function getExternalSourcesLister() {
		return $this->getLister("ExternalSources", array(
			"table_name" => "cards_external_sources",
		));
	}

	function getExternalSources() {
		return $this->getExternalSourcesLister()->getRecords();
	}

	function appendExternalSource($external_source) {
		$lister = $this->getExternalSourcesLister();
		if (!$lister->contains($external_source)) {
			return $this->getExternalSourcesLister()->append($external_source);
		}
		return false;
	}

	function removeExternalSource($external_source) {
		$this->getExternalSourcesLister()->remove($external_source);
	}

	/**
	 * Vrati dalsi karty ze stejne kolekce, jako je tato karta.
	 * Teda sadu bez teto karty.
	 */
	function getOtherCardsFromCollection() {
		if (!$_collection = $this->getCollection()) {
			return array();
		}
		$_cards = $_collection->getCards();
		$_cards2 = array();
		foreach($_cards as $idx => &$_c) {
			if ($_c->getId()==$this->getId()) {
				continue;
			}
			$_cards2[] = $_c;
		}
		return $_cards2;
	}

	/**
	 * Siblings from the given category
	 *
	 * If no category is given than primary category is considered
	 */
	function getCategorySiblings($category = null) {
		if(!$category){
			$category = $this->getPrimaryCategory();
		}
		if(!$category){
			return [];
		}
		$cards = $category->getCards();
		$_siblings = array();
		foreach($cards as $_c) {
			if ($_c->getId()==$this->getId()) {
				continue;
			}
			$_siblings[] = $_c;
		}
		return $_siblings;
	}

	function getViewableCategorySiblings($category = null) {
		return array_filter($this->getCategorySiblings($category), function ($card) {
			return $card->isViewableInEshop() && $card->isVisible();
		} );
	}

	function getAlternativeCards($options=array()) {
		$options = array_merge(array(
			"limit" => null,
		), $options);
		$cats = $this->getCategories();
		$alt_cards = $ids_taken = array();
		while($category = array_shift($cats)) {
			if (!$category->isVisible()) { continue; }
			if ($category->isFilter()) { continue; }

			foreach($this->getCategorySiblings($category) as $c){
				if(in_array($c->getId(),$ids_taken)){ continue; }

				$ids_taken[] = $c->getId();
				$alt_cards[] = $c;

				if(!is_null($options["limit"]) && sizeof($alt_cards)>=$options["limit"]){ break; }
			}

			if(!is_null($options["limit"]) && sizeof($alt_cards)>=$options["limit"]){ break; }
		}

		return $alt_cards;
	}

	function getTechnicalSpecifications(){
		return TechnicalSpecification::FindAll("card_id",$this);
	}

	/**
	 * Returns the first occurrence of TechnicalSpecification with the given key
	 *
	 *	echo $card->getTechnicalSpecification("weight"); // code
	 *	echo $card->getTechnicalSpecification("Weight"); // key
	 *	echo $card->getTechnicalSpecification(123);
	 *	echo $card->getTechnicalSpecification($tech_spec_key); // TechnicalSpecificationKey
	 *
	 * @return TechnicalSpecification
	 */
	function getTechnicalSpecification($key){
		static $KEYS;

		if(is_numeric($key) && ($obj = Cache::Get("TechnicalSpecificationKey",$key))){
			$key = $obj;
		}elseif(is_string($key) && ($obj = TechnicalSpecificationKey::GetInstanceByCode($key))){
			$key = $obj;
		}elseif(is_string($key) && ($obj = TechnicalSpecificationKey::GetInstanceByKey($key))){
			$key = $obj;
		}

		if(!is_object($key)){
			return null;
		}

		foreach($this->getTechnicalSpecifications() as $ts){
			if($ts->getTechnicalSpecificationKeyId()==$key->getId()){
				return $ts;
			}
		}
	}

	function setValues($values,$options=array()) {
		if (array_key_exists("collection_id", $values)) {
			$collection_id = $values["collection_id"];
			unset($values["collection_id"]);
			$this->setCollection($collection_id);
		}
		parent::setValues($values,$options);
	}

	function toArray() {
		$ary = parent::toArray();
		$ary["collection_id"] = $this->getCollectionId();
		return $ary;
	}

	/**
	 * Ziska finder modelu Card pro zadanou kategorii
	 *
	 * Finder je pripraveny se vsemi podminkami.
	 * Bere v uvahu hodnoty vracene filtracnim formularem.
	 *
	 * @param array $filter_d filtracni parametry:
	 * - d - seznam id designeru (tab. designers)
	 * - b - seznam id znacek (tab. brands)
	 * - c - seznam id kolekci (tab. collections)
	 * - available - pouze produkty, ktere jsou na sklade
	 * - items_for_lefthanded - boolean - pokud true, vyhledavame jen products s left_handed_only='t'; jinak ignorujeme
	 *
	 * - f - seznam id filtru (tab. categories s priznakem is_filter='t')
	 * 	- ve tvaru f[0-9]+ => array(integer,integer, ...) ; hodnota u f je id kategorie s nazvem filtru, hodnota/y v poli je seznam hodnot filtru (id podrizenych  kategorii)
	 */
	static function GetFinderForCategory($category, $filter_d = array(), $options = array()) {

		$options = array_merge(array(
			"search_entire_branch" => true, // search for cards in the given category and also in all its subcategories and so on (true) or search for cards only in the given category (false)?
			"limit" => 50,
			"offset" => 0,
			"order" => "default", // "default", "price_asc", "price_desc"
		),$options);

		$ORDERS = array(
			"default" => "
				category_cards.category_id=:this_category DESC, -- napred karty zarazene primo v dane kategorii
				category_cards.rank,
				category_cards.id
			",
			// TODO:
			//"price_asc" => "...",
			//"price_desc" => "..."
		);

		$order = $options["order"];
		$order = isset($ORDERS[$order]) ? $ORDERS[$order] : $ORDERS["default"];

		$filter_d += array(
			"b" => array(), # brands
			"d" => array(), # designers
			"c" => null, 		# collection_cards
			# v katalogu musi byt videt jen dostupne produkty
		);

		$conditions = $bind_ar = array();
		$tables = array("category_cards","cards");

		$bind_ar[":this_category"] = $category;
		
		$conditions[] = "category_cards.category_id IN :categories";
		if($options["search_entire_branch"]){
			$bind_ar[":categories"] = $category->getBranchCategoryIds();
		}else{
			$bind_ar[":categories"] = array($category->isPointingToCategory() ? $category->getPointingToCategory() : $category);
		}

		$conditions[] = "cards.id=category_cards.card_id";
		$conditions[] = "cards.visible='t'";
		$conditions[] = "cards.deleted='f'";

		if($filter_d["d"]){
			$conditions[] = "cards.designer_id IN :designers";
			$bind_ar[":designers"] = $filter_d["d"];
		}

		if($filter_d["b"]){
			$conditions[] = "cards.brand_id IN :brands";
			$bind_ar[":brands"] = $filter_d["b"];
		}

		if($filter_d["c"]) {
			$tables[] = "collection_cards";
			$conditions[] = "collection_cards.card_id=cards.id";
			$conditions[] = "collection_cards.collection_id=:collection_id";
			$bind_ar[":collection_id"] = $filter_d["c"];
		}

		foreach($filter_d as $k => $val){
			if(preg_match('/^f/',$k) && $val && is_array($val)){ // TODO: Pozor!! Prosakuje zde parametr z URL: http://atk14catalog.localhost/children/books/?from=20
				$conditions[] = "category_cards.card_id IN (SELECT card_id FROM category_cards WHERE category_id IN :$k)";
				$bind_ar[":$k"] = $val;
			}
		}

		$tables = join(",",$tables);
		$conditions = "(".join(") AND\n(",$conditions).")";
		$order = trim($order);

		$query = "
			SELECT card_id FROM (
				SELECT card_id,MIN(rownum) AS rownum FROM (
					SELECT card_id, ROW_NUMBER() OVER (ORDER BY\n$order\n) AS rownum
					FROM $tables
					WHERE $conditions
				)q GROUP BY card_id
			)q_grouped ORDER BY rownum
		";

		$query_count = "
			SELECT COUNT(DISTINCT card_id)
			FROM $tables
			WHERE $conditions
		";
	
		/*
		echo $query;
		print_r($bind_ar);
		exit; //*/

		return Card::Finder(array(
			"query" => $query,
			"query_count" => $query_count,
			"bind_ar" => $bind_ar,
			"offset" => $options["offset"],
			"limit" => $options["limit"],
			"order_by" => null,
		));
	}

	function isIndexable(){
		// If the product card is not listed in any category, it shall not be indexable
		if(!$this->getCategories([
			"consider_invisible_categories" => false,
			"consider_filters" => false,
		])){
			return false;
		}

		if(!$this->isVisible() || $this->isDeleted()){
			return false;
		}

		// Here is a place for custom conditions

		return true;
	}

	function getFulltextData($lang){
		Atk14Require::Helper("modifier.markdown");

		$fd = new \Textmit\FulltextData($this,$lang);

		foreach($this->getProducts() as $product){
			$fd->addText($product->getLabel(),"b");
			$fd->addText($product->getCatalogId(),"d");
		}

		$fd->addText($this->getName($lang),"a");

		$fd->addHtml(smarty_modifier_markdown($this->getTeaser($lang)),"c");

		if($brand = $this->getBrand()){
			$fd->addText($brand->getName(),"c");
		}

		foreach($this->getCardSections() as $cs){
			$fd->merge($cs->getFulltextData($lang),[
				"a" => "b",
				"b" => "c",
				"c" => "d",
			]);
		}

		foreach($this->getTechnicalSpecifications() as $ts){
			$fd->merge($ts->getFulltextData($lang),[
				"a" => "b",
				"b" => "c",
				"c" => "d",
			]);
		}

		foreach($this->getTags() as $t){
			$fd->addText($t->getTagLocalized($lang),"b");
		}

		foreach(CardCreator::GetCreatorsForCard($this) as $cc){
			$fd->addText($cc->getCreator()->getName(true,$lang),"b");
		}

		return $fd;
	}
}

class SameCardException extends Exception {}

