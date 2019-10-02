<?php
class MainController extends ApplicationController{

	/**
	 * The front page
	 * 
	 * See corresponding template: app/views/main/index.tpl
	 * See default layout: app/layouts/default.tpl
	 */
	function index(){
		$this->page_title = _("Welcome!");

		$page = $this->tpl_data["page"] = Page::FindByCode("homepage");
		if($page){
			Atk14Require::Helper("modifier.markdown");
			$this->page_title = $page->getTitle();
			$this->page_description = strip_tags(smarty_modifier_markdown($page->getTeaser()));
		}

		$this->tpl_data["slider"] = Slider::FindByCode("homepage");

		$recommended_category = Category::FindByCode("recommended_products_homepage");
		$this->tpl_data["recommended_products"] = $recommended_category ? $recommended_category->getCards() : [];

		$this->tpl_data["recent_articles"] = Article::FindAll([
			"conditions" => [
				"published_at<:now",
			],
			"bind_ar" => [
				":now" => now(),
			],
			"order_by" => "published_at DESC",
			"limit" => 4,
		]);
	}

	function robots_txt(){
		$this->render_layout = false;
		$this->response->setContentType("text/plain");
	}
}
