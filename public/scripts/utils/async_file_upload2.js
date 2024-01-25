window.UTILS = window.UTILS || { };

window.UTILS.async_file_upload = { };

window.UTILS.async_file_upload.init = function() {

  var inputs = document.querySelectorAll( ".js--async-file" ),
      lang = $( "html" ).attr( "lang" ),
      url = "/api/" + lang + "/temporary_file_uploads/create_new/?format=json";

  // Uploader class
  var Uploader = function( element ) {
    this.element = element;
    var $this = this;

    this.onInputChange = function( e ) {
      $this.startUpload( e.target.files );
    };

    this.onFilesDrop = function( e ) {
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
      $this.startUpload( files );
    };

    // upload to server
    this.startUpload = function( files ) {
      let formData = new FormData();

      formData.append( "file", files[0] );
      
      var xhr = new XMLHttpRequest();
      xhr.open( "POST", url, true );

      xhr.upload.addEventListener( "progress", function ( e ) {
        $this.updateProgress( (e.loaded * 100.0 / e.total) || 100 );
      } );

      xhr.addEventListener( "readystatechange", function () {
        if ( xhr.readyState === 4 && xhr.status >= 200 && xhr.status < 400 ) {
          $this.onSuccess( xhr.response );
        } else if( xhr.readyState === 4 ) {
          $this.onError( xhr.response );
        }
      } );
      
      $this.removeUIHandlers();
      
      $this.element.innerHTML = $this.element.dataset.template_loading;

      xhr.send( formData );
    };

    this.onSuccess = function( response ) {
      let template = $this.element.dataset.template_done;
      response = JSON.parse( response );
      template = template
        .replace( "%filename%", $this.escapeHtml( response.filename ) )
				.replace( "%fileext%", $this.escapeHtml( response.filename.split( "." ).pop().toLowerCase() ) )
				.replace( "%filesize_localized%", $this.escapeHtml( response.filesize_localized ) )
				.replace( "%token%", $this.escapeHtml( response.token ) )
				.replace( "%name%", $this.escapeHtml( $this.element.dataset.name ) )
				.replace( "%destroy_url%", $this.escapeHtml( response.destroy_url ) );
      $this.element.innerHTML = template;
      $this.element.querySelector( ".js--remove" ).addEventListener( "click", $this.removeButtonHandler );
    };

    this.onError = function( response ) {
      let template = $this.element.dataset.template_error;
      let errMsg = "Error occurred";
      response = JSON.parse( response );

      if( response && response[0] ) {
        errMsg = response[ 0 ];
      }
			template = template
				.replace( "%error_message%", $this.escapeHtml( errMsg ) );

      $this.element.innerHTML = template;
			$this.element.querySelector( ".js--confirm" ).addEventListener( "click",  $this.confirmButtonHandler );

    }

    this.highlight = function( e ) {
      e.preventDefault();
      $this.element.classList.add( "droparea-highlight" );
    };
  
    this.unhighlight = function() {
      $this.element.classList.remove( "droparea-highlight" );
    };

    this.updateProgress = function( progress ) {
      $this.element.querySelector( ".progress-bar" ).style.width = progress + "%";
    };

    this.escapeHtml = function( unsafe ) {
			return unsafe
				.replace( /&/g, "&amp;" )
				.replace( /</g, "&lt;" )
				.replace( />/g, "&gt;" )
				.replace( /"/g, "&quot;" )
				.replace( /'/g, "&#039;" );
		};

    // click on button displayed after error
    this.confirmButtonHandler = function() {
      $this.element.querySelector( ".js--confirm" ).removeEventListener( "click",  $this.confirmButtonHandler );
      $this.element.innerHTML = $this.element.dataset.input;
      $this.addUIHandlers();
    }

    // click on remove button

    this.removeButtonHandler = async function() {
      let url = $this.element.querySelector( ".js--remove" ).dataset.destroy_url;
      await fetch( url, { method: "POST" } );
      $this.element.querySelector( ".js--remove" ).removeEventListener( "click", $this.removeButtonHandler );
      $this.element.innerHTML = $this.element.dataset.input;
      $this.addUIHandlers();
    };

    // remove UI drag+drop and file selection handlers
    this.removeUIHandlers = function() {
      this.element.querySelector( "input" ).addEventListener( "change", this.onInputChange );
      ;["dragenter", "dragover"].forEach( eventName => {
        this.element.removeEventListener(eventName, this.highlight, false);
      } );
      
      ;["dragleave", "drop"].forEach( eventName => {
        this.element.removeEventListener(eventName, this.unhighlight, false);
      } );

      this.element.removeEventListener( "drop", this.onFilesDrop );
    };

    // add UI drag+drop and file selection handlers
    this.addUIHandlers = function() {
      $this.element.querySelector( "input" ).addEventListener( "change", $this.onInputChange );

      ;["dragenter", "dragover"].forEach( eventName => {
        $this.element.addEventListener( eventName, $this.highlight, false );
      } );
      
      ;["dragleave", "drop"].forEach( eventName => {
        $this.element.addEventListener( eventName, $this.unhighlight, false );
      } );

      $this.element.addEventListener( "drop", $this.onFilesDrop );
    }

    this.addUIHandlers();

  };  

  [...inputs].forEach(function( el ){
    new Uploader( el );
  } );

};