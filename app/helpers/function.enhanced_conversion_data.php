<?php

function smarty_function_enhanced_conversion_data($params, $template) {
	$params += [ ];

	$ec_enabled = SystemParameter::ContentOn("app.trackers.google.ads.use_enhanced_conversion.manual_gtm");
	$track_order = $template->getTemplateVars("track_order");
	$order = $template->getTemplateVars("order");

	if (!$order || !$track_order || !$ec_enabled) {
		return null;
	}

	$address = [
		"first_name" => $order->getFirstname(),
		"last_name" => $order->getLastname(),
		"street" => $order->getAddressStreet(),
		"city" => $order->getAddressCity(),
		"postal_code" => $order->getAddressZip(),
		"country" => $order->getAddressCountry(),
	];

	$conversion_data = [
		"email" => $order->getEmail(),
		"phone_number" => $order->getDeliveryPhone(),
	];
	$conversion_data["address"] = array_filter($address);

	$conversion_data = array_filter($conversion_data);

	Atk14Require::Helper("block.javascript_tag");

	$out = sprintf("var enhanced_conversion_data = %s", json_encode($conversion_data));
	return smarty_block_javascript_tag($params, $out, $template, $false);
}

