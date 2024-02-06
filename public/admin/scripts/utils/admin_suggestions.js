/* AdminSuggestions class
 * handles adim autocomplete for tags, categories and general inputs
 * Usage:
 * window.UTILS.AdminSuggestions.handleSuggestions();
 * 
 * Dependencies: autocompleter https://github.com/kraaden/autocomplete
 */ 

window.UTILS = window.UTILS || { };

window.UTILS.AdminSuggestions = class {

  // Suggests anything according by an url
  static handleSuggestions() {
    let inputs = document.querySelectorAll( "[data-suggesting='yes']" );
    console.log("inputs",inputs);
    [...inputs].forEach( function( input ){

      let url = input.dataset.suggesting_url;
                
      // eslint-disable-next-line no-undef
      autocomplete( {
        // see https://github.com/kraaden/autocomplete
        input: input,
        fetch: async function( text, update ) {
          text = text.toLowerCase();
          try {
            let response = await fetch( url + "&q=" + text );
            let result = await response.json()
            update( result );
          } catch ( error ) {
            console.log( "Error fetching suggestions:", error );
          };
        },
        render: function( item ) {
          var div = document.createElement( "div" );
          div.textContent = item;
          return div;
        },
        onSelect: function( item, input ) {
            input.value = item;
        },
        preventSubmit: 2,
        disableAutoSelect: true,
        debounceWaitMs: 100,
      } );
    } );
  }

};