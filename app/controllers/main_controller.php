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

		$page = $this->tpl_data["page"] = Page::GetInstanceByCode("homepage");
		if($page){
			$this->page_title = $page->getPageTitle();
			$this->page_description = $page->getPageDescription();
		}

		$this->tpl_data["slider"] = Slider::FindByCode("homepage");

		$category_recommended_cards = Category::FindByCode("recommended_cards_homepage");
		if($category_recommended_cards && $category_recommended_cards->g("visible") && ($category_recommended_cards->getCards())){
			$this->tpl_data["category_recommended_cards"] = $category_recommended_cards;
		}

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

		if ($page && !$page->isIndexable()) {
			$this->head_tags_14->setMeta("robots", "noindex,noarchive");
		}
	}

	function robots_txt(){
		$this->render_layout = false;
		$this->response->setContentType("text/plain");
	}
}
