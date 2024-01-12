<?php
class SampleSliderMigration extends ApplicationMigration {

	function up(){
		// Slider on homepage
		$slider = Slider::CreateNewRecord(array(
			"code" => "homepage",
			"name" => "Homepage"
		));
		SliderItem::CreateNewRecord(array(
			"slider_id" => $slider,
			"image_url" => "http://i.pupiq.net/i/65/65/2a2/292a2/1920x540/tckDHp_800x225_b1df7659b264d1cc.jpg",
			"title_en" => "Lorem ipsum",
			"description_en" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
			"title_cs" => "Lorem ipsum",
			"description_cs" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
			"url" => $this->_link_to_page("about_us"),
		));
		SliderItem::CreateNewRecord(array(
			"slider_id" => $slider,
			"image_url" => "http://i.pupiq.net/i/65/65/2a3/292a3/1920x540/l24vUy_800x225_5559ff585698c82f.jpg",
			"title_en" => "Lorem ipsum",
			"description_en" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
			"title_cs" => "Lorem ipsum",
			"description_cs" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
			"url" => $this->_link_to_category("catalog"),
		));
		SliderItem::CreateNewRecord(array(
			"slider_id" => $slider,
			"image_url" => "http://i.pupiq.net/i/65/65/2a4/292a4/1920x540/qkWiHB_800x225_936547d285be0d0c.jpg",
			"title_en" => "Lorem ipsum",
			"description_en" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
			"title_cs" => "Lorem ipsum",
			"description_cs" => "Dolor sit amet, consectetur adipiscing elit. Quisque odio neque, convallis sed sollicitudin in, egestas non tortor.",
		));
	}
}
