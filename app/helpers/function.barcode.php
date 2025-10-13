<?php
/**
 *	<img src="{barcode content=12345}">
 */
function smarty_function_barcode($params,$template){
	$params += [
		"content" => "",
		"type" => "I25",
		"color" => "black",
		
		"w" => 2, // Width of a single rectangle element in user units
		"h" => 60, // Height of a single rectangle element in user units
	];

	$content = (string)$params["content"];

	if($content === ""){
		return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII="; // 1x1px transparent image
	}

	// Barcode Types
	// =============
	//
	// C39+ : CODE 39 with checksum
	// C39E : CODE 39 EXTENDED
	// C39E+ : CODE 39 EXTENDED + CHECKSUM
	// C93 : CODE 93 - USS-93
	// S25 : Standard 2 of 5
	// S25+ : Standard 2 of 5 + CHECKSUM
	// I25 : Interleaved 2 of 5
	// I25+ : Interleaved 2 of 5 + CHECKSUM
	// C128 : CODE 128
	// C128A : CODE 128 A
	// C128B : CODE 128 B
	// C128C : CODE 128 C
	// EAN2 : 2-Digits UPC-Based Extension
	// EAN5 : 5-Digits UPC-Based Extension
	// EAN8 : EAN 8
	// EAN13 : EAN 13
	// UPCA : UPC-A
	// UPCE : UPC-E
	// MSI : MSI (Variation of Plessey code)
	// MSI+ : MSI + CHECKSUM (modulo 11)
	// POSTNET : POSTNET
	// PLANET : PLANET
	// RMS4CC : RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
	// KIX : KIX (Klant index - Customer index)
	// IMB: Intelligent Mail Barcode - Onecode - USPS-B-3200
	// CODABAR : CODABAR
	// CODE11 : CODE 11
	// PHARMA : PHARMACODE
	// PHARMA2T : PHARMACODE TWO-TRACKS
	$barcodeobj = new TCPDFBarcode((string)$content, $params["type"]);
	$output = $barcodeobj->getBarcodeSVGcode($params["w"], $params["h"], $params["color"]);

	$output = "data:image/svg+xml;base64,".base64_encode($output);

	return $output;
}
