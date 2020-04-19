<?php
class SystemParameter extends ApplicationModel implements Translatable {

	protected static $INSTANCES = null;

	static function GetTranslatableFields(){ return ["name","description","content_localized"]; }

	static function CreateNewRecord($values,$options = []){
		self::ClearCache();
		return parent::CreateNewRecord($values,$options);
	}

	/**
	 *
	 *	$params = SystemParameter::GetAllInstances();
	 *	echo $params["application.name"];
	 */
	static function GetAllInstances(){
		if(is_null(self::$INSTANCES)){
			self::$INSTANCES = array();
			foreach(SystemParameter::FindAll(array("order_by" => "code", "use_cache" => true)) as $sp){
				self::$INSTANCES[$sp->getCode()] = $sp;
			}
		}
		return self::$INSTANCES;
	}

	/**
	 *	$parameter = SystemParameter::GetInstanceByCode("application.name");
	 */
	static function GetInstanceByCode($code){
		$instances = self::GetAllInstances();
		return isset($instances[$code]) ? $instances[$code] : null;
	}

	/**
	 *
	 *	echo SystemParameter::ContentOn("app.name.official");
	 */
	static function ContentOn($code){
		if($parameter = self::GetInstanceByCode($code)){
			return $parameter->getContent();
		}
	}

	static function ClearCache(){
		self::$INSTANCES = null;
	}

	function getName(){
		$out = parent::getName();
		if(!$out){
			$code = $this->getCode();
			$ary = explode(".",$code);
			$out = array_pop($ary);
		}
		return $out;
	}

	function getSystemParameterType(){
		return Cache::Get("SystemParameterType",$this->getSystemParameterTypeId());
	}

	function getType(){
		return $this->getSystemParameterType();
	}

	function getDirectParent(){
		$ary = explode(".",$this->getCode());
		array_pop($ary);
		if(!$ary){
			return;
		}
		$direct_parent_code = join(".",$ary);
		return self::GetInstanceByCode($direct_parent_code);
	}

	function getContent($lang = null,$options = []){
		if(is_array($lang)){
			$options = $lang;
			$lang = null;
		}

		$options += [
			"lang" => $lang,
			"consider_returning_parent_content" => true
		];

		$type = $this->getType()->getCode(); // "boolean", "float", "text", "localized_text"

		if(preg_match('/^localized_/',$type)){
			$content = $this->getContentLocalized($lang);
		}else{
			$content = $this->g("content");
		}
		if(is_null($content)){
			if($options["consider_returning_parent_content"] && ($parent = $this->getDirectParent()) && ($parent->getSystemParameterTypeId()===$this->getSystemParameterTypeId())){
				return $parent->getContent($options);
			}
			return null;
		}

		if(in_array($type,["string","localized_string","text","localized_text","url","image_url","email","phone"])){
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

	function destroy($destroy_for_real = null){
		self::ClearCache();
		return parent::destroy($destroy_for_real);
	}

	function toString(){
		return (string)$this->getContent();
	}
}
