<?php
function smarty_function_meta14($params, $template) {
	$smarty = atk14_get_smarty_from_template($template);
	$meta = $smarty->getTemplateVars("meta14");
	if(!$meta) {
		return null;
	}

	$out = [];
	foreach($meta->getItems() as $type => $i) {
		foreach($i as $key => $values) {
			if (is_array($values)) {
				foreach($values as $value) {
					$out[] = sprintf('<meta %s="%s" content="%s">', $type, $key, $value);
				}
			} else {
				$out[] = sprintf('<meta %s="%s" content="%s">', $type, $key, $values);
			}
		}
	}
	$out = join("\n", $out);
	DEVELOPMENT && trigger_error($out);
	return $out;
}
