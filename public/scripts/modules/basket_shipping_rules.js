export default function checkDependent( options ) {

	var $ = window.jQuery;

	var $determinants = $( "input[name='" + options.determinantName + "']" ),
	$determined = $( "input[name='" + options.determinedName + "']" ),
	$determinedRadio = $determined.closest( ".list__item" );

	$determinants.each( function() {
		var $input = $( this ),
		rule = options.rules[ $input.val() ];

		if ( !rule ) {
			return;
		}

		$input.on( "click", function() {
			var enabled = 0;

			$determined.prop( "disabled", true );
			$determinedRadio.addClass( "list__item--disabled" );

			$.each( rule, function( i, val ) {
				var value = val.toString();

				$determined
					.filter( "[value='" + value + "']" ).prop( "disabled", false )
					.closest( ".list__item" ).removeClass( "list__item--disabled" );
			} );

			enabled = $determined.filter( ":enabled" ).length;

			if ( options.checkFirstEnabled || enabled === 1 ) {
				$determined.filter( ":enabled:first" ).prop( "checked", true );
			}
		} );
	} );

	$determinants.filter( ":checked" ).click();
};
