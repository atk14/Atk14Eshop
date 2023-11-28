<?php
/**
 * More info at https://developers.facebook.com/docs/sharing/webmasters#markup.
 *
 * @todo support more types
 */
namespace HeadTags\Support;

class OpenGraph {

	static function GetDescription(\Atk14Controller $controller) {
		$_key = join("/", [$controller->controller, $controller->action]);
		switch($_key) {
		case "articles/detail":
			$out = $controller->tpl_data["article"]->getTeaser();
			break;
		case "cards/detail":
			$out = $controller->card->getTeaser();
			break;
		case "pages/detail":
			$out = $controller->page->getTeaser();
			break;
		default:
			$out = $controller->page_description;
			break;
		}
		$out = new \String4($out);
		$out = h($out->stripHtml());
		return (string)$out;
	}

	static function GetTitle(\Atk14Controller $controller) {
		$_key = join("/", [$controller->controller, $controller->action]);
		switch($_key) {
		case "articles/detail":
			$out = $controller->tpl_data["article"]->getTitle();
			break;
		case "cards/detail":
			$out = $controller->card->getName();
			break;
		case "pages/detail":
			$out = $controller->page->getTitle();
			break;
		default:
			$out = sprintf("%s | %s", $controller->page_title, ATK14_APPLICATION_NAME);
			break;
		}
		return $out;
	}

	static function GetImage(\Atk14Controller $controller) {
		\Atk14Require::Helper("modifier.img_url");

		$out_url = \SystemParameter::ContentOn("app.social.default_image");
		$image_url = null;
		$_key = join("/", [$controller->controller, $controller->action]);
		switch($_key) {
		case "articles/detail":
			$image_url = $controller->tpl_data["article"]->getImageUrl();
			break;
		case "cards/detail":
			$image_url = $controller->card->getImage();
			break;
		case "pages/detail":
			$image_url = $controller->page->getImageUrl();
			break;
		default:
			break;
		}
		if ($image_url) {
			$out_url = smarty_modifier_img_url($image_url, "1200x628x#ffffff");
		}
		return $out_url;
	}

	static function GetType(\Atk14Controller $controller) {
		$out = "website";
		$_map = [
			"articles/detail" => "article",
			"pages/detail" => "article",
			"cards/detail" => "article",
		];
		$_key = join("/", [$controller->controller, $controller->action]);
		if (isset($_map[$_key])) {
			$out = $_map[$_key];
		}
		return $out;
	}
}
