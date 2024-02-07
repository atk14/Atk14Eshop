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

	protected $tree;
	protected $id;
	protected $data;
	protected $fetched;
	protected $parent;
	protected $iterator;
	protected $level;

	function __construct($tree, $id, $parent = null) {
		$this->tree = $tree;
		$this->id = $id;
		$this->fetched = false;
		$this->parent = $parent;
		$this->iterator = null;
		if($this->parent) {
			$this->level = $this->parent->level + 1;
		}
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

	function hasChildCategories() {
		if(!$this->tree->_canDescendFromLevel($this->level)) {
			return false;
		}
		$this->fetch();
		$real_id = $this->id;
		return isset($this->tree->childs[$real_id]) && $this->tree->childs[$real_id];
	}

	function getChildCategories() {
		$this->fetch();
		$out=array();
		$real_id = $this->id;
		if(!isset($this->tree->childs[$real_id])) {
			return $out;
		}

		foreach($this->tree->childs[$real_id] as $id) {
			$out[] = $this->tree->categories[$id['real_id']];
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
		return (bool) $this->getChildCategoriesCount();
	}

	function getChildCategoriesCount() {
		if(!$this->tree->_canDescendFromLevel($this->level)) {
			return 0;
		};
		$this->fetch();
		$real_id = $this->data['real_id'];
		if(!isset($this->tree->childs[$real_id])) {
			return 0;
		}
		return count($this->tree->childs[$real_id]);
	}

	#[\ReturnTypeWillChange]
	function count() {
		return $this->getChildCategoriesCount();
	}

	/**
	 *
	 *	echo $node->getPath(); // "catalog/food/candies"
	 */
	function getPath(){
		if($this->parent){
			$path = $this->parent->getPath();
			// this respects symlinks in category tree (aliasing)
			return strlen($path) ? $path."/".$this->getCategory()->getSlug() : $this->getCategory()->getPath();
		}
		return $this->getCategory()->getPath();
	}

	#[\ReturnTypeWillChange]
	function getIterator() {
		if(!$this->iterator) {
			$this->fetch();
			$out=array();
			#child kategorie nemusi byt
			$real_id = $this->id;

			if(isset($this->tree->childs[$real_id]) && $this->tree->_canDescendFromLevel($this->level)) {
				foreach($this->tree->childs[$real_id] as $id) {
					$out[] = new CategoryNode($this->tree, $id['id'], $this);
				};
			}
			$this->iterator = new ArrayIterator($out);
		}
		return $this->iterator;
	}

	function printSlugTree($prefix='') {
		if($this->id!=null) {
			echo $prefix, $this->getSlug(), " ({$this->id})\n";
			$prefix.='  ';
		}
		foreach($this as $n) {
			$n->printSlugTree($prefix);
		}
	}

	function getId() {
		$this->fetch();
		return $this->id;
	}

	function getSlug() {
		return $this->getCategory()->getSlug();
	}

	function getNodeByPath($path) {
		if(!$path){ return; }

		if(!is_array($path)) {
			$path = explode('/', $path);
		}
		$path=array_reverse($path);
		$n = $this;
		while($path) {
			$p = array_pop($path);
			foreach($n as $nn) {
				if($nn->getSlug() === $p) {
					$n=$nn;
					continue 2;
				}
			}
			return null;
		};
		return $n;
	}

	function getNodeByFullPath($path) {
		if(!$path){ return; }

		if(!is_array($path)) {
			$path = explode('/', $path);
		}

		$_path = $path;
		while($_path){
			$node = $this->getNodeByPath($_path);
			if($node && $node->getPath()===join("/",$path)){
				return $node;
			}
			array_shift($_path);
		}
	}

	function isDescendantOf($root_node){
		if($root_node->getId()==$this->getId()){ return true; }
		if($parent = $this->getParentNode()){
			return $parent->isDescendantOf($root_node);
		}
		return false;
	}

	function getParentNode(){
		return $this->parent;	
	}

	function _getNodeByPath(&$path) {
		if(!$path) { return $this; };
				return null;
	}

	function toArray(){
		return array(
			"id" => $this->getId(),
			"path" => $this->getPath(),
			"category" => $this->getCategory()->toArray(),
		);
	}
}


class CategoryTree extends CategoryNode {

	protected $options;
	protected $parentIds;
	protected $categories;
	protected $childs;
	protected $result;

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
				'lazy' => true,

				'min_level' => null,
				'self' => true
			];
			parent::__construct($this, null, null );
			$this->options = $options;
			$this->parentIds = $parentIds;
			if(!$this->options['lazy']) {
				$this->fetch();
			}
			$this->level=0;
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
		//echo $sql; echo "\n\n";

		$dbmole = Category::GetDbMole();
		$data = $dbmole->selectRows($sql, $bind);

		$childs = array( null => array() );
		$ids = array();
		$out = array();

		foreach($data as $row) {
			$childs[$row['parent_category_id']][] = $row;
			$ids[$row['id']] = $row['id'];
			$ids[$row['real_id']] = $row['real_id'];
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

		if(is_array($this->parentIds) || $this->options['min_level'] || !$this->options['self']
		  ) {
				$this->id = null;
				if($this->options['min_level']) {
					$this->level = $this->options['min_level'] - 1;
				} else {
					$this->level =
						is_array($this->parentIds) && $this->options['self'] ? -1 : 0;
				}
		} else {
			if(is_object($this->parentIds)) {
				$this->id = $this->parentIds->getId();
			} else {
				$this->id = $this->parentIds;
			}
			$this->level = 0;
		}

		parent::fetch();
	}

	function getPath() {
			$this->fetch();
			return $this->id ? $this->getCategory()->getPath() : null;
	}

	function _canDescendFromLevel($level) {
		if(!isset($this->options['level'])) {
			return true;
		}
		return $level < $this->options['level'];
	}
}
