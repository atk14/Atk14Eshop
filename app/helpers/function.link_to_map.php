<?php
/**
 *	{link_to_map service="seznam" lat="50.0769619" lng="14.4407769"}
 *	{link_to_map service="google" lat="50.0769619" lng="14.4407769"}
 *	{link_to_map lat="50.0769619" lng="14.4407769"}
 */
function smarty_function_link_to_map( $params ){
	$params += array(
		"service" => "google",
		"lat"		  => 0,
		"lng"		  => 0,
	);
	
	if( $params["service"] == 'google' ){
		$result = sprintf( 'https://www.google.com/maps/search/?api=1&query=%s%%2C%s', $params["lat"], $params["lng"]  );
	}
	
	if( $params["service"] == 'seznam' ){		
		$result = sprintf( 'https://mapy.cz/zakladni?x=%1$s&y=%2$s&z=17&source=coor&id=%1$s%%2C%2$s&q=%2$s%%2C%1$s', $params["lng"], $params["lat"] );
	}
	
	return $result;
}
