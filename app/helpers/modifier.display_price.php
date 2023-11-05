<?php
/**
 * Vstupem muze byt float nebo objekt tridy ProductPrice. Objekt potom musi obsahovat metodu getPrice()
 * Vychozi hodnoty vychazi z navrhu. Temer na vsech mistech se zobrazuje cena s dph v celych korunach,
 *
 * {$product_price|display_price}
 * {$basket|display_price}
 * {$basket|display_price:"summary"} // toto vytiskne desetiny pro sumarizaci: pro CZK bez des. mist, u EUR vytiskne 2 desetiny
 * {$basket|display_price:"EUR"} // "100,40 EUR"
 * {$basket|display_price:"CZK"} // "100 Kč"
 * {$basket|display_price:$currency} // "100 Kč" n. "100,40 EUR"
 *
 *
 *	mozne options:
 *	- decimals = x - pocet desetinek - vychozi 0
 *	- mark_decimals - desetinna mista budou v markupu oznacena
 *	- without_vat
 *	- currency - "oznaceni meny (Kc, EUR, co je treba)"
 *	- negative - vynasobu cenu minus jednickou, vhodne pro tisk slev
 * -- ordering_unit - pokud je zadano, zobrazi se jednotka, pro kterou je cena urcena (napr. "m" => Kc/m, "ks" => Kc/ks)
 */
function smarty_modifier_display_price($price_or_object, $options = array()){
	if(!isset($price_or_object)){
		return "";
	}

	$current_currency = Currency::GetDefaultCurrency();

	if(is_object($options)){
		$current_currency = $options;
		$options = array();
	}

	if(!is_array($options)) {
		$_options = array_filter(explode(",",$options));
		$options = array();

		foreach($_options as $_o) {
			if (preg_match('/^[A-Z]{3}$/', $_o)){
				$_c = Currency::GetInstanceByCode($_o);
				if(!$_c){ throw new Exception("Unknow currency $_o"); }
				$current_currency = $_c;

			}elseif (preg_match("/^(.+)=(.+)$/", $_o, $m)) {
				if($m[2]==="false"){ $m[2] = false; } // "false" -> false
				if($m[2]==="true"){ $m[2] = true; } // "true" -> true
				$options[$m[1]]=$m[2];
			} else {
				$options[$_o] = true;
			}
		}
	}

	$options += array(
		"summary" => false, // true, false or "auto" automatic detection of "summary" or not "summary"
		"show_decimals" => true,
		// also the following options are available
		// "show_decimals_on_czk" => true,
		// "show_decimals_on_eur" => true,
		// ...
		"without_vat" => false,
		"show_vat_label" => false,
		"currency" => $current_currency->getSymbol(), // "Kč", "EUR"...
		"show_currency" => true,
		"mark_decimals" => false,
		"show_zero" => true,
		"format" => "html", // "html" n. "plain"
		"negative" => false,
		"ordering_unit" => null,
	);
	$currency = $options["currency"];
	if(is_object($currency)){
		$current_currency = $currency;
		$currency = $currency->getSymbol();
	}

	$options += array(
		"decimals" => $current_currency->getDecimals(),
	);

	$currency_lower = strtolower($current_currency->getCode());

	if(!$options["show_decimals"] || (isset($options["show_decimals_on_$currency_lower"]) && !$options["show_decimals_on_$currency_lower"])){
		$options["decimals"] = 0;
	}

	if(is_object($price_or_object)){
		$product_price = $options["without_vat"] ? $price_or_object->getUnitPrice() : $price_or_object->getUnitPriceInclVat();
	} else {
		$product_price = $price_or_object;
	}

	if($product_price == 0 && !$options['show_zero'])  {
		return '';
	}

	if($options["summary"]==="auto"){
		$options["summary"] = round($product_price,$current_currency->getDecimals())===round($product_price,$current_currency->getDecimalsSummary());
	}

	if($options["summary"]){
		$options["show_decimals"] = true;
		$options["decimals"] = $current_currency->getDecimalsSummary();
	}

	if($options["negative"]){
		$product_price = -1.0 * $product_price;
	}

	$formatted_price = __format_price__($product_price,$options["decimals"]);
	if ($options["mark_decimals"]) {
		$formatted_price = preg_replace("/,(\d+)$/",'<span class="decimals">,\1</span>', $formatted_price);
	}
	if($product_price==0.0 && $options["negative"]){
		$formatted_price = "-$formatted_price"; // "0,00" -> "-0,00"
	}
	$ordering_unit = "";
	if ($options["ordering_unit"]) {
		$ordering_unit = "/".$options["ordering_unit"];
	}

	$vat_label = "";
	if ($options["show_vat_label"]) {
		$vat_label = $options["without_vat"] ? _("excl. VAT") : _("incl. VAT");
		$vat_label = " <span class=\"vat_label\">$vat_label</span>";
	}

	$currency_str = $options["show_currency"] ? "&nbsp;<span class=\"currency_main__currency\">${currency}</span>" : "";
	$out = sprintf("<span class=\"currency_main\"><span class=\"currency_main__price\">%s</span>$currency_str<span class=\"currency_main__ordering-unit\">${ordering_unit}</span></span>${vat_label}",$formatted_price);

	if($options["format"]=="plain"){
		$out = strip_tags($out);
		$out = str_replace('&nbsp;',' ',$out);
	}

	return $out;
}

function __format_price__($price,$decimals = 0){
	$decimals = (int)$decimals;
	Atk14Require::Helper("modifier.display_number");
	$out = number_format($price,$decimals,".","");
	return smarty_modifier_display_number($out);
}
