<?php
/**
 * Generates XML sitemap files and saves them into SitemapsController::GetSitemapsDir().
 * Executes the sitemaps/detail and sitemaps/detail_products actions in-process for each
 * supported language and saves the rendered output.
 * SitemapsController serves these files directly — sitemap requests are
 * instantaneous and XML generation never happens during an HTTP request.
 *
 * Run daily via local_scripts/robots_daily.
 */
class SitemapGeneratorRobot extends ApplicationRobot {

	function run(){
		global $HTTP_REQUEST;

		$regions = Region::GetActiveInstances();
		$domain_based_regions = true;
		if(!Region::GetRegionByDomain(ATK14_HTTP_HOST)){
			// A crawler cannot change a region
			$regions = [Region::GetDefaultRegion()];
			$domain_based_regions = false;
		}

		Atk14Utils::LoadControllers("sitemaps_controller");

		$sitemaps_dir = SitemapsController::GetSitemapsDir();
		if(!is_dir($sitemaps_dir)){
			Files::Mkdir($sitemaps_dir);
		}

		foreach($regions as $region){

			$http_host = $domain_based_regions ? $region->getDefaultDomain() : ATK14_HTTP_HOST;

			$request = new HttpRequest(["testing_mode" => true]);
			$request->setHttpHost($http_host);
			$request->setSslActive(REDIRECT_TO_SSL_AUTOMATICALLY);

			$HTTP_REQUEST = $request;

			foreach($region->getLanguages(["as_objects" => false]) as $lang){

				foreach(["detail","detail_products"] as $action){
					$identifier = preg_replace("/^detail/","",$action); // "", "_products"
					$region_code = $domain_based_regions ? ".".strtolower($region->getCode()) : ""; // "", ".default", ".eu", ".sk"...
					$output_file = "$sitemaps_dir/sitemap{$identifier}_{$lang}{$region_code}.xml";

					Atk14Locale::Initialize($lang);

					$params = [
						"namespace" => "",
						"controller" => "sitemaps",
						"action" => $action,
						"format" => "xml",
						"auth_token" => sha1(SECRET_TOKEN."GenerateXmlSitemapForMePlease".date("Y-m-d")),
					];

					$response = Atk14Dispatcher::ExecuteAction($params["controller"],$params["action"],[
						"render_layout" => false,
						"params" => $params,
						"namespace" => "",
						"request" => $request,
					]);

					myAssert($response->getStatusCode()===200,"Response code is {$response->getStatusCode()} and has to be 200");

					$buffer = $response->getOutputBuffer();

					$tmp_file = Files::GetTempFilename("sitemap_",".xml.tmp");
					$buffer->writeToFile($tmp_file);
					Files::MoveFile($tmp_file, $output_file);

					unset($params["auth_token"]);
					$sitemap_url = Atk14Url::BuildLink($params,["with_hostname" => true]);

					$this->logger->info("sitemap for $lang/sitemaps/$action ($sitemap_url) written to {$output_file}");
					$this->logger->flush();
				}
			}

		}
	}
}
