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
