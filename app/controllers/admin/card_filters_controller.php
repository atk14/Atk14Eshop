<?php
/**
 * Rychle zarazovani daneho produktu do filtracnich kategorii.
 */
class CardFiltersController extends AdminController{

	function edit(){
		$card = $this->card;
		$this->page_title = sprintf(_('Placing the product "%s" into filters'),$card->getName());
	
		$ids = array();
		$filters = array();
		foreach($card->getCategories() as $c){
			foreach($c->getAvailableFilters() as $f){
				if(in_array($f->getId(),$ids)){ continue; }
				$filters[] = $f;
				$ids[] = $f->getId();
			}
		}

		$current_category_ids = $card->getCategoryIds();

		foreach($filters as $f){
			$choices = [];
			$initial = [];

			foreach($f->getChildCategories() as $c){
				$choices[$c->getId()] = strip_tags($c->getName());
				if(in_array($c->getId(),$current_category_ids)){
					$initial[] = $c->getId();
				}
			}

			if($choices){
				$visibility_note = $f->isVisible() ? "" : " ["._("invisible")."]";
				$this->form->add_field("filter_".$f->getId(), new MultipleChoiceField(array(
					"label" => "/".$f->getPath()."/".$visibility_note,
					"choices" => $choices,
					"initial" => $initial,
					"required" => false,
					"widget" => new CheckboxSelectMultiple(),
				)));
			}
		}

		$this->_save_return_uri();

		if(!$this->form->fields){
			$this->tpl_data["return_uri"] = $this->_get_return_uri();
			$this->_execute_action("no_filter_categories");
			return;
		}

		if($this->request->post() && ($d = $this->form->validate($this->params))){
			foreach($filters as $f){
				foreach($f->getChildCategories() as $c){
					$key = "filter_".$f->getId();

					if(in_array($c->getId(),$d[$key])){
						$card->addToCategory($c);
					}else{
						$card->removeFromCategory($c);
					}
				}
			}
			$this->flash->success(_("Settings saved"));
			$this->_redirect_back();
		}
	}

	function no_filter_categories(){
		$this->page_title = sprintf(_('Placing the product "%s" into filters'),$this->card->getName());
	}

	function _before_filter(){
		$card = $this->_find("card");

		if ($card) {
			if ($card->isDeleted()){
				return $this->_execute_action("error404");
 			}
			$this->_add_card_to_breadcrumbs($card);
		}
	}

}
