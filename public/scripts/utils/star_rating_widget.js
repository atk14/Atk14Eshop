/**
 * Star Rating Widget
 * Replaces a numeric input with a star rating interface.
 * Requires an input of type number within the parent element.
 * Example usage:
 * new window.UTILS.StarRatingWidget( ".form-group.form-group--id_rating" );
 */

window.UTILS = window.UTILS || { };

window.UTILS.StarRatingWidget = class {
  input;
  parent;
  rating;
  starsContainer;
  ratingText;
  ratingStars;
  autosubmit = false;

  /**
   * 
   * @param {*} parent - The parent element containing the numeric input. Typically parent .form-group
   * @param {*} autosubmit - Optional, if true, click on stars will submit parent form 
   */
  constructor( parent, autosubmit ) {
    if ( parent.dataset.star_rating_widget ) {
      return;
    }
    this.autosubmit = autosubmit || false;
    this.parent = parent;
    this.input = parent.querySelector( "input[type=\"number\"]" );
    this.parent.dataset.star_rating_widget = true;
    this.createWidget();
    if( this.autosubmit ) {
      this.input.closest( "form" ).querySelector( "button[type='submit']" ).classList.add( "sr-only" );
    }
  }

  /**
   * Creates the star rating widget elements and appends them to the parent.
   * Adds event listeners for star clicks and input changes.
   */
  createWidget() {
    // Create main container
    this.starsContainer = document.createElement( "div" );
    this.starsContainer.classList.add( "starrating_widget" );
    this.parent.appendChild( this.starsContainer );

    // Create stars container
    this.ratingStars = document.createElement( "div" );
    this.ratingStars.classList.add( "starrating_widget__stars" );
    this.starsContainer.appendChild( this.ratingStars );

    // Create 5 stars
    for ( let i = 1; i <= 5; i++ ) {
      const star = document.createElement( "span" );
      star.classList.add( "starrating_widget__star" );
      star.dataset.value = i;

      let radio = document.createElement( "input" );
      radio.type = "radio";
      radio.name = "star";
      radio.value = i;
      radio.classList.add( "sr-only" );
      star.appendChild( radio );

      let label = document.createElement( "label" );
      label.innerHTML = "<span class=\"sr-only label__text\">" + i + "</span>";
      star.appendChild( label );

      this.ratingStars.appendChild( star );

      // Add click event listener
      star.addEventListener( "click", this.onclick.bind( this ) );
    }
    

    // Create rating text
    this.ratingText = document.createElement( "span" );
    this.ratingText.classList.add( "starrating_widget__text" );
    this.starsContainer.appendChild( this.ratingText );

    // Hide original input and add change listener
    this.input.setAttribute( "type", "hidden" );
    this.input.addEventListener( "change", this.onInputChange.bind( this ) );

    // Initialize rating from loaded input value
    this.updateRating( this.input.value );
    
  }

  /**
   * Handler for star click events.
   * @param {*} e 
   */
  onclick( e ){
    const value = e.currentTarget.dataset.value;
    this.updateRating( value );
    this.input.value = value;
    if( this.autosubmit ) {
      this.submitParentForm();
    }
  }

  /**
   * Updates the rating display and internal state.
   * @param {*} value - The new rating value.
   */
  updateRating( value ) {
    this.rating = value;
    [...this.ratingStars.querySelectorAll( ".starrating_widget__star" )].forEach( ( star ) => {
      if(star.dataset.value === value ) {
        star.dataset.checked = "true";
      } else {
        star.dataset.checked = "false";
      }
    } );
    this.ratingText.innerHTML = this.rating;
  }

  /**
   * Handler for input change events.
   */
  onInputChange() {
    const value = this.input.value;
    this.updateRating( value );
    if( this.autosubmit ) {
      this.submitParentForm();
    }
  }

  /**
   * Submits parent form
   */
  submitParentForm(){
    //this.input.closest( "form" ).submit();
    this.input.closest( "form" ).querySelector( "button[type='submit']" ).dispatchEvent( new MouseEvent( "click" ) );
  }
};
