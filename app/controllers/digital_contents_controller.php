<?php
class DigitalContentsController extends ApplicationController {

	function index(){
		$order = $this->order;

		$digital_contents = DigitalContent::GetInstancesByOrder($order);
		$digital_contents_by_products = [];
		foreach($digital_contents as $dc){
			$p = $dc->getProduct();
			$p_id = $p->getId();
			if(!isset($digital_contents_by_products[$p_id])){
				$digital_contents_by_products[$p_id] = [
					"product" => $p,
					"items" => [],
				];
			}
			$digital_contents_by_products[$p_id]["items"][] = $dc;
		}

		$this->_add_order_to_breadcrumbs($order);
		$this->breadcrumbs[] = _("Digitální produkty");

		$this->page_title = sprintf(_("Digitální produkty v objednávce %s"),$order->getOrderNo());

		$this->tpl_data["order"] = $order;
		$this->tpl_data["digital_contents"] = $digital_contents;
		$this->tpl_data["digital_contents_by_products"] = $digital_contents_by_products;

		$this->head_tags_14->setMeta("robots", "noindex,noarchive");
	}

	function download(){
		$order = $this->order;

		$digital_content = DigitalContent::GetInstanceByToken($this->params->getString("token"),DigitalContent::GetDigitalContentTokenOptions($order));
		if(!$digital_content || !$digital_content->isActive() || $digital_content->isDeleted()){
			return $this->_execute_action("error404");
		}

		if($this->params->getString("filename")!==$digital_content->getFilename()){
			return $this->_redirect_to($digital_content->getDownloadUrl($order));
		}

		myAssert(file_exists($digital_content->getFullPath()));
		
		DigitalContentDownload::CreateNewRecord([
			"order_id" => $order,
			"digital_content_id" => $digital_content,
		]);

		$this->render_template = false;
		$this->response->setContentType($digital_content->getMimeType());
		$this->response->setHeader(sprintf('Content-Disposition: attachment; filename="%s"',$digital_content->getFilename()));
		$this->response->buffer->addFile($digital_content->getFullPath());
	}

	function _before_filter(){
		$this->_find_order();
	}

	function _find_order($option = []){
		$order = Order::GetInstanceByToken($this->params->getString("order_token"),DigitalContent::GetOrderTokenOptions());
		if(!$order){
			$this->_execute_action("error404");
			return;
		}

		if(!$order->canBeFulfilled()){
			$this->_execute_action("error403");
			return;
		}

		$digital_contents = DigitalContent::GetInstancesByOrder($order);
		if(!$digital_contents){
			$this->_execute_action("error404");
			return;
		}

		$user = $order->getUser();
		if($user && (!$this->logged_user || $user->getId()!==$this->logged_user->getId())){
			$this->flash->info(sprintf(_("Pro stažení digitálních souborů z objednávky se prosím přihlaste jako uživatel <em>%s</em>"),h($user->getLogin())));
			$this->_redirect_to([
				"namespace" => "",
				"action" => "logins/create_new",
				"return_uri" => $this->_link_to(["action" => "digital_contents/index", "order_token" => $order->getToken(DigitalContent::GetOrderTokenOptions())]),
				"login" => $user->getLogin(),
			]);
			return;
		}

		$this->order = $order;
		return $order;
	}
}
