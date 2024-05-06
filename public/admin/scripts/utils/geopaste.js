window.UTILS = window.UTILS || { };
window.UTILS.geoPaste = class {
  constructor() {
    console.log( "haeelo new window.UTILS.geoCoordsPaste" );
    let input = "50.5549050N, 13.9310911E";
    //console.log( "res" );
    //this.parseDMS( "50°33'17.658\"N, 13°55'51.928\"E" );
    //this.parseDMS( "N 50°33.29430', E 13°55.86547'" );

    this.parseString( "50.554729917525506, 13.93192297176293" );
    this.parseString( "-50.554729917525506, -13.93192297176293" );
    this.parseString( "50.5549050N, 13.9310911E" );
    this.parseString( "50.5549050S, 13.9310911E" );
    this.parseString( "50.5549050N, 13.9310911W" );
    this.parseString( "50.5549050N" );
    this.parseString( "prd" );

  }

  // parses pasted string
  parseString( input ) {
    // remove spaces
    input = input.replaceAll( " ", "");
    // split to array by comma
    let arr = input.split( "," );
    // does contain N, S, E, W?
    console.log( "input", input );
    console.log( "input", arr );
    if ( arr.length === 2 ) {
      // input contains two values
      console.log( "lat", this.replaceNSEW( arr[ 0 ] ) );
      console.log( "lng", this.replaceNSEW( arr[ 1 ] ) );
    } else if ( arr.length === 1 ){
      // input contains just one value
      console.log( "single value", this.replaceNSEW( arr[ 0 ] ) );
    } else {
      // something bad
      console.log( "BAD INPUT" );
    }
  }

  // parses single value
  replaceNSEW( input ) {
    let coef = 1;
    if( input.includes( "W" ) || input.includes( "S" ) ) {
      coef = -1;
    }
    let output = parseFloat( input ) * coef;
    console.log( "type", typeof( output ) );
    return output;
  }

};