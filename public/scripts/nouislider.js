function NoUISlider() {
}

NoUISlider.Init = function() {
	window.$( ".noui-slider" ).each(  function( i, e ) {
		NoUISlider.create( e ); }
	);
};

NoUISlider.formats = {
	number: {
				  to: function( value ) {
								return Math.ceil( value );
				  },
				  from: function( value ) {
								return value;
				  }
	},
	price: function( decimals, prefix, postfix ) {
					prefix = prefix || "";
					postfix = postfix || "";
					return {
					  to: function( value ) {
								return prefix + parseFloat( value ).toFixed( decimals ) + postfix;
					  },
					  from: function( value ) {
								if ( prefix ) { value = value.replace( prefix, "" ); }
								if ( postfix ) { value = value.replace( postfix, "" ); }
								return value;
					  }
					};
				}
};

NoUISlider.create = function( e ) {
	var $e = window.$( e );
	var data = $e.data( "noui-slider" );
	if ( !data ) { return ; }

	if ( data.format ) {
		data.format = NoUISlider.formats[ data.format ];
		if ( data.format_arguments ) {
			data.format = data.format.apply( null, data.format_arguments );
			delete data.format_arguments;
		}
	}

	var defaul = {
		connect: true,
		step: 1,
		tooltips: true,
		format: NoUISlider.formats.number
	};
	data = $e.data( "noui-slider" );
	window.$.extend( defaul, data );
	defaul.step = parseFloat( defaul.step );
	window.noUiSlider.create( e, defaul );
	$e.find( ".noui-slider-hide" ).hide();
	$e.removeData( "noui-slider" );

	e.noUiSlider.on( "change", function( values, handle ) {
		var role = handle ? "max" : "min" ;
		var $i = $e.find( "input.noui-slider-" + role );
		if ( data.range[ role ] === values[ handle ] && data.unbounded ) {
			$i.val( null );
		} else {
			$i.val( defaul.format.from(
					values[ handle ]
			) );
		}
		$i.trigger( "change" );
	} );
};

window.$(
		function() { NoUISlider.Init(); }
);
