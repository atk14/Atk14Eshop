<?php
/**
* Zobrazi typ iobjektu v citelne podobe
*
* Usage in templates:
*
* ```
* {$iobject|iobject_type}
* ```
*
*/
function smarty_modifier_iobject_type($iobject){
	switch ($table = $iobject->getReferredTable()) {
		case "videos":
			$type = _("Video");
			$icon = "fas fa-video";
			break;
		case "galleries":
			$type = _("Galerie");
			$icon = "fas fa-images";
			break;
		case "pictures":
			$type = _("Obrázek");
			$icon = "fas fa-camera";
			break;
		case "card_promotions":
			$type = _("Propagace produktu");
			$icon = "fas fa-ad";
			break;
		default:
			$type = sprintf("%s #%d", $table, $iobject->getId());
			$icon = "fas fa-file";
			break;
	}
	return sprintf('<span class="%s" title="%s"></span>', $icon, $type);
}
