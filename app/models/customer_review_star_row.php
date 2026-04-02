<?php
class CustomerReviewStarRow {

	protected $stars;
	protected $star_count;
	protected $percentage;

	function __construct(int $stars, int $star_count, float $percentage){
		$this->stars = $stars;
		$this->star_count = $star_count;
		$this->percentage = $percentage;
	}

	function getStars(){
		return $this->stars;
	}

	function getStarCount(){
		return $this->star_count;
	}

	function getPercentage(){
		return $this->percentage;
	}
}
