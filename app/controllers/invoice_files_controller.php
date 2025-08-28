<?php
class InvoiceFilesController extends ApplicationController {

	function detail(){
		$invoice = InvoiceFile::GetInstanceByToken($this->params->getString("token"),["extra_salt" => "invoice_detail"]);
		if(!$invoice || $invoice->getFilename()!=$this->params->getString("filename")){ return $this->_execute_action("error404"); }

		$order = $invoice->getOrder();
		$user = $order->getUser();

		if(!(
			(is_null($user)) || // nakup bez registrace
			($this->logged_user && $this->logged_user->getId()==$user->getId()) || // prihl. user je stejny jako v objednavce
			($this->logged_user && $this->logged_user->isAdmin()) // prihl. user je admin? neni co resit
		)){
			if(!$this->logged_user){
				$this->flash->notice(sprintf(_("Přihlašte se prosím jako uživatel <em>%s</em>"),h($user->getLogin())));
				return $this->_redirect_to([
					"action" => "logins/create_new",
					"login" => $user->getLogin(),
					"return_uri" => $this->request->getUri(),
				]);
			}
			return $this->_execute_action("error403");
		}

		if(!file_exists($invoice->getFullPath())){
			$this->render_template = false;
			$this->response->notFound("Soubor s fakturou v PDF nebyl nalezen.");
			return;
		}

		$this->render_template = false;
		$this->response->setContentType($invoice->getMimeType());
		$this->response->buffer->addFile($invoice->getFullPath());
	}
}
