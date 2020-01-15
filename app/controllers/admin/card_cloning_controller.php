<?php
class CardCloningController extends AdminController {

	function create_new(){
		global $ATK14_GLOBAL;

		$card = $this->card;
			
		$this->page_title = sprintf(_('Copying product "%s"'),$card->getName());

		$this->form->tune_for_card($card);

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			$values = $card->toArray();
			$forbidden = ["id","visible","deleted","created_by_user_id","updated_by_user_id","created_at","updated_at"];
			foreach($ATK14_GLOBAL->getSupportedLangs() as $l){
				$forbidden[] = "slug_$l";
				$values["name_$l"] = $d["name_$l"];
			}
			$forbidden = array_combine($forbidden,$forbidden);
			$values = array_diff_key($values,$forbidden);
			$values["visible"] = $d["visible"];

			$price = $d["price"];
			$base_price = isset($d["base_price"]) ? $d["base_price"] : null; // base_price may not be in the form
			$stockcount = $d["stockcount"];
			unset($d["price"]);
			unset($d["base_price"]);
			unset($d["stockcount"]);

			$new_card = Card::CreateNewRecord($values);

			$forbidden = ["id","created_by_user_id","updated_by_user_id","created_at","updated_at","rank"];
			$forbidden = array_combine($forbidden,$forbidden);

			$product = Product::CreateNewRecord([
				"catalog_id" => $d["catalog_id"],
				"card_id" => $new_card,
			]);

			if(!is_null($price)){
				$pricelist = Pricelist::GetDefaultPricelist();
				$pricelist->setPrice($product,$price);
			}
			if(!is_null($base_price)){
				$pricelist = Pricelist::GetInstanceByCode(DEFAULT_BASE_PRICELIST);
				$pricelist->setPrice($product,$base_price);
			}
			if(!is_null($stockcount)){
				$warehouse = Warehouse::GetDefaultInstance4Eshop();
				$warehouse->addProduct($product,$stockcount);
			}

			// Tagy
			$new_card->setTags($card->getTags());

			// Obrazky
			if($d["copy_images"]){
				$this->_copy_linked_objects("Image",$card,$new_card);
			}

			// Prilohy
			if($d["copy_attachments"]){
				$this->_copy_linked_objects("Attachment",$card,$new_card);
			}

			// Kategorie
			if($d["copy_categories"]){
				$ids = $this->dbmole->selectIntoArray("SELECT category_id FROM category_cards WHERE card_id=:card",[":card" => $card]);
				foreach(Category::GetInstanceById($ids) as $c){
					$new_card->addToCategory($c);
				}
			}

			// Textove sekce
			if($d["copy_textual_sections"]){
				foreach($card->getCardSections() as $cs){
					$_values = $cs->toArray();
					$_values = array_diff_key($_values,$forbidden);
					$_values["card_id"] = $new_card->getId();
					$new_cs = CardSection::CreateNewRecord($_values);
					$this->_copy_all_linked_objects($cs,$new_cs);
					$this->_copy_iobjects($cs,$new_cs);
				}
			}

			// Technicke specifikace
			if($d["copy_technical_specifications"]){
				foreach($card->getTechnicalSpecifications() as $ts){
					$_values = $ts->toArray();
					$_values = array_diff_key($_values,$forbidden);
					$_values["card_id"] = $new_card->getId();
					$new_ts = TechnicalSpecification::CreateNewRecord($_values);
				}
			}

			// Creators
			if($d["copy_creators"]){
				foreach(CardCreator::GetCreatorsForCard($card) as $cc){
					$_values = $card->toArray();
					$_values = $cc->toArray();
					$_values = array_diff_key($_values,$forbidden);
					$_values["card_id"] = $new_card->getId();
					$new_cs = CardCreator::CreateNewRecord($_values);
				}
			}

			$this->flash->success(_("A new product was successfully created"));

			$this->_redirect_to([
				"action" => "cards/edit",
				"id" => $new_card,
				"return_uri" => $this->_link_to("cards/index"),
			]);
		}
	}

	function _copy_all_linked_objects($object,$new_object){
		$this->_copy_linked_objects("Image",$object,$new_object);
		$this->_copy_linked_objects("Attachment",$object,$new_object);
	}

	function _copy_linked_objects($class_name,$card,$new_card){
		$forbidden = ["id","created_by_user_id","updated_by_user_id","created_at","updated_at","rank"];
		$forbidden = array_combine($forbidden,$forbidden);

		foreach($class_name::GetInstancesFor($card) as $object){
			$values = $object->toArray();
			$values = array_diff_key($values,$forbidden);
			$values["record_id"] = $new_card->getId();
			$class_name::CreateNewRecord($values);
		}
	}

	function _copy_iobjects($object,$new_object){
		$rows = $this->dbmole->selectRows("SELECT iobject_id, rank FROM iobject_links WHERE linked_table=:table AND linked_record_id=:record ORDER BY rank, id",[":table" => $object->getTableName(), ":record" => $object]);
		foreach($rows as $row){
			$row["linked_table"] = $new_object->getTableName();
			$row["linked_record_id"] = $new_object->getId();
			$this->dbmole->insertIntoTable("iobject_links",$row);
		}
	}

	function _before_filter(){
		$this->_find("card","card_id");
	}
}
