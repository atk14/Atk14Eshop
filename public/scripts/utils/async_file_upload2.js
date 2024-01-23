window.UTILS = window.UTILS || { };

window.UTILS.async_file_upload = { };

window.UTILS.async_file_upload.init = function() {

  var inputs = document.querySelectorAll( ".js--async-file" ),
      lang = $( "html" ).attr( "lang" ),
      url = "/api/" + lang + "/temporary_file_uploads/create_new/?format=json";

  var onInputChange = function( e ) {
    console.log( "CHANGE" );
    console.log( e.target.value );
    console.log( e.target.files );
    startUpload( e.target.files );
  };

  var onFilesDrop = function( e ) {
    e.preventDefault();
    console.log( "DROP" );
    let dt = e.dataTransfer
    let files = dt.files
    e.target.closest( "div" ).querySelector( "input" ).files = files;

    //handleFiles(files)
    console.log(files);
    startUpload( files );
  };

  var updateProgress = function( progress ){
    console.log( "progress", progress );
  }

  var startUpload = function( files ) {
    console.log( "--******START*****************--" );
    
    let formData = new FormData()

    formData.append('file', files[0]);

    /*fetch(url, {
      method: 'POST',
      body: formData
    })
    .then(( r ) => { 
      console.log( "UPLOADED", r );
     })
    .catch(( error ) => { 
      console.log( "ERROR", error );
     });*/
    
    var xhr = new XMLHttpRequest();
    xhr.open( "POST", url, true );

    // Add following event listener
    xhr.upload.addEventListener("progress", function (e) {
      updateProgress( (e.loaded * 100.0 / e.total) || 100 );
    })

    xhr.addEventListener('readystatechange', function (e) {
          if (xhr.readyState == 4 && (xhr.status == 201 || xhr.status == 200)) {
            console.log( "DONE" );
            console.log( xhr.response );
          } else if (xhr.readyState == 4 && xhr.status != 200 && xhr.status != 201) {
            console.log( "ERROR" );
            console.log( xhr.response );
          }
     })
   
    xhr.send(formData)
  };

  var highlight = function( e ) {
    e.target.style.backgroundColor = "yellow";
  };

  var unhighlight = function( e ) {
    e.target.style.backgroundColor = "transparent";
  };


  

  [...inputs].forEach(function( el ){
    console.log( "div", el );
    el.style.border = "2px dotted gray";
    el.style.padding = "40px 0";
    var input = el.querySelector( "input" );
    console.log( "input", input );
    input.setAttribute( "multiple", "");

    ;["dragenter", "dragover"].forEach(eventName => {
      el.addEventListener(eventName, highlight, false)
    })
    
    ;["dragleave", "drop"].forEach(eventName => {
      el.addEventListener(eventName, unhighlight, false)
    })

    el.addEventListener( "drop", onFilesDrop );
    input.addEventListener( "change", onInputChange );
  } );
};