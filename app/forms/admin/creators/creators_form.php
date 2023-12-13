<?php
class CreatorsForm extends AdminForm {

	function set_up(){
		$this->add_field("name", new CharField([
			"label" => _("Name"),
			"max_length" => 255,
		]));
		$this->add_translatable_field("name_localized", new CharField([
			"label" => _("Localized name"),
			"max_length" => 255,
			"required" => false,
		]));
		$this->add_field("image_url", new PupiqImageField([
			"label" => _("Image"),
			"required" => false,
		]));
		$this->add_field("page_id", new PageField([
			"label" => _("Profile page"),
			"required" => false,
			"help_text" => _("Propojte tvůrce s jeho profilovou stránkou. Na této stránce pak budou automaticky zobrazeny jeho produkty.")."<br><br>".sprintf(_('Zatím stránka neexistuje? &rarr; <a href="%s">vytvořte ji</a>'),h(Atk14Url::BuildLink(["action" => "pages/create_new"]))),
		]));
	}

	function clean(){
		list($err,$d) = parent::clean();

		if(isset($d["name"]) && isset($this->controller->creator)){
			$existing = Creator::GetInstanceByName($d["name"]);
			if($existing && $existing->getId()!=$this->controller->creator->getId()){
				$this->set_error("name",_("Another creator already has this name"));
			}
		}

		return [$err,$d];
	}
}
