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
  chunkSize = 1024 * 1024;
  file;
  start;
  bytesLoaded;
  chunkedUpload;

  constructor( element ) {
    this.element = element;
    this.url = "/api/" + this.lang + "/temporary_file_uploads/create_new/?format=json";

    // Setup UI handlers according to element initial state
    if ( element.querySelector( "input[type='file']" ) ){
      // Default state (input visible)
      this.input = element.querySelector( "input[type='file']" );
      this.addUIhandlers();
    } else if ( element.querySelector( ".js--remove" ) ) {
      // File upladed state (remove file button visible)
      this.element.querySelector( ".js--remove" ).addEventListener( "click", this.removeButtonHandler.bind( this ) );
    } else if ( element.querySelector( ".js--confirm" ) ) {
      // Error state
      this.element.querySelector( ".js--confirm" ).addEventListener( "click",  this.confirmButtonHandler.bind( this ) );
    }
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
    this.file = files[0];

    if( this.file.size > 1024 * 1024 * 2 ){
      // chunked upload
      this.chunkedUpload = true;
      this.start = 0;
      this.bytesLoaded = 0;
      // create the first chunk
      this.createChunk( this.start );

    } else {
      // classic upload for smaler files
      this.chunkedUpload = false;
      let formData = new FormData();
      formData.append( "file", files[0] );
      
      let xhr = new XMLHttpRequest();
      xhr.open( "POST", this.url, true );
      xhr.responseType = "json";

      xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );
      xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this) );
      
      xhr.send( formData );
    }

    this.removeUIHandlers();    
    this.element.innerHTML = this.element.dataset.template_loading;

  }

  
  // Prepares chunk to upload
  createChunk( start ) {
    // https://api.video/blog/tutorials/uploading-large-files-with-javascript/
    // https://accreditly.io/articles/uploading-large-files-with-chunking-in-javascript
    let end = Math.min( start + this.chunkSize , this.file.size );
    let chunk = this.file.slice( start, end );
    this.uploadChunk( chunk, start, end );
  }

  // Uploads chunk
  uploadChunk( chunk, start, end ) {
    // build Content-Range header for XHR request 
    let range = "bytes " + start + "-" + ( end - 1 ) + "/" + this.file.size;
    //console.log( "Range", range ); 

    // Setup xhr request
    let xhr = new XMLHttpRequest();
    xhr.open( "POST", this.url, true );
    xhr.responseType = "json";
    xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );
    xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this ) );
    xhr.setRequestHeader( "Content-Range", range );
    xhr.setRequestHeader( "Content-Type", this.file.type );
    xhr.setRequestHeader( "Accept", "application/json, text/javascript, text/plain, */*" );
    xhr.setRequestHeader( "Content-Disposition", "attachment; filename=" + "\"" + encodeURIComponent( this.file.name ) + "\"" );
    xhr.setRequestHeader( "X-Requested-With", "XMLHttpRequest" );
    
    xhr.send( chunk );
  }

  // Updates progressbar
  onUploadProgress( e ) {
    var progress;
    if( this.chunkedUpload ) {
      progress = ( ( this.bytesLoaded + e.loaded ) * 100 / this.file.size );
    } else {
      progress = ( e.loaded * 100.0 / e.total ) || 100;
    }
    //console.log( e.loaded, e.total, progress );
    if( this.element.querySelector( ".progress-bar" ) ){
      this.element.querySelector( ".progress-bar" ).style.width = progress + "%";
    }
  }

  // Upload status change
  onReadyStateChange( e ) {
    let xhr = e.target;
    if ( xhr.readyState === 4 && xhr.status >= 200 && xhr.status < 400 ) {

      if( this.chunkedUpload ) {
        // move start point for the next chunk
        this.start += this.chunkSize;
        //console.log( "Chunk starting at " + this.start + " uploaded" );
        if( this.start < this.file.size ) {
          // if this was not the last chunk create and start uploading the next chunk
          this.bytesLoaded += this.chunkSize;
          this.createChunk( this.start );

        } else {
          //console.log( "CHUNKED UPLOAD COMPLETE", xhr.response );
          this.onUploadSuccess( xhr.response );
        }

      } else {
        this.onUploadSuccess( xhr.response );
      }
    } else if( xhr.readyState === 4 ) {
      this.onUploadError( xhr.response );
    }
  }

  // Shows info about uploaded file
  onUploadSuccess( response ){
    let template = this.element.dataset.template_done;
    //response = JSON.parse( response );
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
    this.restoreInput();
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
    this.restoreInput();
  };

  // Restore UI to default state witn file input visible.
  restoreInput(){
    this.element.innerHTML = this.element.dataset.input;
    this.input = this.element.querySelector( "input[type='file']" );
    this.addUIhandlers();
  }

  escapeHtml( unsafe ) {
    return unsafe
      .replace( /&/g, "&amp;" )
      .replace( /</g, "&lt;" )
      .replace( />/g, "&gt;" )
      .replace( /"/g, "&quot;" )
      .replace( /'/g, "&#039;" );
  }

};
