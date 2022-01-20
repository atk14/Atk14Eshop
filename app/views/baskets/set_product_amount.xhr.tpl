$link.parent("p").hide().html({jstring}{!"check"|icon} {t amount=$amount unit=$product->getUnit()}Množství bylo upraveno na %1 %2{/t}{/jstring}).fadeIn("fast");

$(".js--basket_info").replaceWith({jstring}{render partial="shared/layout/header/basket_info"}{/jstring});
$(".js--basket_info_float").replaceWith({jstring}{render partial="shared/basket_info_float"}{/jstring});
