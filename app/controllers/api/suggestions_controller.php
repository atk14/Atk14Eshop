<?php
class SuggestionsController extends ApiController{

	function users(){
		if(!$this->logged_user || !$this->logged_user->isAdmin()){
			// this is for a logged-in administrator only
			$this->_execute_action("error403");
			return;
		}

		$this->_suggest([
			"fields" => [
				"login",
				"firstname",
				"lastname",
				"email",
				"company",
				"address_street",
				"address_street2",
				"address_city",
				"address_state",
				"address_zip"
			],
			"order_by" => "
				LOWER(login) LIKE LOWER(:q)||'%' DESC,
				LOWER(lastname) LIKE LOWER(:q)||'%' DESC,
				LOWER(firstname) LIKE LOWER(:q)||'%' DESC,
				LOWER(company) LIKE LOWER(:q)||'%' DESC,
				is_admin DESC,
				login
			",
		]);
	}

	/**
	 * ### Suggestion of Product Cards
	 */
	function cards(){
		$_name = "(SELECT body FROM translations WHERE table_name='cards' AND record_id=cards.id AND key='name' AND lang='$this->lang')";
		$_catalog_id = "(SELECT STRING_AGG(catalog_id,' ') FROM products WHERE card_id=cards.id AND NOT deleted)";
		$this->_suggest(array(
			"fields" => array("id",$_name,$_catalog_id),
			"order_by" => "id::VARCHAR=:q DESC, UPPER(COALESCE($_name,'_____')) LIKE UPPER(:q)||'%' DESC, UPPER($_catalog_id) LIKE UPPER(:q)||'%' DESC, $_name, id",

			"conditions" => array(
				"deleted='f'",
				//"visible='t'", // during the preparation of a new category we sometimes need to suggest even invisible cards
			)
		));
	}

	/**
	 * ### Suggestion of technical specification keys
	 */
	function technical_specification_keys(){
		$this->_suggest(array(
			"fields" => array("key"),
			"order_by" => "key LIKE :q||'%' DESC, LOWER(key) LIKE LOWER(key)||'%' DESC, LOWER(key), key",
		));
	}

	/**
	 * ### Suggestion of Products
	 */
	function products(){
		$_name = "(SELECT body FROM translations WHERE table_name='cards' AND record_id=products.card_id AND key='name' AND lang='$this->lang')";
		$_product_label = "(SELECT body FROM translations WHERE table_name='products' AND record_id=products.id AND key='label' AND lang='$this->lang')";
		$_product_name = "(SELECT body FROM translations WHERE table_name='products' AND record_id=products.id AND key='name' AND lang='$this->lang')";
		$this->_suggest(array(
			"fields" => array("catalog_id",$_name,$_product_label,$_product_name),
			"order_by" => "UPPER(COALESCE($_name,'_____')) LIKE UPPER(:q)||'%' DESC, UPPER(catalog_id) LIKE UPPER(:q)||'%' DESC, $_name, catalog_id",
			"conditions" => array(
				"deleted='f'",
				//"visible='t'", // toto nechceme omezovat
			)
		));
	}

	function tags(){
		$this->_suggest(array(
			"fields" => array("tag"),
			"order_by" => "UPPER(tag) LIKE UPPER(:q)||'%' DESC, tag",
		));
	}

	function creators(){
		$this->_suggest(array(
			"fields" => array("name"),
			"order_by" => "name LIKE :q||'%' DESC, LOWER(name) LIKE LOWER(name)||'%' DESC, LOWER(name), name",
		));
	}

	function _suggest($options = array()){
		global $ATK14_GLOBAL;

		$options += array(
			"class_name" => "", // "Person"
			"field_class_name" => "", // PersonField
			"fields" => array("name"),
			"order_by" => "LOWER(name),name,id",
			"conditions" => array(), // array("deleted='f'")
			"bind_ar" => array(),
		);

		if(!$options["class_name"]){
			$options["class_name"] = String4::ToObject($this->action)->singularize()->camelize()->toString(); // "people" -> "Person"
		}

		if(!$options["field_class_name"]){
			$options["field_class_name"] = String4::ToObject($this->action)->singularize()->camelize()->toString()."Field"; // "people" -> "PersonField"
		}

		$class_name = (string)$options["class_name"];
		$field_class_name = (string)$options["field_class_name"];

		$o = new $class_name();
		$table = $o->getTableName();
		$all_translatable_fields = ($o instanceof Translatable) ? $class_name::GetTranslatableFields() : array();

		if(!$this->params->isEmpty() && ($d = $this->form->validate($this->params))){
			$q = $d["q"];
			$q = preg_replace('/(\[|\[#.*)$/','',$q); // "Jan Brus, šéfredaktor [#123]" -> "Jan Brus, šéfredaktor"

			$this->api_data = array();
			$conditions = $options["conditions"];
			$bind_ar = $options["bind_ar"];
			$bind_ar[":q"] = $q; 

			$q = Translate::Lower($q); // "jan brus, šéfredaktor"

			$_fields = array();
			foreach($options["fields"] as $f){
				if(!in_array($f,$all_translatable_fields)){ $_fields[] = $f; continue; }
				foreach($ATK14_GLOBAL->getSupportedLangs() as $l){
					$_fields[] = "(SELECT body FROM translations WHERE record_id=$table.id AND table_name='$table' AND key='$f' AND lang='$l')";
				}
			}

			$fields = "LOWER(COALESCE(''||".join(",'')||' '||COALESCE(''||",$_fields).",''))";
			if(!$condition = FullTextSearchQueryLike::GetQuery($fields,$q,$bind_ar)){
				return;
			}

			$conditions[] = $condition;
			
			$records = $class_name::FindAll(array(
				"conditions" => $conditions,
				"bind_ar" => $bind_ar,
				"order_by" => $options["order_by"],
				"limit" => 20,
			));

			$f = new $field_class_name();
			foreach($records as $p){
				$this->api_data[] = $f->format_initial_data($p);
			}
		}
	}

	function _before_filter(){
		parent::_before_filter();

		// vsechny akce maji stejny formular
		$this->form = $this->_get_form("index");
	}
}
