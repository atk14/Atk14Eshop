/* AdminSuggestions class
 * handles adim autocomplete for tags, categories and general inputs
 * Usage:
 * 
 * General suggestions:
 * window.UTILS.AdminSuggestions.handleSuggestions();
 * 
 * Tag suggestions:
 * window.UTILS.AdminSuggestions.handleTagsSuggestions();
 * 
 * Category suggestions:
 * 
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
            let result = await response.json();
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

  // Suggests tags
  static handleTagsSuggestions() {
    let inputs = document.querySelectorAll( "[data-tags_suggesting='yes']" );
    let lang = document.querySelector( "html" ).getAttribute( "lang" );
    let url = "/api/" + lang + "/tags_suggestions/?format=json&q=";
    let cache = {};
    let term;
    let terms;
    [...inputs].forEach( ( input )=>{
      console.log( input );
      console.log( url );
      input.setAttribute( "autocomplete", "off" );

      autocomplete( {
        input: input,
        fetch: async function( text, update ) {
          term = this.extractLast( text.toLowerCase() );
          if ( term.length > 0 ) {
            if ( term in cache ) {
              update( cache[ term ] );
            } else {
              try {
                let response = await fetch( url + "&q=" + term );
                let result = await response.json();
                cache[ term ] = result;
                update( result );
              } catch ( error ) {
                console.log( "Error fetching suggestions:", error );
              };
            }
          }
        }.bind( this ),
        render: function( item ) {
          var div = document.createElement( "div" );
          div.textContent = item;
          return div;
        },
        onSelect: function( item, input ) {
          terms = this.split( input.value );
          terms.pop(); 
          terms.push( item );
          terms.push( "" );
          input.value = terms.join( ", " );
      }.bind( this ),
      preventSubmit: 2,
      disableAutoSelect: true,
      debounceWaitMs: 100,
      minLength: 1,
      } );
    } );
  }

  static split( val ) {
    return val.split( /,\s*/ );
  }
  static extractLast( t ) {
    return this.split( t ).pop();
  }

};