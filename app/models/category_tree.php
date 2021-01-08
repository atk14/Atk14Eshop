<?php
/**
 * Iteration of category tree
 * Usage:
 * $tree = new CategoryTree($katalog);
 * $tree->getCategory()
 * >> Katalog (Category object)
 *
 * function print_tree($tree, $prefix = '') {
 *   echo $prefix,$tree->getCategory()->getName();
 *   $prefix.=' ';
 *   foreach($tree as $child) {
 *     print_tree($child, $prefix);
 *   }
 * print_tree($tree);
 * >>Katalog
 * >> Katalog_son1
 * >>  Katalog_grandson11
 * >>  Katalog_grandson12
 * >> Katalog_son2
 * >>  Katalog_grandson21
 * >> ....
 *
 * $tree = new CategoryTree([$category1, $category2]);
 * $tree->getCategory() //input is array, so the input will be in level 1, not 0
 * >> NULL
 * $tree->getChildCategories()
 * >> [ $category1, $category2 ]
 *
 * $tree = new CategoryTree($katalog, ['return_cards_count'])
 * $tree->getCardsCount()
 * >> 50 //there is 50 cards in katalog category
 * reset($tree)->getCardsCount //there is 50 cards in katalog category
 * >> 20 //there is 50 cards in first child of $katalog
 */

class CategoryNode implements IteratorAggregate, Countable {

	function __construct($tree, $id, $parent = null) {
		$this->tree = $tree;
		$this->id = $id;
		$this->fetched = false;
		$this->parent = $parent;
	}

	function fetch() {
		if($this->fetched) {
			return;
		}
		$id = $this->id;
		if($id && key_exists($id, $this->tree->result)) {
			$this->data = $this->tree->result[$id];
		} else {
			$this->data = array('real_id' => null);
		}
		$this->fetched = True;
	}

	function getCategory() {
		$this->fetch();
		return $this->tree->categories[$this->id];
	}

	function getChildCategories() {
		$this->fetch();
		$out=array();
		if(!isset($this->tree->childs[$this->id])) {
			return $out;
		}

		foreach($this->tree->childs[$this->id] as $id) {
			$out[] = $this->tree->categories[$id['id']];
		}
		return $out;
	}

	function getChildNodes(){
		$nodes = array();
		foreach($this as $node){
			$nodes[] = $node;
		}
		return $nodes;
	}

	function getCardsCount() {
		$this->fetch();
		return (int) $this->data['cards_count'];
	}

	function hasChilds() {
		return $this->getChildCategoriesCount();
	}

	function getChildCategoriesCount() {
		$this->fetch();
		$real_id = $this->data['real_id'];
		if(!isset($this->tree->childs[$real_id])) {
			return 0;
		}
		return count($this->tree->childs[$real_id]);
	}

	function count() {
		return $this->getChildCategoriesCount();
	}

	/**
	 *
	 *	echo $node->getPath(); // "catalog/food/candies"
	 */
	function getPath(){
		if($this->parent){
			// this respects symlinks in category tree (aliasing)
			return strlen($this->parent->getPath()) ? $this->parent->getPath()."/".$this->getCategory()->getSlug() : $this->getCategory()->getPath();
		}
		return $this->getCategory()->getPath();
	}

	function getIterator() {
		$this->fetch();
		$out=array();
		#child kategorie nemusi byt
		$real_id = $this->id;
		if(isset($this->tree->childs[$real_id])) {
			foreach($this->tree->childs[$real_id] as $id) {
				$out[] = new CategoryNode($this->tree, $id['id'], $this);
			};
		}
		return new ArrayIterator($out);
	}

	function getId() {
		$this->fetch();
		return $this->id;
	}
}


class CategoryTree extends CategoryNode {

	/**
	 * @param mixed integer (id of categories) or Category object or array of such values
	 * or null (whole tree - maybe 'self' => false option is needed?)
	 * @param array options, see Category::GetSubtreeOfSql for possible values
	 *
	 * new CategoryTree($katalog);
	 * new CategoryTree($katalog, ['return_cards_count']);
	 * new CategoryTree(null);
	 * new CategoryTree($katalog, ['return_cards_count', 'cards_filter' => $filter, 'visible' => true, 'is_filter' => false]);
	 */
	function __construct($parentIds, $options = array()) {
			$options['return_parent_id'] = true;
			$options['return_real_id'] = true;
			$options+=[
				'direct_children_only' => false,
				'order_by' => 'rank, id',
				'lazy' => true
			];
			$this->options = $options;
			if(!$this->options['lazy']) {
				$this->fetch();
			}
			$this->parentIds = $parentIds;
			parent::__construct( $this, null );
	}

	static function GetInstance($parentIds = null, $options = array()){
		return new CategoryTree($parentIds,$options);
	}

	function fetch() {
		if( $this->fetched ) {
			return;
		}
		$options = $this->options;

		list($sql, $bind) = Category::GetSubtreeOfSql($this->parentIds, $options);

		$dbmole = Category::GetDbMole();
		$data = $dbmole->selectRows($sql, $bind);

		$childs = array( null => array() );
		$ids = array();
		$out = array();

		foreach($data as $row) {
			$childs[$row['parent_category_id']][] = $row;
			$ids[] = $row['id'];
			$out[$row['id']] = $row;
		}
		foreach($childs as $k => $v) {
			if($k && !key_exists($k, $out)) {
				$childs[null] = array_merge($childs[null], $v);
			}
		}

		$this->categories = $ids ? Cache::Get('Category', array_combine($ids,$ids)) : array();
		$this->childs = $childs;
		$this->result = $out;

		if(is_array($this->parentIds)) {
			$this->id = null;
		} elseif(is_object($this->parentIds)) {
			$this->id = $this->parentIds->getId();
		} else {
			$this->id = $this->parentIds;
		}

		parent::fetch();
	}
}
