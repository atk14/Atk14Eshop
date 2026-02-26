window.UTILS = window.UTILS || { };
/**
 * Class to enhance password fields with reveal button
 * It creates all necessary markup if it is not there yet.
 * 
 * Usage:
 * new PasswordReveal();
 * 
 * Useful method:
 * enhancePasswordField( passwordField:Node ) - enhances password field which was not added automatically
 * 
 */

window.UTILS.PasswordReveal = class {

  styles = [
   "input[data-reveal] ~ .js--password_reveal {border-left: none !important; color: rgba(77,77,77,0.5);min-width: unset !important; padding-left: 0.45rem !important; padding-right: 0.45rem !important;}",
   "input[data-reveal] {border-right: none !important;}",
  ];

  constructor() {
    this.init();
  }

  /**
   * Find all password fields
   */
  init() {
    let pwds = document.querySelectorAll( "input[type='password']:not([data-extended_password_field])" );
    //let pwds = document.querySelectorAll( "input[type='password'][data-reveal='true']:not[data-extended_password_field]" );
    [...pwds].forEach( this.enhancePasswordField.bind( this ) );
    if( pwds.length > 0 ) {
      const sheet = window.document.styleSheets[ window.document.styleSheets.length - 1 ];
      this.styles.forEach( css => {
        sheet.insertRule( css, sheet.cssRules.length );
      } );
    }
  }

  /**
   * Enhances single password field
   * @param {*} passwordField 
   * @returns 
   */
  enhancePasswordField( passwordField ) {
    let btn;

    if( passwordField.dataset.reveal ) {
      return;
    }
    //passwordField.style.backgroundColor = "rgba(255,255,0,0.12)";

    // Find parent of the password field
    let parent = passwordField.parentElement;

    if( !parent.querySelector( ".js--password_reveal" ) ){
      // Create markup if it is not there yet

      // Create .input-group wrapper for pw input and button
      let inputGroup = document.createElement( "div" );
      inputGroup.classList.add( "input-group" );

      // Create wrapper for button
      let btnWrap = document.createElement( "div" );
      btnWrap.classList.add( "input-group-append" );

      // Create button
      btn = document.createElement( "span" );
      btn.classList.add( "btn", "btn-link", "js--password_reveal" );
      let icon = document.createElement( "i" );
      icon.classList.add( "fa-solid", "fa-eye" );
      btn.append( icon );

      // Assemble it together
      btnWrap.append( btn );
      inputGroup.append( btn );

      // Insert it into DOM to the parent of pw field 
      parent.append( inputGroup );

      // Relocate pw input to .input-group
      inputGroup.prepend( passwordField );
    } else {
      btn = parent.querySelector( ".js--password_reveal" );
    }

    // Add handler
    btn.addEventListener( "click", this.toggleReveal );

    // Add data attribute to mark that password field is already processed
    passwordField.dataset.reveal = "true";

  }

  /**
   * Performs password reveal 
   * @param {*} e 
   */
  toggleReveal( e ) {
    let btn = e.currentTarget;
    let icon = btn.querySelector( "i" );
    let field = btn.closest( ".input-group" ).querySelector( "input[type='text'], input[type='password']" );
    if( field.getAttribute( "type" ) === "password" ) {
      field.setAttribute( "type", "text" );
      icon.classList.remove( "fa-eye" );
      icon.classList.add( "fa-eye-slash" );
    } else {
      field.setAttribute( "type", "password" );
      icon.classList.remove( "fa-eye-slash" );
      icon.classList.add( "fa-eye" );
    }
  }

};