<?php
class SystemParameter extends ApplicationModel implements Translatable {

	static function GetTranslatableFields(){ return ["description","content_localized"]; }

	function getSystemParameterType(){
		return Cache::Get("SystemParameterType",$this->getSystemParameterTypeId());
	}

	function getContent($lang = null){
		$type = $this->getSystemParameterType()->getCode(); // "boolean", "float"

		if($type=="localized_text"){
			return $this->getContentLocalized($lang);
		}
		$content = $this->g("content");
		if(is_null($content)){
			return null;
		}

		if($type=="text"){
			return $content;
		}

		if($type=="boolean"){
			$s = new String4($content);
			return $s->toBoolean();
		}

		settype($content,$type);
		return $content;
	}

	function isMandatory(){
		return $this->g("mandatory");
	}

	function isReadOnly(){
		return $this->g("read_only");
	}

	function toString(){
		return (string)$this->getContent();
	}
}
