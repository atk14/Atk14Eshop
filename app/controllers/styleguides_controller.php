<?php
require_once(ATK14_DOCUMENT_ROOT."/app/controllers/md_book_base.php");

class StyleguidesController extends MdBookBaseController {
	
	function _before_filter(){
		$this->book_dir = ATK14_DOCUMENT_ROOT . "/public/styleguides/";

		if(!$this->logged_user || !$this->logged_user->isAdmin()){
			$this->_execute_action("error403");
			return;
		}

		$this->book_dir = ATK14_DOCUMENT_ROOT . "/public/styleguides/";
		$this->book = new MdBook($this->book_dir);

		$this->book->registerBlockShortcode("literal", array(
			"callback" => function($content,$params){
				return $content;
			},
			"markdown_transformation_enabled" => false,
		));

		$this->book->registerBlockShortcode("example", array(
			"callback" => function($content,$params){
				return "
					<div>
					$content
					</div>
					<pre><code>".h($content)."</code></pre>
				";
			},
			"markdown_transformation_enabled" => false,
		));
	}
}
