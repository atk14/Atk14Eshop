<?php

Atk14Require::Helper("block.javascript_tag");
//Atk14Require::Helper("function.render");
// smarty_function_render

/**
 * This helper generates tracking code for Facebook Pixel.
 *
 * Code in basic mode with only PageView event.
 * ```
 * {facebook_pixel}
 * ```
 *
 * Advanced code tracking more events.
 * ```
 * {facebook_pixel mode=advanced}
 * ```
 *
 * @param array $params
 * - mode
 * 	- basic - only PageView event is tracked
 * 	- advanced - PageView and also other events in basic form are tracked
 * 	- full - planned - additional parameters would be sent with events like product ids, currencies etc
 * - part
 * 	- head default
 * 	- body noscript part of the tracking code should go to body as it contains <img> tag
 * @return string
 */
function smarty_function_facebook_pixel($params, $template) {

	$params += [
		"mode" => "basic",
		"part" => "head",
	];

	$template_dir = "shared/helpers/facebook_pixel/";

	$facebook_pixel_id = SystemParameter::ContentOn("app.trackers.facebook.pixel.tracking_id");
	if (!$facebook_pixel_id) {
		return "";
	}

	$base_out = "";
	$out_events = [];

	$currency = null;
	$request = $template->getTemplateVars("request");
	$controller = $template->getTemplateVars("controller");
	$action = $template->getTemplateVars("action");
	$order = $template->getTemplateVars("order");
	$order && ($currency = $order->getCurrency());

	$smarty = atk14_get_smarty_from_template($template);

	$smarty->assign("facebook_pixel_id", "$facebook_pixel_id");

	$out_noscript = $smarty->fetch($template_dir."_base_code_noscript.tpl");

	# u xhr requestu nechceme natahovat zakladni knihovnu
	if (!$request->xhr()) {
		$base_out = $smarty->fetch($template_dir."_base_code.tpl");
	}

	if ($params["part"]==="body") {
		return "\n$out_noscript\n";
	}
	if ($params["mode"]==="basic") {
		return "{$base_out}\n";
	}


	$event_template_name = "";
	if ($controller==="cards" && $action==="detail") {
		$event_template_name = "_content_view.tpl";
	} elseif ($controller==="orders" && $action==="finish" && $order) {
		$event_template_name = "_purchase.tpl";
		$smarty->assign("fb_pixel_properties", [
			"currency" => "$currency",
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
		$out_events[] = $smarty->fetch($template_dir.$event_template_name);
	}

	$out_events = join("\n", $out_events);

	# js kod chceme obalit tagem <script> jen u neXHR requestu
	if (!$request->xhr()) {
		$out_events = smarty_block_javascript_tag($params, $out_events, $template, $repeat);
	}
	$out = "$base_out\n$out_events\n";

	$out = "\n<!-- Facebook Pixel Code -->\n{$out}\n<!-- End Facebook Pixel Code -->\n";

	// DEVELOPMENT && !$request->xhr() && trigger_error($out);
	return $out;
}

