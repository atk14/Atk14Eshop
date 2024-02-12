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
  fileSize;
  fileName;
  start = 0;
  chunkCounter = 0;

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
    this.file = files[0];
    this.fileSize = this.file.size;
    this.fileName = this.file.name;

    /*while ( this.start < file.size) {
      //let range = "bytes " + this.start + "-" + ( this.start + this.chunkSize ) + "/" + file.size; 
      this.uploadChunk(file.slice( this.start, this.start + this.chunkSize ), this.start, this.start + this.chunkSize );
      //console.log( "Range", this.start, this.start + this.chunkSize );
      this.start += this.chunkSize;
    }*/

    /*let slices = [];
    let total = 0;
    while ( this.start < file.size) {
      let blob = file.slice( this.start, this.start + this.chunkSize );
      slices.push( {
        blob: blob,
        start: this.start,
        end: this.start + this.chunkSize
      } );
      this.start += this.chunkSize;
      total = this.start;
    }

    console.log( "fsize", file.size );
    console.log( "total", total );
    console.log( "slices", slices );

    slices.forEach( ( slice )=>{
      this.uploadChunk( slice.blob, slice.start, slice.end, total )
    } );*/


    /////////////////////////////////// https://api.video/blog/tutorials/uploading-large-files-with-javascript/


    let numberofChunks = Math.ceil( this.file.size / this.chunkSize );

    for( let i = 0; i < numberofChunks; i ++ ) {
      let start = this.chunkSize * i;
      let end = Math.min( start + this.chunkSize , this.file.size );
      let chunk = this.file.slice( start, end );
      this.uploadChunk( chunk, start, end );
    }
    /*
    let formData = new FormData();
    formData.append( "file", files[0] );
    
    let xhr = new XMLHttpRequest();
    xhr.open( "POST", this.url, true );

    xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );
    xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this) );
    
    this.removeUIHandlers();    
    this.element.innerHTML = this.element.dataset.template_loading;

    xhr.send( formData );*/
  }

  /*createChunk( start, end ) {
    chunkCounter++;
		console.log("created chunk: ", chunkCounter);
    chunkEnd = Math.min(start + chunkSize , file.size );
		const chunk = file.slice( start, chunkEnd );

    if( chunkEnd < this.file.size ) {
      this.createChunk
    }
  }*/

  uploadChunk( chunk, start, end ) {
    console.log( "Upload chunk", chunk );
    
    // https://accreditly.io/articles/uploading-large-files-with-chunking-in-javascript
    /*const formData = new FormData();
    formData.append( "file", chunk );*/

    let range = "bytes " + start + "-" + end + "/" + this.file.size;
    console.log( "Range", range ); 

    // Make a request to the server
    /*fetch( this.url, {
      method: 'POST',
      body: formData,
      headers: {
        "Content-Range": range
      }
    });*/
    let xhr = new XMLHttpRequest();
    // Add xhr to uploads list

    // Setup xhr request
    xhr.open( "POST", this.url, true );
    xhr.responseType = "json";
    //xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );
    //xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this ) );
    //xhr.setRequestHeader( "Content-Type", file.type );
    xhr.setRequestHeader( "Content-Range", range );
    xhr.setRequestHeader( "Accept", "application/json, text/javascript, text/plain, */*" );
    xhr.setRequestHeader( "Content-Disposition", "attachment; filename=" + encodeURIComponent( this.fileName ) );
    xhr.setRequestHeader( "X-Requested-With", "XMLHttpRequest" );
    
    xhr.send(chunk);
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
