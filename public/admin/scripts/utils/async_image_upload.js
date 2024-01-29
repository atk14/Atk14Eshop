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

    let xhr = new XMLHttpRequest();
    this.uploads.push( xhr );
    //xhr.test = "ahoj" + file.name;
    xhr.open( "POST", this.url, true );
    xhr.responseType = "json";

    xhr.upload.addEventListener( "progress", this.onUploadProgress.bind( this ) );

    xhr.addEventListener( "readystatechange", this.onReadyStateChange.bind( this ) );
    
    console.log("XHR", xhr)
    
    xhr.setRequestHeader( 'Content-Type', file.type);
    xhr.setRequestHeader( 'Accept', 'application/json, text/javascript, text/plain, */*' );
    xhr.setRequestHeader( 'Content-Disposition', 'attachment; filename=' + encodeURIComponent( file.name ) );
    xhr.setRequestHeader( 'X-Requested-With', 'XMLHttpRequest' );
    
    xhr.send(file);
  }

  onUploadProgress( e ) {
    let loaded = 0;
    let total = 0;
    e.target.bytesLoaded = e.loaded;
    e.target.bytesTotal = e.total;
    for( let i = 0; i < this.uploads.length; i++) {
      loaded += this.uploads[ i ].upload.bytesLoaded;
      total += this.uploads[ i ].upload.bytesTotal;
    }
    this.progress.style.width = loaded * 100 / total + "%";
  }

  onReadyStateChange( e ) {
    if ( e.target.readyState === 4 && e.target.status >= 200 && e.target.status < 400 ) {
      //$this.onSuccess( xhr.response );
      console.log( "complate" );
      console.log( e.target.response.image_gallery_item );
      console.log( e.target );
      let glyph = "<span class='fas fa-grip-vertical text-secondary handle pr-3' " +
      " title='sorting'></span>";
     // let h = new DOMParser().parseFromString( e.target.response.image_gallery_item, "text/html" );
      this.list.insertAdjacentHTML( "beforeend", e.target.response.image_gallery_item );
      //this.list.append( e.target.response.image_gallery_item );
      this.checkComplete();
    } else if( e.target.readyState === 4 ) {
      //$this.onError( xhr.response );
      console.log( "error" );
    }
  }

  checkComplete() {
    console.log( "-------------------");
    let completedUploads = 0;
    for( let i = 0; i < this.uploads.length; i++) {
      console.log(this.uploads[i].readyState, this.uploads[i].status );
      if( this.uploads[i].readyState === 4 && this.uploads[i].status >= 200 && this.uploads[i].status < 400 ) {
        completedUploads ++;
      }
    }
    console.log( "-------------------", completedUploads );
    if( this.uploads.length === completedUploads ) {
      this.progress.style.width = "0%";
      this.uploads = [];
    }
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