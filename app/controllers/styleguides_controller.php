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
		$this->book = new MdBook($this->book_dir,array("keep_html_tables_unmodified" => false, "table_class" => ""));

		$this->book->registerBlockShortcode("literal", array(
			"callback" => function($content,$params){
				return $content;
			},
			"markdown_transformation_enabled" => false,
		));

		$this->book->registerBlockShortcode("example", array(
			"callback" => function($content,$params){
				$content = str_replace("\t","  ",$content);
				$content = trim($content);
				$code_id = "code_example_".uniqid();
				return "
					<div class=\"styleguide-example\">
					<div class=\"styleguide-example__output\">
					$content
					</div>
					<button class=\"btn btn-sm btn-outline-secondary styleguide-example__show-code-btn js-styleguide-reveal-code\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#" . $code_id . "\" aria-expanded=\"false\"><i class=\"fas fa-code\"></i> Show code</button>
					<div class=\"styleguide-example__code collapse\" id=\"" . $code_id . "\">
					<pre><code class=\"language-html\">" . h($content) . "</code></pre>
					</div>
					</div>
				";
			},
			"markdown_transformation_enabled" => false,
		));
	}
}
