console.log( "hello me" );
window.UTILS = window.UTILS || { };

window.UTILS.AsyncImageUploader = class {
  form;
	wrap;
	dropZone;
  url;
	progress;
	list;
	input;
  uploads = [];

  /*fileUpload = class {
    xhr;
    file;

    constructor( file ) {
      console.log( "consctruct fileUPpload", file.name );
      this.file = file;
    }
  }*/

  constructor( form ) {
    this.form = form;
    this.dropZone = this.form.closest( ".drop-zone" );
    this.wrap = this.form.closest( ".js--image_gallery_wrap" );
    this.url = this.form.getAttribute( "action" );
    this.progress = this.wrap.querySelector( ".progress-bar" );
    this.list = this.wrap.querySelector( ".list-group-images" );
    this.input = this.form.querySelector( "input" );
    this.input.dataset.url = this.url;
    console.log( "dropZone", this.dropZone );
    console.log( "form", this.form );
    this.addUIhandlers();
  }

  addUIhandlers() {
    ;["dragenter", "dragover"].forEach( eventName => {
      this.dropZone.addEventListener( eventName, this.highlight.bind( this ), false );
    } );
    
    ;["dragleave", "drop"].forEach( eventName => {
      this.dropZone.addEventListener( eventName, this.unhighlight.bind( this ), false );
    } );

    this.dropZone.addEventListener( "drop", this.onFilesDrop.bind( this ), false );

    this.input.addEventListener( "change", this.onFilesSelect.bind( this) );
  }

  onFilesDrop( e ){
    e.preventDefault();
    console.log( "dropped filees" );
    let dt = e.dataTransfer;
    let files = dt.files;
    this.startUpload( files );
  }

  onFilesSelect() {
    console.log( "selected filees" );
    this.startUpload( this.input.files );
  }

  startUpload( files ) {
    console.log( "Start upload" );
    [...files].forEach( this.uploadFile.bind( this ) );
    /*[...files].forEach(function( file ){
      console.log( file );
      this.uploadFile( file )
    } );*/
    // Upload goes here...
    console.log( "uploads", this.uploads );
  }

  uploadFile( file ) {
    console.log( "UPLOAD ME", file );
    //this.uploads.push( new this.fileUpload( file, this ) );
    let formData = new FormData();
    formData.append( "file", file, file.name );
    let xhr = new XMLHttpRequest();
    this.uploads.push( xhr );
    //xhr.test = "ahoj" + file.name;
    xhr.open( "POST", this.url, true );
    xhr.responseType = "json";
    xhr.upload.addEventListener( "progress", function ( e ) {
      //$this.updateProgress( (e.loaded * 100.0 / e.total) || 100 );
      console.log( "progress", (e.loaded * 100.0 / e.total) || 100 );
    } );

    xhr.addEventListener( "readystatechange", function () {
      if ( xhr.readyState === 4 && xhr.status >= 200 && xhr.status < 400 ) {
        //$this.onSuccess( xhr.response );
        console.log( "complate" );
      } else if( xhr.readyState === 4 ) {
        //$this.onError( xhr.response );
        console.log( "error" );
      }
    } );
    console.log("XHR", xhr)
    //xhr.send( formData );
    //xhr.setRequestHeader('X-File-Name', file.name);
    //xhr.setRequestHeader('X-File-Size', file.size);
    xhr.setRequestHeader( 'Content-Type', file.type);
    xhr.setRequestHeader( 'Accept', 'application/json, text/javascript, text/plain, */*' );
    xhr.setRequestHeader( 'Content-Disposition', 'attachment; filename=' + encodeURIComponent( file.name ) );
    xhr.setRequestHeader( 'X-Requested-With', 'XMLHttpRequest' );
    
    xhr.send(file);
  }

  highlight( e ) {
    e.preventDefault();
    this.dropZone.classList.add( "drop-zone-highlight" );
  }

  unhighlight() {
    this.dropZone.classList.remove( "drop-zone-highlight" );
  }

  static init() {
    let elems = document.querySelectorAll( ".js--xhr_upload_image_form" );
    console.log( "AsyncImageUploader.init", elems.length );
    [...elems].forEach(function( el ){
      new window.UTILS.AsyncImageUploader( el );
    } );
  }
};