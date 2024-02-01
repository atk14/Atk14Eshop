/*
 * Async file uploader
 * No dependencies.
 * Usage:
 * window.UTILS.async_file_upload.init();
*/
window.UTILS = window.UTILS || { };

window.UTILS.async_file_upload = class {
  static init() {
    let inputs = document.querySelectorAll( ".js--async-file" );
    [...inputs].forEach(function( el ){
      new window.UTILS.async_file_upload.Uploader( el );
    } );
  }
};

window.UTILS.async_file_upload.Uploader = class {
  element;
  lang = document.querySelector( "html" ).getAttribute( "lang" );
  url;
  input;

  constructor( element ) {
    this.element = element;
    this.input = element.querySelector( "input" );
    this.url = "/api/" + this.lang + "/temporary_file_uploads/create_new/?format=json";
    this.addUIhandlers();
  }

  // Files from drag + drop
  onFilesDrop( e ){
    e.preventDefault();
    let dt = e.dataTransfer;
    let files = dt.files;
    if( files.length > 1 ) {
      alert( "Only one file at time may be uploaded" );
      return;
    }
    // Copy files list into file input elem (unless files were dropped directly to input)
    if( !e.target.classList.contains( "form-control-file" ) ) {
      e.target.querySelector( "input" ).files = files;
    }
    this.startUpload( files );
  }

  // Files selected by file input
  onFilesSelect() {
    this.startUpload( this.input.files );
  }

  // Initiates upload
  startUpload( files ){
    if( !files ) {
      return;
    }
    let formData = new FormData();
    formData.append( "file", files[0] );
    
    let xhr = new XMLHttpRequest();
    xhr.open( "POST", this.url, true );

    xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );
    xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this) );
    
    this.removeUIHandlers();    
    this.element.innerHTML = this.element.dataset.template_loading;

    xhr.send( formData );
  }

  // Updates progressbar
  onUploadProgress( e ) {
    let progress = ( e.loaded * 100.0 / e.total ) || 100;
    this.element.querySelector( ".progress-bar" ).style.width = progress + "%";
  }

  // Upload status change
  onReadyStateChange( e ) {
    let xhr = e.target;
    if ( xhr.readyState === 4 && xhr.status >= 200 && xhr.status < 400 ) {
      this.onUploadSuccess( xhr.response );
    } else if( xhr.readyState === 4 ) {
      this.onUploadError( xhr.response );
    }
  }

  // Shows info about uploaded file
  onUploadSuccess( response ){
    let template = this.element.dataset.template_done;
    response = JSON.parse( response );
    template = template
      .replace( "%filename%", this.escapeHtml( response.filename ) )
      .replace( "%fileext%", this.escapeHtml( response.filename.split( "." ).pop().toLowerCase() ) )
      .replace( "%filesize_localized%", this.escapeHtml( response.filesize_localized ) )
      .replace( "%token%", this.escapeHtml( response.token ) )
      .replace( "%name%", this.escapeHtml( this.element.dataset.name ) )
      .replace( "%destroy_url%", this.escapeHtml( response.destroy_url ) );
    this.element.innerHTML = template;
    this.element.querySelector( ".js--remove" ).addEventListener( "click", this.removeButtonHandler.bind( this ) );
  }

  // Display error message
  onUploadError( response ) {
    let template = this.element.dataset.template_error;
    let errMsg = "Error occurred";
    response = JSON.parse( response );

    if( response && response[0] ) {
      errMsg = response[ 0 ];
    }
    template = template
      .replace( "%error_message%", this.escapeHtml( errMsg ) );

    this.element.innerHTML = template;
    this.element.querySelector( ".js--confirm" ).addEventListener( "click",  this.confirmButtonHandler.bind( this ) );
  }

  // Unhighlights dropzone
  highlight( e ) {
    e.preventDefault();
    this.element.classList.add( "droparea-highlight" );
  }

  // Unhighlights dropzone
  unhighlight() {
    this.element.classList.remove( "droparea-highlight" );
  };

  // Sets handlers for UI interactions - file select, drag + drop
  addUIhandlers() {
    ["dragenter", "dragover"].forEach( eventName => {
      this.element.addEventListener( eventName, this.highlight.bind( this ), false );
    } );    
    ["dragleave", "drop"].forEach( eventName => {
      this.element.addEventListener( eventName, this.unhighlight.bind( this ), false );
    } );
    this.element.addEventListener( "drop", this.onFilesDrop.bind( this ), false );
    this.input.addEventListener( "change", this.onFilesSelect.bind( this) );
  }

  // Removes handlers for UI interactions - file select, drag + drop
  removeUIHandlers() {
    ["dragenter", "dragover"].forEach( eventName => {
      this.element.removeEventListener( eventName, this.highlight.bind( this ), false );
    } );    
    ["dragleave", "drop"].forEach( eventName => {
      this.element.removeEventListener( eventName, this.unhighlight.bind( this ), false );
    } );
    this.element.removeEventListener( "drop", this.onFilesDrop.bind( this ), false );
    this.input.removeEventListener( "change", this.onFilesSelect.bind( this) );
  }

  // click on button displayed after error
  confirmButtonHandler() {
    this.element.querySelector( ".js--confirm" ).removeEventListener( "click",  this.confirmButtonHandler.bind( this ) );
    this.element.innerHTML = this.element.dataset.input;
    this.addUIhandlers();
  }

  // click on remove button
  async removeButtonHandler() {
    let url = this.element.querySelector( ".js--remove" ).dataset.destroy_url;

    // Workaround for proper function when testing with gulp serve
    if( window.location.href.includes( "http://localhost:3000" ) && url.includes( "http://localhost:8000" )) {
      url = url.replace( "localhost:8000", "localhost:3000" );
    }

    await fetch( url, { method: "POST" } );
    this.element.querySelector( ".js--remove" ).removeEventListener( "click", this.removeButtonHandler.bind( this ) );
    this.element.innerHTML = this.element.dataset.input;
    this.addUIhandlers();
  };

  escapeHtml( unsafe ) {
    return unsafe
      .replace( /&/g, "&amp;" )
      .replace( /</g, "&lt;" )
      .replace( />/g, "&gt;" )
      .replace( /"/g, "&quot;" )
      .replace( /'/g, "&#039;" );
  }

};
