<?php
class Category extends ApplicationModel implements Translatable, Rankable, iSlug, \Textmit\Indexable {

	use TraitGetInstanceByCode;
	use TraitTags;

	static function GetTranslatableFields() { return array("name","long_name","teaser","description", "page_title", "page_description"); }

	var $sqlConditionForCardsIdBranchCreated=0;

	function setRank($new_rank){
		$this->_setRank($new_rank,array("parent_category_id" => $this->getParentCategoryId()));
	}

	static function CreateNewRecord($values, $options=array()) {
		$values += array(
			"parent_category_id" => null,
			"pointing_to_category_id" => null,
		);
		$parent = Category::FindById($values["parent_category_id"]);
		$target = Category::FindById($values["pointing_to_category_id"]);
		if ($target && $target->hasNestedCategory($parent)) {
			throw new NestedAliasException("Can not create alias to superior category");
		}
		return parent::CreateNewRecord($values,$options);
	}

	static function GetCategories($parent_category,$options = array()){
		$options += array(
			"use_cache" => true,
		);
		return Category::FindAll("parent_category_id",$parent_category,$options);
	}

	/**
	 * Prefetches all parents for the given category into the cache
	 */
	static function PrecacheParentsForCategory($category){
		static $parents;
		if(is_null($category)){ return; }
		if(is_null($parents)){
			$dbmole = self::GetDbMole();
			$parents = $dbmole->selectIntoAssociativeArray("SELECT id,parent_category_id FROM categories");
		}
		$id = TableRecord::ObjToId($category);
		Cache::Prepare("Category",$id);
		while(isset($parents[$id])){
			Cache::Prepare("Category",$parents[$id]);
			$id = $parents[$id];
		}
	}

	/**
	 * Prefetches all parents for all the given categories into the cache
	 */
	static function PrecacheParentsForCategories($categories){
		foreach($categories as $category){
			self::PrecacheParentsForCategory($category);
		}
	}

	function realMeId() { return $this->getPointingToCategoryId()?:$this->getId();}
	function realMe() { return $this->getPointingToCategoryId()?$this->getPointingToCategory():$this;}

	/**
	 * Vrati pole kategorii (jak jdou po ceste od korene)
	 * Pokud dana cesta neexistuje, vrati null
	 *
	 * ```
	 * $categories = Category::GetInstancesOnPath("mistnosti/jidelna/stul");
	 * $categories["mistnosti"]->getSlug(); //mistnosti
	 * $categories["mistnosti/jidelna"]->getSlug(); //jidelna
	 * $categories["mistnosti/jidelna/stul"]->getSlug(); //stul
	 * ```
	 */
	static function GetInstancesOnPath($path, &$lang = null, $start = null, $options = []) {
		$options += array(
			"dealias" => true,
		);

		$dealias = $options["dealias"];
		unset($options["dealias"]);

		$orig_lang = $lang;

		$path = (string)$path;
		if(!strlen($path)){ return []; }

		if(is_object($start)) {
			$parent_category_id = $start->getId();
		} else {
			$parent_category_id = $start;
		}
		$out = [];

		$cpath = '';
		foreach(explode("/",$path) as $slug){
			if(!$c = static::GetInstanceBySlug($slug,$lang,$parent_category_id,$options)){
				$lang = $orig_lang; // nenechame nastaveny $lang na nejakou necekanou hodnotu
				return null;
			}
			$dealias && ($c = $c->realMe());
			$cpath .= "/$slug";
			$out[substr($cpath,1)] = $c;
			$parent_category_id = $c->getId();
		}
		return $out;
	}

	/**
	 * $jidelna = Category::GetInstanceByPath("mistnosti/jidelna");
	 */
	static function GetInstanceByPath($path, &$lang = null, $start = null){
		$out = self::GetInstancesOnPath($path, $lang, $start);
		if(is_null($out)) { return null ; }
		if($out === []){ return $start; }
		return end($out);
	}

	/**
	 *
	 *	$catalog = Category::GetInstanceByName(null,"Catalog");
	 *	$shoes = Category::GetInstanceByName($catalog,"Shoes");
	 */
	static function GetInstanceByName($parent_category,$name,&$lang = null){
		global $ATK14_GLOBAL;

		$name = (string)$name;
		$categories = $parent_category ? $parent_category->getChildCategories() : Category::FindAll("parent_category_id",null);

		$langs = $lang ? [$lang] : $ATK14_GLOBAL->getSupportedLangs();
		foreach($categories as $category){
			foreach($langs as $l){
				if((string)$category->g("name_$l")===$name){
					$lang = $l;
					return $category;
				}
			}
		}
	}

	static function GetInstancesOnNamePath($path, &$lang = null){
		$orig_lang = $lang;

		$path = (string)$path;
		if(!$path){ return null; }

		$my_path='';
		$slugs = explode("/",$path);
		$parent_category = null;

		$out = array();

		$cpath = '';
		foreach(explode('/',$path) as $name){
			if(!$c = Category::GetInstanceByName($parent_category,$name,$lang)){
				$lang = $orig_lang; // nenechame nastaveny $lang na nejakou necekanou hodnotu
				return null;
			}
			$c = $c->realMe();
			$cpath .= "/$name";
			$out[] = $c;
			$parent_category = $c;
		}
		return $out;
	}

	static function GetInstanceByNamePath($path,&$lang = null){
		$out = self::GetInstancesOnNamePath($path, $lang);
		if(!$out) { return null ; }
		return end($out);
	}

	/**
	 * Pouze viditelne podkategorie.
	 */
	function getVisibleChildCategories(){
		return Category::FindAll("parent_category_id",$this,"visible",true,array("use_cache" => true));
	}

	/**
	 * Sousedici kategorie
	 */
	function getNeighbouringCategories($options = array()){
		$out = array();
		foreach(Category::GetCategories($this->getParentCategoryId(),$options) as $c){
			if($c->getId()==$this->getId()){ continue; }
			$out[] = $c;
		}
		return $out;
	}

	function hasChildCategories(){ return !!$this->getChildCategories(array("limit" => 1)); }

	function isFilter(){ return $this->getIsFilter(); }

	function isSubcategoryOfFilter(){
		$parent = $this->getParentCategory();
		return $parent && $parent->isFilter();
	}

	function getName($lang = null){
		return parent::getName($lang);
	}

	function getLongName($lang = null){
		$out = parent::getLongName($lang);
		if(strlen((string)$out)){ return $out; }
		return parent::getName($lang);
	}

	function getPageTitle($lang = null){
		$out = parent::getPageTitle($lang);
		if(strlen((string)$out)){ return $out; }
		return $this->getLongName($lang);
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

	function isVisible($check_parent_visibility = true){
		$visible = $this->g("visible");
		if(!$visible){ return false; }
		if($check_parent_visibility){
			$parent = $this->getParentCategory();
			if($parent){ return $parent->isVisible(); }
		}
		return true;
	}

	function isPointingToCategory(){ return !is_null($this->getPointingToCategoryId()); }
	function isAlias(){ return $this->isPointingToCategory(); }

	function getPointingToCategory(){ return Category::GetInstanceById($this->getPointingToCategoryId()); }

	function getSlugSegment(){
		return (string)$this->getParentCategoryId();
	}

	function getSlugPattern($lang){ return $this->g("name_$lang"); }

	function getParentCategory(){ return Cache::Get("Category",$this->getParentCategoryId()); }

	function isDescendantOf($root_category){
		if($root_category->getId()==$this->getId()){ return true; }
		if($parent = $this->getParentCategory()){
			return $parent->isDescendantOf($root_category);
		}
		return false;
	}

	/**
	 * var_dump($category->getPathOfCategories()); // array($base,$parent,$category);
	 */
	function getPathOfCategories(){
		$out = array($this);
		$c = $this;
		while($p = $c->getParentCategory()){
			$out[] = $p;
			$c = $p;
		}
		return array_reverse($out);
	}

	function getRootCategory(){
		$out = $this;
		while($parent = $out->getParentCategory()){
			$out = $parent;
		}
		return $out;
	}

	function isRootCategory() {
		return is_null($this->getParentCategoryId());
	}

	function getAvailableFilters($options = array()){
		$options += array(
			"consider_child_categories" => true,
			"visible" => null,
		);

		$filters = array();

		if($options["consider_child_categories"]){
			foreach($this->getChildCategories() as $c){
				if($c->isFilter()){ $filters[$c->getId()] = $c; }
			}
		}
		foreach($this->getNeighbouringCategories() as $c){
			if($c->isFilter()){ $filters[$c->getId()] = $c; }
		}
		if($p = $this->getParentCategory()){
			if($p->isFilter()){ $filters[$p->getId()] = $p; }
			$filters += $p->getAvailableFilters(array("consider_child_categories" => false));
		}

		if(!is_null($options["visible"])){
			$visible = (bool)$options["visible"];
			$filters = array_filter($filters,function($filter) use($visible){ return $filter->isVisible() ^ !$visible; }); // XOR
		}

		return array_values($filters);
	}

	
	/**
	 * echo $jidelna->getPath(); // "mistnosti/jidelna"
	 */
	function getPath($lang = null){
		$slugs = array($this->getSlug($lang));
		$c = $this;
		while($p = $c->getParentCategory()){
			$slugs[] = $p->getSlug($lang);
			$c = $p;
		}
		$slugs = array_reverse($slugs);
		return join('/',$slugs);
	}

	function getNamePath($lang = null, $options=array()){
		$options += array(
			"glue" => "/",
		);
		$slugs = array($this->getName($lang));
		$c = $this;
		while($p = $c->getParentCategory()){
			$slugs[] = $p->getName($lang);
			$c = $p;
		}
		$slugs = array_reverse($slugs);
		return join($options["glue"],$slugs);
	}

	function getCardsLister(){
		return $this->getLister("Cards");
	}

	function getCardIds() {
		return $this->getCardsLister()->getRecordIds(["preread_data" => false]);
	}

	function getCards(){
		return $this->getCardsLister()->getRecords(["preread_data" => false]);
	}

	function getVisibleCards($options = []){
		$options += [
			"limit" => null,
		];
		$cards = array_filter($this->getCards(),function($card){ return $card->isVisible() && !$card->isDeleted(); });
		if($options["limit"]){
			$cards = array_slice($cards,0,$options["limit"]);
		}
		return array_values($cards);
	}
	
	/**
	 * Adds a card into this category
	 *
	 * Actually it inserts the card at the beginning of the card list.
	 */
	function addCard($card,$options = []){
		$options += [
			"first" => true,
		];

		if($this->isFilter()){
			throw new Exception("Can't insert card $card into filter category $this");
		}
		if($this->isAlias()){
			throw new Exception("Can't insert card $card into alias category $this");
		}

		// Using CardsLister can consume very much memory in a large catalog
		//$lister = $this->getCardsLister();
		//if(!$lister->contains($card)) {
		//	if($options["first"]) {
		//		return $lister->prepend($card);
		//	} else {
		//		return $lister->append($card);
		//	}
		//}

		if(0===$this->dbmole->selectInt("SELECT COUNT(*) FROM category_cards WHERE category_id=:category_id AND card_id=:card_id",[":category_id" => $this, ":card_id" => $card])){
			if($options["first"]){
				$MIN = "MIN";
				$delta = -1;
			}else{
				$MIN = "MAX";
				$delta = 1;
			}
			$this->dbmole->insertIntoTable("category_cards",[
				"category_id" => $this,
				"card_id" => $card,
				"rank" => $this->dbmole->selectInt("SELECT COALESCE($MIN(rank)+:delta,0) FROM category_cards WHERE category_id=:category_id",[":category_id" => $this,":delta" => $delta]),
			]);
		}
	}

	function getRecommendedCardsLister() {
		return $this->getLister("RecommendedCards", array("class_name" => "Card", "subject_field_name" => "card_id"));
	}

	function getRecommendedCards() {
		return $this->getRecommendedCardsLister()->getRecords();
	}

	function addRecommendedCard($card){
		if($this->isFilter()){
			throw new Exception("Can't insert card $card into filter category $this");
		}
		if($this->isAlias()){
			throw new Exception("Can't insert card $card into alias category $this");
		}
		$lister = $this->getRecommendedCardsLister();
		if(!$lister->contains($card)) {
			return $lister->append($card);
		}
	}

	function removeRecommendedCard($card) {
		return $this->getRecommendedCardsLister()->remove($card);
	}

	function isDeletable(){
		$parent_category_id = $this->getParentCategoryId();

		if(is_null($parent_category_id)){
			// koren -> pokud ma nejake deti, nelze smazat
			return !Category::FindFirst("parent_category_id",$this);
		}
		return !is_null($parent_category_id);
	}

	function getImage() {
		return $this->getImageUrl();
	}

	/**
	 * Can products be added to this category?
	 *
	 */
	function allowProducts() {
		return !$this->isFilter() && !$this->isAlias();
	}

	/**
	 * Can subcategories be added to this category?
	 * 
	 */
	function allowSubcategories() {
		return !$this->isSubcategoryOfFilter() && !$this->isAlias();
	}

	/**
	 * Can this category be moved somewhere else?
	 *
	 */
	function canBeMoved(){
		return !$this->isSubcategoryOfFilter();
	}

	/**
	 * Can a new category be created as an alias to this category?
	 *
	 */
	function canBeAliased(){
		return
			!$this->isFilter() &&
			!$this->isSubcategoryOfFilter() &&
			!$this->isAlias();
	}

	function destroy($destroy_for_real = null){
		foreach($this->getChildCategories(array("follow_symlinks" => false)) as $ch){
			$ch->destroy($destroy_for_real);
		}
		return parent::destroy($destroy_for_real);
	}

	function removeCard($card){
		return $this->getCardsLister()->remove($card);
	}

	/**
	 * Zjisti, jestli je zadana kategorie vnorena pod aktualni kategorii.
	 *
	 * Lze tak zjistit moznost zacykleni.
	 *
	 * @param Category $checked_category kategorie, u ktere overujeme vnoreni
	 *
	 * @return bool true - $checked_category je vnorena v aktualni kategorii; false - neni vnorena
	 */
	function hasNestedCategory($checked_category) {
		while (!is_null($checked_category)) {
			if ($checked_category->getId()==$this->getId()) {
				return true;
			}
			$checked_category = $checked_category->getParentCategory();
		}
		return false;
	}

	/**
	 * Vrati idecka kategorii v cele vetvi, ktera zacina touto kategorii.
	 *
	 * $ids = $category->getBranchCategoryIds(); 
	 *
	 * Nejmensi vetev muze obsahovat pouze array($category->getId())
	 */
	function getBranchCategoryIds(){
		// $categories: ve kterych kategoriich hledame produktove karty
		// hledaji se vsechna id do nejposlednejsiho zanoreni
		$dbmole = Category::GetDbMole();
		$categories = array($this->getId());
		$_current_parents = $categories;
		while(1){
			$_categories = $dbmole->selectIntoArray("
				SELECT COALESCE(pointing_to_category_id,id) FROM categories WHERE
					parent_category_id IN :current_parents AND
					visible='t' AND
					is_filter='f'
			",array(":current_parents" => $_current_parents),"integer");
			if(!$_categories){ break; }
			# kontrola, ze se mezi vracenymi id nenachazi nejake, ktere uz mame z predchozich pruchodu
			# to by znamenalo zacykleni; proto ono id vyhodime
			foreach($_categories as $idx => &$item) {
				if (in_array($item, $categories)) {
					unset($_categories[$idx]);
				}
			}
			$_current_parents = $_categories;
			foreach($_categories as $_id){ $categories[] = $_id; }
		}
		return $categories;
	}

	function getBranchCategories(){
		return Cache::Get("Category",$this->getBranchCategoryIds());
	}

	function toString(){
		return (string)$this->getName();
	}

	function isIndexable(){
		if(!$this->isVisible() || $this->isFilter()){
			return false;
		}
		if($parent = $this->getParentCategory()){
			return $parent->isIndexable();
		}
		return true;
	}

	function getFulltextData($lang){
		Atk14Require::Helper("modifier.markdown");

		$fd = new \Textmit\FulltextData($this,$lang);

		$fd->addText($this->getName($lang),"a");

		$fd->addHtml(smarty_modifier_markdown($this->getTeaser($lang)),"b");
		$fd->addHtml(smarty_modifier_markdown($this->getDescription($lang)));

		return $fd;
	}

	function containsTag($tag,$options = []){
		static $CACHE = [];

		$options += [
			"consider_parents" => false,
		];

		$consider_parents = $options["consider_parents"];

		$tag = $this->_cleanTag($tag);
		if(!$tag){ return false; }

		$cache_key = join(",",[$this->getId(),$tag->getId(),$consider_parents ? 1 : 0]);
		$direct_cache_key = join(",",[$this->getId(),$tag->getId(),0]);

		if(isset($CACHE[$cache_key])){ return $CACHE[$cache_key]; }

		if(isset($CACHE[$direct_cache_key]) && ($CACHE[$direct_cache_key] || !$consider_parents)){
			$CACHE[$cache_key] = $CACHE[$direct_cache_key];
			return $CACHE[$direct_cache_key];
		}

		if(!isset($CACHE[$direct_cache_key])){
			$CACHE[$direct_cache_key] = $this->getTagsLister()->contains($tag);
		}

		if($CACHE[$direct_cache_key]){
			$CACHE[$cache_key] = true;
			return true;
		}

		if($consider_parents){
			$c = $this->getParentCategory();
			while($c){
				$direct_cache_key = join(",",[$c->getId(),$tag->getId(),0]);
				if(!isset($CACHE[$direct_cache_key])){
					$CACHE[$direct_cache_key] = $c->getTagsLister()->contains($tag);
				}
				if($CACHE[$direct_cache_key]){
					$CACHE[$cache_key] = true;
					return true;
				}
				$c = $c->getParentCategory();
			}
		}

		if(!isset($CACHE[$cache_key])){
			$CACHE[$cache_key] = false;
		}

		return $CACHE[$cache_key];
	}
	function hasTag($tag,$options = []) { return $this->containsTag($tag,$options); }

	/**
	 * Vytvori SQL podminku pro karty, ze nalezi do dane kategorie (a podkategorii).
	 * Predpocita si ji v temporary SQL tabulce, takze vic dotazu na stejnou vec
	 * (napr. generovanych pri pouziti filtru) je rychlejsich, nez kdyz by se stejna
	 * podminka delala vzdy znova (nebo se prenasely mraky idcek na klienta a z5).
	 *
	 * list($cond, $bind) = $category->sqlConditionForCardsIdBranch('card.id');
	 * Card::Finder([
	 *  'condition' => $cond,
	 *  'bind' => $bind
	 *])
	 * Ted to nevraci zadny bind, ale pro obecnost to radsi bind vracet necham.
	 **/
	function sqlConditionForCardsIdBranch($field, $options = []) {
		$id = $this->getId();
		$opts = $options + [
			'force_reread' => false,
			'is_filter' => false,
			'dealias' => true,
			'visible' => true,
			'self' => true,
			'name' => 'CategoryCardsBranchIds' . $id,
			'categories_table' => false #returns also table containing all subcategories
		];
		$name = $opts['name'];
		unset($options['categories_table']);
		$level = $opts['categories_table'];
		$category = $name. "Categories";

		if($this->sqlConditionForCardsIdBranchCreated < $level || $options) {
			list($sql, $bind) = static::getSubtreeOfSql($this, $opts);
			if($level == 2) {
				$query = "CREATE TEMPORARY TABLE $category AS ( $sql ); ";
				$sql = "SELECT * FROM $category";
			} else {
				$query = "";
			}
			if($options || $this->sqlConditionForCardsIdBranchCreated == 0) {
				$query.="CREATE TEMPORARY TABLE $name AS ( SELECT distinct card_id as id FROM category_cards WHERE category_id IN ($sql));";
			}
			$this->dbmole->doQuery($query, $bind);
		}
		if(!$options) {
			$this->sqlConditionForCardsIdBranchCreated = $level;
		}

		$sql = "$field IN (SELECT $name.id FROM $name)";
		if($level == 2) {
				 return array($sql, [], $category);
		} else {
				 return array($sql, []);
		}
	}

	/**
	 * $category = Category::GetSubtreeOfSql($category);
	 * Categories::GetInstanceById($category);
	 */
	static function GetSubtreeOf($ids, $options = []) {
		list($sql, $bind) = static::GetSubtreeOfSql($ids, $options);
		return array_map('intval', self::GetDbMole()->selectIntoArray(
				$sql, $bind
		));
	}

	/**
	 * $category = Category::GetSubtreeOfSqlAssociative($category, ['return_cards_count' => true]);
	 * Categories::GetInstanceById(array_keys($category));
	 * foreach($category as $c) {
	 * }
	 */
	static function GetSubtreeOfAssociative($ids, $options = []) {
		list($sql, $bind) = static::GetSubtreeOfSql($ids, $options);
		return array_map('intval', self::GetDbMole()->selectIntoAssociativeArray(
				$sql, $bind
		));
	}

	/**
	 * list($sql, $bind) = Category::GetSubtreeOfSql($category);
	 * $dbmole->selectIntoArray($sql, $bind);
	 * >> [ List of ids of all categories in given subtree ]
	 * call_user_func_array([$dbmole, 'selectRows'], Category::GetSubtreeOfSql($category, ['return_parent_id' => true ]));
	 * >> [ ['id' => $category->getId(), 'parent_id' => null, ]
	 * >>   ['id' => child_id, 'parent_id => $category->getId() ], .... ]
	 * call_user_func_array([$dbmole, 'selectRows'], Category::GetSubtreeOfSql($category, ['return_cards_count' => true, 'card_filter' => $filter, visible => true, is_filter => false ]));
	 * >> [ ['id' => $category->getId(), 'cards_count' => 75, ]
	 * >>   ['id' => child_id, 'cards_count' => 20 ], .... ]
	 */
	static function GetSubtreeOfSql($ids, $options = []) {

		$options += [
			'self' => true,            //input categories will be in ouput (#TODO: incompatibile with direct_children_only)
															   //'force' mean include me even if dont satisfy other requirements (e.g. visible, filter)
			'visible' => null,         //if not null, returns only categories with given visible tag
			'is_filter' => null,       //if not null, returns only categories with given filter tag
			'dealias' => false,        //return id of real kategories, not symlinks
			'dealiased_input' => false,//no need to dealias input ids (thus there is no alias in input)
			'follow_symlinks' => true, //descend into alias categories
			'level' => null,           //do not descend deeper than ... levels. Input $ids have level 0, children of input have level 1 etc.
			'min_level' => null,       //discard categories with level lower than 'min_level' from result
			'order_by' => 'rank ASC, id',    //order of returned categories
			'direct_children_only' => false, //do not returns subsubcategories nor me, same as 'self'=false and 'level'=1

			'has_cards' => false,		//true: do not return categories, that are empty (no cards in subtree) -- possible value 'any' means has a card with default filter, even if cards_filter is set
			'cards_filter' => null, //filter for cards, affecting 'has_cards' and 'return_cards_count'

			'return_id' => true,			//returns id in result
			'no_aliases' => false,                 //nelezt do aliasu	
			'return_cards_count' => false,	//returns count of cards in given subtree for each category
			'return_parent_id' => false,			//returns parent_id for each card in result
			'return_real_id' => false,			//returns real_id COALESCE(pointing_to_category_id or id) for each card
			'return_level' => false, 	//returns level (from input category) in result. Require level set to avoid infinite loop
			'return_original_id' => false, //returns join $ids => $child_category
		                                       //only valid for simple recursive query
			'limit' => null,

			'conditions' => [],
			'bind_ar' => [],
		];

		$cards = $options['return_cards_count'] || $options['has_cards'];


		if($options['direct_children_only'] && $cards) {
			$options['direct_children_only'] = false;
			$options['self'] = false;
			$options['level'] = 1;
		} elseif($options['level'] == 1 && !$options['self'] && !$cards) {
			$options['direct_children_only'] = true;
		}
		#If I sould not follow symlinks, do not dealias input
		$options['dealiased_input'] = !$options['follow_symlinks'] || $options['dealiased_input'];

		/** Nastaveni podminek where **/
		$filter = $options['conditions'];
		if(is_array($filter)) {
			$filter = implode(' AND ', $filter);
		}
		if($filter) {
			$filter = " AND $filter";
		}
		$bind = $options['bind_ar'];

		if(is_bool($options['is_filter'])) {
			$filter .= $options['is_filter']?" AND is_filter":" AND NOT is_filter";
		}
		if(is_bool($options['visible'])) {
			$filter .= $options['visible']?" AND visible":" AND NOT visible";
		}
		if($options['no_aliases']) {
			$filter .= ' AND pointing_to_category_id IS NULL';
		}

		if(is_array($ids)) {
			if(!$ids) { return array('SELECT 1 WHERE False', []); };
			#na tenhle nazev parametru trochu spoleha Cards::GetSqlConditionsForCards
			$bind[':categories'] = $ids;
			$operator = 'IN :categories';
		} elseif($ids === null) {
			$operator = 'IS NULL';
			$options['dealiased_input'] = true;
			$options['self'] = false;
		} elseif($ids === false) {
			$operator = false;
		} elseif(is_string($ids)) {
			$operator = $ids;
		} else {
			$operator = '= :categories';
			$bind[':categories'] = $ids;
		}
		if($options['return_real_id']) {
			$options['dealias'] = false;
		}

		if($options['direct_children_only'] or $operator === false) {
			$fields = '';
			/** Budto chci jen podrizene, pak je to ciste jednoduchy sql dotaz **/
			$join_field = 'id';
			if($operator !== false) {
				$condition = $options['dealiased_input']?"parent_category_id $operator":"parent_category_id IN (SELECT COALESCE(pointing_to_category_id,id) FROM categories WHERE id $operator)";
			} else {
				$condition ='1=1 ';
			}
			if( $options['return_id']) {
				$fields = $options['dealias'] ? ',COALESCE(pointing_to_category_id,id) as id':',id';
			}
			if($options['return_parent_id']) {
				$fields.=',parent_category_id';
			}
			if($options['return_real_id']) {
				$fields.=',COALESCE(pointing_to_category_id,id) as real_id';
			}

			if ($options["order_by"]) {
					$order = "ORDER BY " . $options['order_by'];
			} else {
					$order = '';
			}
			$fields = substr($fields, 1);
			$sql = "SELECT $fields FROM (select * FROM categories WHERE $condition $filter $order) q";
		} else {

			/** Anebo chci cely podstrom **/
			if($options['return_id']) {
				$fields['id'] = $options['dealias'] ? 'real_id':'id';
			}

			if($options['return_parent_id'] || $cards) {
				if($options['return_parent_id']) {
					$fields['parent_category_id']='parent_category_id';
				}
				$parent_name = ", parent_category_id";
				$parent_start = " ,NULL::int";
				$parent = $options['dealias'] ?
						" ,tree.real_id as parent_category_id" :
						" ,tree.id as parent_category_id" ;
					;
				$preorder = "parent_category_id,";
			} else {
				$parent_name = $parent_start = $parent = '';
				$preorder = '';
			}

			$real_id = 'COALESCE(pointing_to_category_id,c.id)';
			$id = $options['dealias'] ? $real_id  : 'c.id';
			$link_id = $options['follow_symlinks']?'real_id':'id';
			$start_field = ($options['self'] || !$options['dealiased_input'])?'id':'parent_category_id';


			if($options['return_original_id']) {
				$original_start = ", $start_field";
				$original_field = ", original_id";
				$original_name = ", original_id";
				$fields['original_id']= "original_id";
			} else {
				$original_start = '';
				$original_field = '';
				$original_name = '';
			}

			if($options['self'] == 'force') {
				$startfilter = "";
			} else {
				$startfilter = $filter;
			}
			if($options['return_real_id']) {
				$fields['real_id'] ='real_id';
			}

			if(!$options['self'] && !$options['dealiased_input']) {
				$where_result = "AND NOT id $operator";
				$startfilter = "";
			} else {
				$where_result = '';
			}

			if($options['level']) {
					if($cards) {
						$where_result .= " AND level <= :level";
					} else {
						#level is the parent's level
						$filter .= " AND level <= :level-1";
					}
					$bind[':level'] = $options['level'];
					if($options['min_level']) {
						$bind[':min_level'] = $options['min_level'];
						$where_result .= ' AND level >= :min_level';
					}
					$preorder="level, $preorder";
					$level_name = ', level';
					$level_name_tree = ', tree.level';
					$level_start = ($options['self'] || !$options['dealiased_input']) ?',0 ':',1 ';
					$level = ',tree.level + 1';
					if($options['return_level']) {
						$fields['level'] = 'level';
					}
			} else {
					#Kdyz nefiltruju dle levelu, tak tam level nesmi byt! Jinak může dojít k zacykleni (takhle ho řeší UNION BEZ ALL)
					$level_name = $level_name_tree = $level_start = $level = '';
					$preorder = '';
			}

			$cards = $options['has_cards'] || $options['return_cards_count'];

			$fields_select = '';
			foreach($fields as $k => $v) {
				$fields_select.=", $v as $k";
			}
			$fields_select = substr($fields_select, 2);
			$fields_group = implode(', ', $fields);
			if ($options["order_by"]) {
						$order_fields = $preorder . $options['order_by'];
						$order = "ORDER BY $order_fields";
						$fields_group .= ", ".preg_replace('/\s(ASC|DESC)\s*(,|$)/i','\2',$order_fields);
			} else {
						$order = '';
			}

			//Tendle kus proleze vsechny podrizene kategorie.
			$sql = "WITH RECURSIVE tree(id, real_id $parent_name $original_name $level_name, rank) AS (
				  SELECT $id, $real_id $parent_start $original_start $level_start, rank FROM
								categories c WHERE $start_field $operator
								$startfilter
					UNION
							SELECT $id, $real_id $parent $original_field $level, c.rank FROM categories c
							JOIN tree ON (c.parent_category_id = tree.$link_id)
						  WHERE TRUE
						  $filter
				)";
			if($cards) {
				//Kdyz chci jen s kartama, tak musim
				// - vygenerovat seznam kategorie - id všech podrizených kategorií (members)
				// - zjistit, kde jsou karty
				// - a pak to pro kazdou kategorii zvlast (duplicity!) poscitat/nebo to dle te
				//    tabulky vyfiltrovat

				// Seznam vsech relati predek - potomek (explicitne vyjadrena tranzitivita)
				// Lezu od vsech uzlu stromu zpet nahoru
				$with = $sql.", members(parent_id, child_id) as (
					SELECT id, real_id FROM tree
						UNION
					SELECT tree.parent_category_id, members.child_id FROM tree JOIN members
					ON (members.parent_id = tree.id) WHERE tree.parent_category_id IS NOT NULL
				)";

			// Karty v kategoriich
			$cards_filter = $options['cards_filter'] ;
			$fce = function($table, &$cards_filter=null) use (&$bind) {
					$cards_filter = $cards_filter ?: new FilterForCards(User::GetAnonymousUser(), ['add_sections' => false, 'materialize_empty' => false, 'materialize_result' => false]);
					$result = $cards_filter->result();
					$result->join.= ' JOIN category_cards ccc ON (cards.id = ccc.card_id)';
					$subquery = $result->select("ccc.category_id as cat_id, cards.id as card_id", ['add_options' => false]);
					$bind+=$result->bind;
					return ", $table as (\n $subquery \n )";
				};
				$with .= $fce('catcards', $cards_filter);

				$subtable = " members ";
				if($options['has_cards'] === 'any' && $cards_filter->isFiltered() && $options['return_cards_count']) {
						//Cards count are by different filter than listed categories
						$with .= $fce('catcards2');
						$subtable .= "INNER JOIN catcards2 ON (members.child_id = catcards2.cat_id)";
				} else {
						$options['has_cards'] = (bool) $options['has_cards'];
				}
				$cjoin = $options['has_cards'] === true ? 'INNER' : 'LEFT';
				$subtable .= " $cjoin JOIN catcards ON (members.child_id = catcards.cat_id)";

				if($options['return_cards_count']) {
					// - a poscitat to: to musim az tady, protoze duplicity karet v kategoriich
					$fields_select.=", COALESCE(COUNT(DISTINCT catcards.card_id),0) as cards_count";
					$sql= "$with \nSELECT $fields_select FROM tree
												JOIN ($subtable)
												ON (members.parent_id = tree.id)
												WHERE TRUE
												$where_result
												GROUP BY members.parent_id, $fields_group
												$order";
				} else {
					$cond = "AND tree.id IN (\n SELECT parent_id FROM $subtable )";
					$sql= "$with \nSELECT $fields_select FROM tree \n WHERE TRUE $where_result $cond \n $order";
				}
		} else {
				//Jinak staci selectit jen z tree, ale musi tu byt distinct kvuli level fieldu
				if($order) {
					$sql .=  "\n SELECT DISTINCT ON($fields_group) $fields_select from tree WHERE TRUE $where_result $order";
				} else {
					$sql .=  "\n SELECT DISTINCT $fields_select from tree WHERE TRUE $where_result $order";
				}
			}
		}

		if (isset($options["limit"])) {
			$limit = max((int)$options["limit"],0);
			$sql = "SELECT * FROM ($sql LIMIT ".(int)$options["limit"].") qlimit";
		}

		#echo $sql,"\n\n\n";
		return array($sql, $bind);
	}

	/** Just child categories (no subsubcategories, not self) **/
	function getChildCategories($options = []) {
		$out = $this->getChildCategoriesIds($options);
		return Cache::Get(get_called_class(), $out );
	}

	/** Just child category ids (no subsubcategories, not self) **/
	function getChildCategoriesIds($options = []) {
		$options += [
			'self' => false,
			'direct_children_only' => true,
			'follow_symlinks' => true,
			'dealias' => false
		];
		if( $options['follow_symlinks'] && (!$options['self'] || $options['dealias'])) {
			$id = $this->realMeId();
			$options['dealiased_input'] = true;
		} else {
			$id = $this->getId();
		}
		return static::GetSubtreeOf($id, $options);
	}

	/** Categories from whole subtree, including both self and grandgrandgranddaughter **/
	function getAllChildCategories($options = []){
		return Cache::Get(get_called_class(), $this->getAllChildCategoriesIds($options) );
	}

	/** Ids of whole subtree, including both self and grandgrandgranddaughter **/
	function getAllChildCategoriesIds($options = []) {
		$options += array(
			'self' => true,
			'follow_symlinks' => true,
			'direct_children_only' => false,
			'dealias' => false
		);
		if( $options['follow_symlinks'] && (!$options['self'] || $options['dealias'])) {
			$id = $this->realMeId();
			$options['dealiased_input'] = true;
		} else {
			$id = $this->getId();
		}
		return static::GetSubtreeOf($this->realMeId(), $options);
	}

	/** Just child categories of given category(ies) (no subsubcategories, not self)
	 *  $childsOf1And2 = Category::GetChildCategoriesOf([$category1, $category2]);
	 **/
	static function GetChildCategoriesOf($category, $options = []){
		$options += array(
			'self' => false,
			'direct_children_only' => true,
			);
		$ids = static::GetSubtreeOf($category, $options);
		$out = Cache::Get(get_called_class(), $ids);
		return $out;
	}

	/**
	 * $blue->subcategoryOf($color);
	 * >> True
	 */
	function subcategoryOf($category_id, $options = array()) {

			if(is_string($category_id)) {
				$category = Category::GetInstanceByPath($category_id);
				if(!$category) { return false; };
				$category_id = $category->getId();
			}

			if(is_object($category_id)) {
				$category_id = $category_id->getId();
			}

			$options += ['follow_symlinks' => true];

			if(!$options['follow_symlinks']) {
				$cache = Cache::GetObjectCacher('Category');
				#not implemented
				#$cache->cacheParents(array($category_id));

				$category = $this;
				while(true) {
					if($category->getId() == $category_id) return true;
					$category = $category->getParentCategoryId();
					if(!$category) { return false; }
					$category = $cache->getCached(array($category));
					$category = $category[0];
				}
			} else {

				$sql = "
				WITH RECURSIVE t(id) as (
						SELECT :id
					UNION
						(WITH tt(id) as (select * from t where id <> :eid)
						 SELECT parent_category_id from categories c join tt on (c.id = tt.id)
						 UNION select c.id from categories c join tt on (pointing_to_category_id = tt.id)
						)
				) SELECT EXISTS(select * from t where id = :eid)";

				return $this->getDbMole()->selectBool($sql, array(':id' => $this, ':eid' => $category_id));
			}
	}

	static function MainRootCategory() {
		return static::GetInstanceByCode("catalog");
	}

	function isMainRootCategory(){
		if($main_root = static::MainRootCategory()){
			return $main_root->getId()===$this->getId();
		}
		return false;
	}

	function getFilterName() {
					$specials = [
									'filter:content' => 'm',
									'filter:color' => 'c',
									'filter:usage' => 'u'
					];
					$code = $this->getCode();
					return key_exists($code, $specials) ? $specials[$code] : 'f'.$this->getId();
	}


}

class NestedAliasException extends Exception {}
