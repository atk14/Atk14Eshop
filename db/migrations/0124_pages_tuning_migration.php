<?php
class PagesTuningMigration extends ApplicationMigration {

	function up(){
		$homepage = Page::FindByCode("homepage");
		$homepage && $homepage->s([
			"title_en" => "Welcome to ATK14 Eshop",
			"teaser_en" => "_ATK14 Eshop_ is an skeleton suitable for eshops. It is built on top of _ATK14 Catalog_.",
			"body_en" => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur efficitur tortor orci, vel volutpat ligula efficitur in. Nam ut iaculis nisl. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam sed auctor eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras elementum imperdiet mauris, vel mattis ipsum aliquet vitae. Maecenas nec ex elit. Mauris dictum ultricies nisl ut finibus. Donec gravida lacus mauris, et sodales dui gravida ac. Praesent ut ante a lectus luctus sollicitudin id sagittis elit. Praesent tincidunt metus non dui euismod tristique.

Aliquam quis sem neque. In mollis augue id turpis porttitor, vel auctor libero lobortis. Duis viverra blandit justo, id commodo nisi cursus et. Suspendisse potenti. Curabitur consequat orci vulputate ligula lacinia, vel vulputate purus commodo. Vestibulum rhoncus, sapien in bibendum ornare, elit nisi suscipit lacus, eget vulputate eros nibh vitae felis. Mauris sit amet condimentum dolor. Nunc venenatis, lacus vitae ultrices fermentum, libero ipsum rhoncus nisi, in lobortis enim massa nec lectus. Integer eu neque suscipit, consequat mauris nec, consectetur dui.',
			"page_title_en" => "ATK14 Eshop",

			"title_cs" => "Vítejte v ATK14 E-shopu",
			"teaser_cs" => "_ATK14 E-shop_ je aplikační kostra vhodná pro e-shopy, která je postavena na _ATK14 Katalogu_.",
			"body_cs" => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur efficitur tortor orci, vel volutpat ligula efficitur in. Nam ut iaculis nisl. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nullam sed auctor eros. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Cras elementum imperdiet mauris, vel mattis ipsum aliquet vitae. Maecenas nec ex elit. Mauris dictum ultricies nisl ut finibus. Donec gravida lacus mauris, et sodales dui gravida ac. Praesent ut ante a lectus luctus sollicitudin id sagittis elit. Praesent tincidunt metus non dui euismod tristique.

Aliquam quis sem neque. In mollis augue id turpis porttitor, vel auctor libero lobortis. Duis viverra blandit justo, id commodo nisi cursus et. Suspendisse potenti. Curabitur consequat orci vulputate ligula lacinia, vel vulputate purus commodo. Vestibulum rhoncus, sapien in bibendum ornare, elit nisi suscipit lacus, eget vulputate eros nibh vitae felis. Mauris sit amet condimentum dolor. Nunc venenatis, lacus vitae ultrices fermentum, libero ipsum rhoncus nisi, in lobortis enim massa nec lectus. Integer eu neque suscipit, consequat mauris nec, consectetur dui.',
			"page_title_cs" => "ATK14 Eshop",
		]);

		Page::CreateNewRecord([
			"code" => "terms_and_conditions",
			"title_en" => "Terms and Conditions",
			"title_cs" => "Obchodní podmínky",
		]);
	}
}
