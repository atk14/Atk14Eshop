<?php
class VouchersController extends ApplicationController {

	function index(){
		if(!DEVELOPMENT){ return $this->_execute_action("error404"); }

		$this->page_title = _("Vouchers");

		$vouchers = [];

		foreach([
			"free_shipping" => "minimal_items_price_incl_vat=0 AND free_shipping AND discount_amount=0",
			"gift_voucher" => "vat_rate_id IS NOT NULL AND NOT free_shipping",
			"discount_voucher" => "discount_percent IS NOT NULL AND discount_percent>0.0 AND vat_rate_id IS NULL AND NOT free_shipping",
			"gift_voucher_free_shipping" => "discount_percent IS NOT NULL AND discount_percent>0.0 AND free_shipping",
		] as $key => $conditions){
			$voucher = Voucher::FindFirst([
				"conditions" => [
					$conditions
				],
			]);
			if(!$voucher){ continue; }
			$vouchers[$key] = $voucher;
		}

		foreach(Voucher::FindAll("voucher_code LIKE 'TEST\_%'") as $voucher){
			$vouchers[$voucher->getVoucherCode()] = $voucher;
		}

		$this->tpl_data["vouchers"] = $vouchers;
	}

	function detail(){
		$voucher = Voucher::GetInstanceByToken($this->params->getString("token"),"voucher_detail");
		if(!$voucher){
			return $this->_execute_action("error404");
		}

		if(!$region = Region::GetInstanceById($this->params->getInt("region_id"))){
			return $this->_execute_action("error404");
		}

		if(!$voucher->isApplicableForRegion($region)){
			return $this->_execute_action("error404");
		}

		$format = (string)$this->params->getString("format");
		if(strlen($format) && $format!=="pdf"){
			return $this->_execute_action("error404");
		}

		$this->page_title = sprintf(_("Voucher %d"),$voucher->getId());

		if($format==="pdf"){
			$params = $this->params->toArray();
			unset($params["format"]);
			$url = $this->_link_to($params,["with_hostname" => true]);
			
			$utp = new UrlToPdf($url,[
				"page_width" => "13cm",
				"page_height" => "6.5cm",
				"margin_top" => "0cm",
				"margin_right" => "0cm",
				"margin_bottom" => "0cm",
				"margin_left" => "0cm",
				"delay" => 200, // 200 ms, jistotka pro nacteni fontu
				"page_ranges" => "1",
			]);
			$filename = $utp->process();

			if(!$filename){
				return $this->_execute_action("error500");
			}

			$this->render_template = false;
			$this->response->setContentType("application/pdf");
			$this->response->setContentCharset(null);
			$this->response->setHeader("Content-Disposition",sprintf('inline; filename="%s"',"voucher_".$voucher->getId().".pdf"));
			$this->response->buffer->addFile($filename);

			$ctrl = $this;
			$this->_append_after_filter(function() use($ctrl,$filename){
				$ctrl->response->flushAll();
				unlink($filename);
			});

			return;
		}

		$currency = $region->getDefaultCurrency();
		$discount_amount = $voucher->getDiscountAmount() / $currency->getRate();
		$domain = $region->getDefaultDomain();
		$domain = preg_replace('/^www\./','',$domain);

		$lang = $region->getDefaultLanguage();
		$this->tpl_data["lang"] = $lang;
		Atk14Locale::Initialize($lang);

		$this->tpl_data["voucher"] = $voucher;
		$this->tpl_data["region"] = $region;
		$this->tpl_data["currency"] = $currency;
		$this->tpl_data["discount_amount"] = $discount_amount;
		$this->tpl_data["domain"] = $domain;

	}

	function _before_filter(){
		//$pdficate = new Pdficate\Client();
		if(!(($this->logged_user && $this->logged_user->isAdmin()) || IP::Match($this->request->getRemoteAddr(), [
				"127.0.0.1",
				//$pdficate->getServerAddr(),
			]))){
			return $this->_execute_action("error403");
		}
	}
}
