<?php
function smarty_function_head_tags_14($params, $template) {
	$smarty = atk14_get_smarty_from_template($template);
	$header = $smarty->getTemplateVars("head_tags");
	if(!$header) {
		return null;
	}

	$out = [];
	DEVELOPMENT && ($out[] = "<!-- Head tags from helper - START -->\n");
	# name, property, http-equiv
	foreach($header->getMetaTags() as $type => $i) {
		# type name like google-site-verification in <meta name>, og:title in <meta property>
		foreach($i as $key => $elements) {
			# single type meta - make it an array so we can loop it
			if (!is_array($elements)) {
				$elements = [$elements];
			}

			foreach($elements as $element) {
				$out[] = (string)$element;
			}
		}
	}

	foreach($header->getLinkTags() as $link_type => $links) {
			if (!is_array($links)) {
				$links = [$links];
			}
		foreach($links as $link) {
			$out[] = (string)$link;
		}
	}

	DEVELOPMENT && ($out[] = "\n<!-- Head tags from helper - END -->\n");

	$out = join("\n", $out);
	DEVELOPMENT && trigger_error($out);
	return $out;
}
