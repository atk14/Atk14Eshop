$form.replaceWith( {jstring}{render partial="shared/form_remote"}{/jstring} );
[...document.querySelectorAll( "#customer_review_creation_modal_id .form-group.form-group--id_rating" )].forEach( ( element ) => {
	if( !element.dataset.star_rating_widget ) {
		new window.UTILS.StarRatingWidget( element );
	}
} );
