<?php
class SitemapsController extends ApplicationController{

	public $is_xml = false;
	public $authorized_to_render_xml = false;

	/**
	 * Directory where the pre-generated XML sitemap cache files live.
	 * In TEST we don't want to read/write the real public/sitemaps/ directory,
	 * so each test run gets its own throwaway directory under TEMP instead
	 * (memoized per process so repeated calls within one run agree on the same path).
	 *
	 * Used by both this controller and SitemapGeneratorRobot.
	 */
	static function GetSitemapsDir(){
		if(!TEST){
			return ATK14_DOCUMENT_ROOT . "/public/sitemaps";
		}

		static $dir = null;
		if(!$dir){
			$dir = TEMP."/testing/sitemaps_".uniqid();
		}
		return $dir;
	}

	function index(){
		$this->render_layout = false;
		$this->response->setContentType("application/xml");
		$this->response->clearHeader("Pragma");
		$this->response->setHeader("Cache-Control","public, max-age=86400");
		$langs = $GLOBALS["ATK14_GLOBAL"]->getSupportedLangs();
		$this->tpl_data["langs"] = $langs;
	}

	function detail(){
		if($this->_serve_sitemap_from_cache_or_wait()){
			return;
		}

		$this->page_title = $this->breadcrumbs[] = _("Sitemap");

		$LIMIT = $this->is_xml ? null : 100;

		$this->tpl_data["pages"] = Page::FindAll(array(
			"conditions" => array(
				"parent_page_id IS NULL",
				"visible",
				"indexable"
			),
			"use_cache" => true,
		));

		$this->tpl_data["categories"] = Category::FindAll(array(
			"conditions" => array(
				"parent_category_id IS NULL",
				"visible",
				"NOT is_filter",
				"pointing_to_category_id IS NULL" // is not alias
			),
			"use_cache" => true,
		));

		if($this->is_xml){
			// There is a special action for exporting the products in XML format
			$this->tpl_data["cards"] = Card::EmptyFinder();
		}else{
			$this->tpl_data["cards"] = Card::Finder(array(
				"conditions" => array(
					"visible",
					"NOT deleted",
				),
				"order_by" => "created_at DESC",
				"limit" => $LIMIT,
				"use_cache" => true,
			));
		}

		$this->tpl_data["articles"] = Article::Finder(array(
			"condition" => [
				"published_at<:now",
			],
			"bind_ar" => array(
				":now" => now(),
			),
			"order_by" => "published_at DESC",
			"limit" => $LIMIT,
			"use_cache" => true,
		));

		$this->tpl_data["brands"] = Brand::Finder(array(
			"conditions" => array(
				"visible",
			),
			"limit" => $LIMIT,
			"use_cache" => true,
		));

		$this->tpl_data["stores"] = Store::FindAll(array(
			"conditions" => array(
				"visible",
			),
			"use_cache" => true,
		));

		if($this->is_xml){
			$this->_render_xml();
		}
	}

	function detail_products(){
		if(!$this->is_xml){
			// this is xml-only action
			$this->_execute_action("error404");
			return;
		}

		if($this->_serve_sitemap_from_cache_or_wait()){
			return;
		}

		$this->tpl_data["cards"] = Card::Finder(array(
			"conditions" => array(
				"visible",
				"NOT deleted",
			),
			"order_by" => "created_at DESC",
			"limit" => null,
			"use_cache" => true,
		));

		if($this->is_xml){
			$this->_render_xml();
		}
	}

	function _before_filter(){
		$is_xml = $this->params->getString("format") === "xml";
		$auth_token_expected = sha1(SECRET_TOKEN."GenerateXmlSitemapForMePlease".date("Y-m-d"));
		$auth_token = $this->params->getString("auth_token");

		if($is_xml && $auth_token && !hash_equals($auth_token_expected,$auth_token)){
			$this->render_template = false;
			$this->response->forbidden("Invalid auth token given");
			return;
		}

		$this->is_xml = $is_xml;
		$this->authorized_to_render_xml = $is_xml && !!$auth_token;

		if(!$this->is_xml && $this->action==="detail" && !TEST){
			$this->_caches_action();
		}
	}

	/**
	 * If needed, serves the request straight from the cache file (or responds 503 while it doesn't exist yet),
	 * without ever running the rest of the action (DB queries, _render_xml()).
	 *
	 * @return bool true if the response was served from here and the action should stop
	 */
	function _serve_sitemap_from_cache_or_wait(){
		if(!($this->is_xml && !$this->authorized_to_render_xml)){
			return false;
		}

		$this->render_template = false;

		$identifier = preg_replace("/^detail/","",$this->action); // "", "_products"
		$cache_file = SitemapsController::GetSitemapsDir() . "/sitemap{$identifier}_{$this->lang}.xml";

		if(file_exists($cache_file)){
			$this->response->setContentType("application/xml");
			$this->response->clearHeader("Pragma");
			$this->response->setHeader("Cache-Control","public, max-age=86400");
			$this->response->buffer->addFile($cache_file);
		}else{
			$this->response->temporarilyUnavailable("The sitemap is not ready yet.");
		}

		return true;
	}

	function _render_xml(){
		$this->render_template = false;
		$this->response->setContentType("application/xml");
		$this->response->clearHeader("Pragma");
		$this->response->setHeader("Cache-Control","public, max-age=86400");

		$this->response->writeln('<?xml version="1.0" encoding="UTF-8"?>');
		$this->response->writeln('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');

		// Extract links from the rendered HTML snippet
		$content = $this->_render(["partial" => $this->action]); // "detail" or "detail_products"
		preg_match_all('/<a[^>]* href="(.+?)"/',$content,$matches);
		foreach($matches[1] as $url){
			if(defined("REDIRECT_TO_SSL_AUTOMATICALLY") && constant("REDIRECT_TO_SSL_AUTOMATICALLY")){
				$url = preg_replace('/^http:/','https:',$url);
			}
			$this->response->writeln(sprintf('<url><loc>%s</loc></url>',h($url)));
		}
		unset($content,$matches);

		$this->response->write('</urlset>');
	}
}
