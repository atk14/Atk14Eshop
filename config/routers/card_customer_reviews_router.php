<?php
class CardCustomerReviewsRouter extends Atk14Router{

	protected $keywords = [
		"cs" => "recenze",
		"sk" => "recenzie",
		"en" => "reviews",
	];

	function recognize($uri){
		if(!preg_match('/^(\/.*\/)('.join("|",$this->keywords).')\/$/',$uri,$matches)){
			return;
		}
		$ar = Atk14Url::RecognizeRoute($matches[1]);
		if($ar["controller"]==="cards" && $ar["action"]==="detail" && isset($ar["get_params"]["id"])){
			$this->controller = "card_customer_reviews";
			$this->action = "index";
			$this->lang = $ar["lang"];
			$this->params["card_id"] = $ar["get_params"]["id"];
		}
	}

	function build(){
		global $ATK14_GLOBAL;

		if($this->namespace!="" || $this->controller!="card_customer_reviews" || $this->action!="index" || !$this->params["card_id"]){ return; }

		if(!isset($this->keywords[$this->lang])){
			return;
		}

		$card_uri = Atk14Url::BuildLink([
			"namespace" => "",
			"controller" => "cards",
			"action" => "detail",
			"id" => $this->params["card_id"],
			"lang" => $this->lang,
		]); // e.g "/book/the-little-prince/"

		unset($this->params["card_id"]);
		$keyword = $this->keywords[$this->lang];

		return "$card_uri$keyword/"; // e.g. "/book/the-little-prince/reviews/"
	}
}
