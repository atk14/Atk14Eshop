var $new_link = $({jstring}{render partial="shared/favourite_product_icon" product=$product product_just_added=1}{/jstring});

$link.tooltip("hide");
$link.replaceWith($new_link);
$new_link.tooltip( {
	trigger: "manual",
	html: true
} );
$new_link.tooltip("show");
setTimeout(function(){ $new_link.tooltip("hide"); }, 2000);
