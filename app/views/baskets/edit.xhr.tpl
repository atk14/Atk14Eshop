$( "#js--edit_form_content" ).replaceWith( {jstring}{render partial="edit_form_content"}{/jstring} );
$( "#js--basket_price_summarization td" ).fadeOut( 0 ).fadeIn( 100 );
$( ".js--basket_info" ).replaceWith( {jstring}{render partial="shared/layout/header/basket_info"}{/jstring} );
$(".js--basket_info_float").replaceWith({jstring}{render partial="shared/basket_info_float"}{/jstring});
