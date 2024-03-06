// This is a place for some tools required in the application

window.UTILS = window.UTILS || { };

window.UTILS.rgba2hex = function( orig ) {
	var a,
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	alpha = (rgb && rgb[4] || "").trim(),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	if ( alpha !== "" ) {
		a = alpha;
	} else {
		a = 0o1;
	}
	// multiply before convert to HEX
	a = ( ( a * 255 ) | 1 << 8 ).toString( 16 ).slice( 1 );
	hex = hex + a;

	return hex;
};

window.UTILS.rgb2hex = function( orig ) {
	var
	rgb = orig.replace(/\s/g, "").match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
	hex = rgb ?
	( rgb[ 1 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 2 ] | 1 << 8 ).toString( 16 ).slice( 1 ) +
	( rgb[ 3 ] | 1 << 8 ).toString( 16 ).slice( 1 ) : orig;

	return hex;
};

// Form hints.
window.UTILS.formHints = function() {
	$( ".help-hint" ).each( function() {
		var $this = $( this ),
			$field = $this.closest( ".form-group" ).find( ".form-control" ),
			title = $this.data( "title" ) || "",
			content = $this.html(),
			popoverOptions = {
				html: true,
				trigger: "focus",
				title: title,
				content: content
			};

		$field.popover( popoverOptions );
	} );
}

// Check whether login is available.
window.UTILS.loginAvaliabilityChecker = function() {
	/*
	 * Check whether login is available.
	 * Simple demo of working with an API.
	 */
	var $login = $( "#id_login" ),
	m = "Username is already taken.",
	h = "<p class='alert alert-danger'>" + m + "</p>",
	$status = $( h ).hide().appendTo( $login.closest( ".form-group" ) );

	$login.on( "change", function() {

		// Login input value to check.
		var value = $login.val(),
			lang = $( "html" ).attr( "lang" ),

		// API URL.
			url = "/api/" + lang + "/login_availabilities/detail/",

		// GET values for API. Available formats: xml, json, yaml, jsonp.
			data = {
				login: value,
				format: "json"
			};

		// AJAX request to the API.
		if ( value !== "" ) {
			$.ajax( {
				dataType: "json",
				url: url,
				data: data,
				success: function( json ) {
					if ( json.status !== "available" ) {
						$status.fadeIn();
					} else {
						$status.fadeOut();
					}
				}
			} );
		}
	} ).change();
}

// Restores email addresses misted by the no_spam helper
window.UTILS.unobfuscateEmails = function() {
	$( ".atk14_no_spam" ).unobfuscate( {
		atstring: "[at-sign]",
		dotstring: "[dot-sign]"
	} );
}

// Links with the "blank" class are pointing to new window
window.UTILS.linksTargetBlank = function() {
	$( "a.blank" ).attr( "target", "_blank" );
}