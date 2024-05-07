window.UTILS = window.UTILS || { };

/**
 * 
 * 
 * try to paste:
 * 50.5549050N, 13.9310911E
 * 50.5549050, 13.9310911
 * 50.5549050N
 * 
 */
window.UTILS.geoPaste = class {
  inputFieldLat;
  inputFieldLng;

  constructor() {  
    if( !document.querySelector( "#id_location_lat" ) || !document.querySelector( "#id_location_lng" ) ) {
      return;
    }
    this.inputFieldLat = document.querySelector( "#id_location_lat" );
    this.inputFieldLng = document.querySelector( "#id_location_lng" );
    
    [ this.inputFieldLat, this.inputFieldLng ].forEach( function( el ){ el.addEventListener( "paste", this.onPaste.bind( this ) ) }.bind( this ) );
  }

  onPaste( e ) {
    e.preventDefault();
    let pastedInput = ( e.clipboardData || window.clipboardData ).getData("text");
    let parsedInput = this.#parseString( pastedInput );
    if( typeof( parsedInput ) === "object" ) {
      // contains two values - put values into their fields
      this.inputFieldLat.value = parsedInput.lat;
      this.inputFieldLng.value = parsedInput.lng
    } else {
      // single value - put it where it was pasted
      e.target.value = parsedInput;
    }
  }

  // parses pasted string
  #parseString( input ) {
    let returnValue;
    // remove spaces
    let strippedInput = input.replaceAll( " ", "");
    // split to array by comma
    let arr = strippedInput.split( "," );
    // does contain N, S, E, W?
    if ( arr.length === 2 ) {
      // input contains two values
      returnValue = { lat: this.#replaceNSEW( arr[ 0 ] ), lng: this.#replaceNSEW( arr[ 1 ] ) };
    } else if ( arr.length === 1 ){
      // input contains just one value  
      returnValue = this.#replaceNSEW( arr[ 0 ] );
      // if parsed value is not number return original input 
      if( isNaN( returnValue ) ) {
        returnValue = input;
      }
    } else {
      // something bad
      returnValue = input;
    }
    return returnValue;
  }

  // parses single value
  #replaceNSEW( input ) {
    let coef = 1;
    if( input.includes( "W" ) || input.includes( "S" ) ) {
      coef = -1;
    }
    let output = parseFloat( input ) * coef;
    return output;
  }

};