console.log( "hello me" );
window.UTILS = window.UTILS || { };

window.UTILS.AsyncImageUploader = class {
  element = null;
  constructor( element ) {
    this.element = element;
  }
  static init() {
    console.log( "hi static" );
    var test = new window.UTILS.AsyncImageUploader( "me" );
    console.log( "test", test );
    var elems = document.querySelectorAll( ".js--xhr_upload_image_form" );
  }
};

//window.UTILS.AsyncImageUploader.init();