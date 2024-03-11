/**
 * Class to watch custom numeric stepper buttons ( [data-spinner-button] ) clicks
 * Updates associated input value and fires "change" event on that input
 * 
 * 
 * Usage: 
 * new window.UTILS.numericStepperHandler();
 * 
 */

window.UTILS = window.UTILS || { };


window.UTILS.numericStepperHandler = class {

  constructor() {
    /**
     * Watching click event on body to capture clicks on steppers inserted to DOM after ajax calls
     */
    document.querySelector( "body" ).addEventListener( "click", ( e ) => {
      if( e.target.hasAttribute( "data-spinner-button" ) ) {
        e.preventDefault();
        this.onClick( e.target );
      }
    } );
  }

  onClick( btn ) {
    // direction ( "up"|"down" )
    let dir = btn.getAttribute( "data-spinner-button" );
    // parent stepper element
    let qtyWidget = btn.closest( ".js-stepper" );
    // input field
    let qtyInput = qtyWidget.querySelector( ".js-order-quantity-input" );
    // min, max, step values
    let qtyMin = parseFloat( qtyInput.getAttribute( "min" ) );
    let qtyMax = parseFloat( qtyInput.getAttribute( "max" ) );
    let qtyStep = parseFloat( qtyInput.getAttribute( "step" ) );
    // current value
    let oldValue = parseFloat( qtyInput.value );
    // new value
    let newValue;

    // calculate new value
    if( dir === "up" ) {
      newValue = Math.min( qtyMax, oldValue + qtyStep );
    } else {
      newValue = Math.max( qtyMin, oldValue - qtyStep );
    }

    // update input value
    qtyInput.value = newValue;
    
    // fire "change" event on input
    qtyInput.dispatchEvent( new Event( "change" ) );
  }
};
