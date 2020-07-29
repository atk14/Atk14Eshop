{javascript_tag}
window.addEventListener( "load", function() {
	window.cookieconsent.initialise( {
		"palette": {
			"popup": {
				"background": "#eee",
				"text": "#838391"
			},
				"button": {
				"background": "#81971a",
				"text": "#ffffff" 
			}
		},
		"content": {
			"message": "{t app_name=$current_region->getApplicationName() escape=false}K provozování webu %1 využíváme takzvané cookies. Cookies jsou soubory sloužící k přizpůsobení obsahu webu, k měření jeho funkčnosti a k zajištění vaší maximální spokojenosti. Používáním tohoto webu souhlasíte s tím, jak soubory cookies dále používáme.{/t}",
			"dismiss": "{t}Souhlasím{/t}",
			"link": "{t}Více informací{/t}",
			"href": "{"privacy_policy"|link_to_page}"
		},
		"container": document.getElementById("js--cookieconsent-container")
	} ); 
} );
{/javascript_tag}
