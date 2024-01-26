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

  onFilesSelect( e ) {
    console.log( "selected filees" );
    this.startUpload( this.input.files );
  }

  startUpload( files ) {
    console.log( "Start upload" );
    [...files].forEach(function( file ){
      console.log( file );
    } );
    // Upload goes here...
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