<?php

Atk14Require::Helper("block.javascript_tag");
//Atk14Require::Helper("function.render");
// smarty_function_render

/**
 *
 * @param array $params
 * - mode
 * 	- basic - only PageView event is tracked
 * 	- advanced - PageView and also other events in basic form are tracked
 * 	- full - planned - additional parameters would be sent with events like product ids, currencies etc
 * @return string
 */
function smarty_function_facebook_pixel($params, $template) {
	$params += [
		"mode" => "basic",
	];
	$template_dir = "shared/helpers/facebook_pixel/";

	$facebook_pixel_id = SystemParameter::ContentOn("app.trackers.facebook.pixel.tracking_id");
	if (!$facebook_pixel_id) {
		return "";
	}

	$base_out = "";

	$currency = null;
	$request = $template->getTemplateVars("request");
	$controller = $template->getTemplateVars("controller");
	$action = $template->getTemplateVars("action");
	$order = $template->getTemplateVars("order");
	$order && ($currency = $order->getCurrency());

	$smarty = atk14_get_smarty_from_template($template);

	$smarty->assign("facebook_pixel_id", "$facebook_pixel_id");

	# u xhr requestu nechceme natahovat zakladni knihovnu
	if (!$request->xhr()) {
		$base_out = $smarty->fetch($template_dir."_base_code.tpl");
	}

	if ($params["mode"]==="basic") {
		return $base_out;
	}

	$event_template_name = "";
	if ($controller==="cards" && $action==="detail") {
		$event_template_name = "_content_view.tpl";
	} elseif ($controller==="orders" && $action==="finish" && $order) {
		$event_template_name = "_purchase.tpl";
		$smarty->assign("fb_pixel_properties", [
			"currency" => "${currency}",
			"value" => $order->getItemsPrice(),
		]);
	} elseif ($controller==="baskets" && $action==="add_product") {
		$event_template_name = "_add_to_cart.tpl";
	}

	if ($request->xhr()) {
		$event_template_name = preg_replace("/\.tpl$/", ".xhr.tpl", $event_template_name);
	}
	# nacteni sablony pro konkretni udalost
	if ($event_template_name && $smarty->templateExists($template_dir.$event_template_name)) {
		$event_out = $smarty->fetch($template_dir.$event_template_name);
	}

	# js kod chceme obalit tagem <script> jen u neXHR requestu
	if (!$request->xhr()) {
		$event_out= smarty_block_javascript_tag($params, $event_out, $template, $repeat);
	}
	$out = "$base_out\n$event_out";

	// DEVELOPMENT && !$request->xhr() && trigger_error($out);
	return $out;
}

