<?php

namespace StructuredData\Element;


/**
 * Example 1
 * ```
 * $bclist = new StructuredDataBreadcrumbList($card->getPrimaryCategory(), ["add_parent_elements" => true]);
 * $bclist->addListItem($card);
 * ```
 *
 * Example 2
 * ```
 * $bclist = new StructuredDataBreadcrumbList();
 * $bclist->addListItem($card->getPrimaryCategory(), ["add_parent_elements" => true]);
 * $bclist->addListItem($card);
 * ```
 *
 */
class BreadcrumbList extends \StructuredData\BaseElement {

	function __construct(\ApplicationModel $item=null, $options=[]) {
		$options += [
			"add_index" => true,
		];
		$this->options = $options;

		if (is_null($item)) {
			return;
		}

		$this->addListItem($item, $options);
	}

	function addListItem(\ApplicationModel $item, $options=[]) {
		$options += [
			"add_parent_elements" => false,
		];
		if ($options["add_parent_elements"] && ($item instanceof \Category)) {
			$_items = \Category::GetInstancesOnPath($item->getPath());
			foreach($_items as $_i) {
				$this->list_items[] = $_i;
			}
			return;
		}
		$this->list_items[] = $item;
	}

	function toArray() {
		$_position = 1;
		$out = [
			"@context" => "https://schema.org",
			"@type" => "BreadcrumbList",
			"itemListElement" => [ ],
		];
		if ($this->options["add_index"]) {
			$out["itemListElement"][] = [
				"@type" => "ListItem",
				"position" => $_position++,
				"name" => _("Home"),
				"item" => [
					"@type" => "Thing",
					"@id" => \Atk14Url::BuildLink(["action" => "main/index"], ["with_hostname" => true]),
				],
			];
		}

		foreach($this->list_items as $_path => $_c) {
			$sd_item = new BreadcrumbListItem($_c);
			$itemAr = $sd_item->toArray();
			$itemAr["position"] = $_position++;
			$out["itemListElement"][] = $itemAr;
		}

		return $out;
	}
}
