<?php
/**
 * The application's mailer class.
 *
 * In DEVELOPMENT emails are not sent for real,
 * they are logged to the application's log instead.
 *
 * Within a controller one can send an email like this:
 *     $this->mailer->execute("notify_user_registration",$user);
 *
 * Be aware of the fact that $this->mailer is a member of Atk14MailerProxy,
 * so you can use it this way
 *     $this->mailer->notify_user_registration($user);
 */
class ApplicationMailer extends Atk14Mailer {

	var $current_region = null; // should be set in a controller

	var $prev_lang = "";

	// preheader text neni videt v otevrenem mailu, ale byva casto videt v mailovem klientu
	// v seznamu mailu pod subjectem
	var $preheader_text = "";

	/**
	 * A place for common configuration.
	 */
	function _before_filter(){
		if(!$this->current_region){
			$this->current_region = Region::GetDefaultRegion();
		}

		$this->content_type = "text/plain";
		$this->content_charset = DEFAULT_CHARSET; // "UTF-8"
		//$this->from = DEFAULT_EMAIL;
		$this->bcc = SystemParameter::ContentOn("app.bcc");
		$this->_initialize_for_region($this->current_region);
		
		// General settings
		$this->tpl_data["body_width"] = "580px"; // Container width
		$this->tpl_data["bg_color"] = "#f2f4f2";
		$this->tpl_data["container_bg_color"] = "#f2f4f2";
		$this->tpl_data["font_stack"] = "Helvetica, Arial, sans-serif";
		$this->tpl_data["text_color"] = "#212121";
		$this->tpl_data["link_color"] = "#AF662F";
		$this->tpl_data["link_style"] = "color: #AF662F; font-weight: bold; text-decoration: none;";
		$this->tpl_data["visited_link_color"] = "#AF662F";
		
		// Header colors + logo
		$this->tpl_data["header_bgcolor"] = "white";
		$this->tpl_data["header_color"] = "#5F2929";
		$this->tpl_data["logo_src"] = $this->current_region->getDefaultUrl()."public/dist/images/logo_email_header--dark.png";
		
		// Footer colors
		$this->tpl_data["footer_bgcolor"] = "#ccc";
		$this->tpl_data["footer_color"] = "#555";
		$this->tpl_data["footer_link_color"] = "#555";
		
		// Boxed title colors 
		$this->tpl_data["titlebox_bgcolor"] = "#5F2929";
		$this->tpl_data["titlebox_color"] = "#fff";
		$this->tpl_data["special_note_bgcolor"] = "#FFA334"; // special note
		$this->tpl_data["special_note_color"] = "#fff";
		
		// Table colors
		$this->tpl_data["table_header_bgcolor"] = "#b9babe"; // th
		$this->tpl_data["table_header_color"] = "#212121";
		$this->tpl_data["table_cell_bgcolor"] = "#EBECEE";
		$this->tpl_data["table_cell_color"] = "#212121";
		$this->tpl_data["table_accent_bgcolor"] = "#555"; // total sum row
		$this->tpl_data["table_accent_color"] = "#fff";
		
		$this->clear_attachments();
	}

	function _before_render(){
		parent::_before_render();
		$this->tpl_data["preheader_text"] = $this->preheader_text;
	}

	function _after_render(){
		if(!$this->body && $this->body_html){
			// Missing plain text body will be automatically created from the HTML body.
			// Unwanted parts in the email layout can be marked with HTML comments and will be filtered out.
			$html = $this->body_html;
			$html = preg_replace('/<!-- header -->.+<!-- \/header -->/s','',$html);
			$html = preg_replace('/<!-- footer -->.+<!-- \/footer -->/s','',$html);
			$converter = new \Html2Text\Html2Text($html,array("width" => 80));
			$this->body = trim($converter->getText());
			// TODO: Je toto neco, co skutecne chceme?
			//if($this->preheader_text){
			//	$this->body = $this->preheader_text . "\n\n" . $this->body;
			//}
		}
	}

	function _after_filter(){
		if($this->prev_lang){
			$lang = $this->prev_lang;
			Atk14Locale::Initialize($lang);
			$this->prev_lang = "";
		}
		$this->preheader_text = "";
	}

	function _initialize_for_region($region = null){
		global $HTTP_REQUEST, $ATK14_GLOBAL;

		$region = $region ? $region : $this->current_region;
		$this->current_region = $region;
		$this->tpl_data["region"] = $region;
		$this->from = $region->getEmail();
		$this->from_name = $region->getApplicationName();

		if($HTTP_REQUEST->getRemoteAddr()){
			// on a proper HTTP request, the current language should be used (if supported)
			$supported_langs = $region->getLanguages(array("as_objects" => false));
			$lang = in_array($ATK14_GLOBAL->getLang(),$supported_langs) ? $ATK14_GLOBAL->getLang() : (string)$region->getDefaultLanguage();
		}else{
			$lang = (string)$region->getDefaultLanguage();
		}
		$this->prev_lang = Atk14Locale::Initialize($lang);
	}

	function notify_user_registration($user){
		$this->tpl_data["user"] = $user;
		$this->to = $user->getEmail();
		$this->subject = _("New registration");
		// body is rendered from app/views/mailer/notify_user_registration.tpl
	}

	function notify_password_recovery($password_recovery){
		$this->tpl_data["user"] = $user = $password_recovery->getUser();
		$this->tpl_data["password_recovery"] = $password_recovery;

		$this->to = $user->getEmail();
		$this->subject = _("Reset Your Password");
		// body is rendered from app/views/mailer/notify_password_recovery.tpl
	}

	function notify_password_update_in_recovery($password_recovery){
		$this->tpl_data["user"] = $user = $password_recovery->getUser();
		$this->tpl_data["password_recovery"] = $password_recovery;

		$this->to = $user->getEmail();
		$this->subject = _("Your password was updated");
	}

	function notify_order_creation($order){
		$region = $order->getRegion();
		$this->_initialize_for_region($region);
		$this->to = $order->getEmail();
		$this->tpl_data["order"] = $order;
		$this->tpl_data["currency"] = $order->getCurrency();
		$this->tpl_data["shipping_days"] = SystemParameter::ContentOn("orders.notifications.shipping_days");
		$this->tpl_data["special_note"] = SystemParameter::ContentOn("orders.notifications.special_note");
		$this->subject = sprintf(_("Order %d"),$order->getOrderNo());
	}

	function notify_order_status_update($order){
		$region = $order->getRegion();
		$this->_initialize_for_region($region);
		$this->to = $order->getEmail();
		$this->sms_phone_number = $order->getDeliveryPhone(); // dorucovaci adresa je povinna, fakturacni nikoli
		$this->tpl_data["order"] = $order;
		$this->tpl_data["order_status"] = $order_status = $order->getOrderStatus();
		$this->tpl_data["order_status_code"] = $order_status->getCode();
		$this->tpl_data["delivery_method"] = $delivery_method = $order->getDeliveryMethod();
		$this->tpl_data["personal_pickup_on_store"] = $delivery_method->getPersonalPickupOnStore();
		$this->tpl_data["currency"] = $order->getCurrency();
		$this->subject = sprintf(_("Objednávka %s"),$order->getOrderNo())." - ".$order_status->getName();
	}

	/**
	 *	$mailer->contact_message(array(
	 *		"name" => "John Doe",
	 *		"email" => "john@doe.com",
	 *		"body" => "Hi, I just lost my password..."
	 *	),$request->getRemoteAddr(),$logged_user);
	 */
	function contact_message($params,$request,$logged_user){
		$this->to = DEFAULT_EMAIL;
		$this->subject = _("Message sent from contact page");
		$this->reply_to = $params["email"];
		$this->reply_to_name = $params["name"];
		$this->tpl_data += $params;
		$this->tpl_data["request"] = $request;
		$this->tpl_data["logged_user"] = $logged_user;
		$this->render_layout = false;
	}

	function send_information_request($params,$request,$logged_user){
		$this->to = DEFAULT_EMAIL;
		$this->subject = _("Request for information");
		$this->tpl_data += $params;
		$this->tpl_data["request"] = $request;
		$this->tpl_data["logged_user"] = $logged_user;
		$this->render_layout = false;
	}

	function send_copy_of_information_request_to_customer($email,$text){
		$this->to = $email;
		$this->subject = _("Request for information");
		$this->tpl_data["text"] = $text;
	}
}
