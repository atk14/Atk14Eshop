{if $request->get()}

$("#card_customer_reviews_modal_id").remove();
$("#customer_review_creation_modal_id").remove();
$(".modal-backdrop").remove();

var $modal = $({jstring}{modal id=customer_review_creation_modal_id title=$modal_title}
	{render partial="product_info"}

	{render partial="shared/form_remote"}
{/modal}{/jstring});

$modal.appendTo("body");

$("#customer_review_creation_modal_id").modal("show");

{else}

$form.replaceWith( {jstring}{render partial="shared/form_remote"}{/jstring} );

{/if}

[...document.querySelectorAll( "#customer_review_creation_modal_id .form-group.form-group--id_rating" )].forEach( ( element ) => {
	if( !element.dataset.star_rating_widget ) {
		new window.UTILS.StarRatingWidget( element, true );
	}
} );

