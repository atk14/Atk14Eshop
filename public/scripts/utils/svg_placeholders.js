window.UTILS = window.UTILS || { };

/**
 * Class for generating svg placeholder
 * usage:
 * 
 * HTML:
 * <img src="SVGPlaceholder/100/300" alt="Lorem ipsum">
 * <img src="SVGPlaceholder/100/300/#ccaa33" alt="Lorem ipsum" width="100">
 * <img src="SVGPlaceholder" alt="Lorem ipsum" width="100" height="300">
 * 
 * JS:
 * window.UTILS.SVGPlaceholders.SVGPlaceholders();
 * 
 */
window.UTILS.SVGPlaceholders = class {

  /**
   * Static method to replace img src="SVGPLaceholder" with SVG image
   * Just call this method.
   */
  static SVGPlaceholders() {
    // console.log( "start" );

    let placeholders = document.querySelectorAll( "img[src^='SVGPlaceholder']" );

    [...placeholders].forEach( function( img ) {
      // console.log( img.getAttribute( "src" ) );
      // Object to store all img parameters
      let imgParams = {};

      // Parse img src attribute 
      let size = img.getAttribute( "src" ).split( "/" );

      // Third parameter is optional bgcolor
      if( size[ 3 ] ) {
        imgParams.bgColor = size[ 3 ];
      }

      // Second optional parameter is height
      if( size[ 2 ] ) {
        imgParams.height = size[ 2 ];
      } else if( img.getAttribute( "height" ) ) {
        // if no height parameter present, try to get it from img height attribute
        imgParams.height = img.getAttribute( "height" );
      }

      // First optional parameter is width
      if( size[ 1 ] ) {
        imgParams.width = size[ 1 ];
      } else if( img.getAttribute( "width" ) ) {
        imgParams.width = img.getAttribute( "width" );
      }

      // If img has width and height parameters store them separately
      if( img.getAttribute( "width" ) ) {
        imgParams.attrWidth = img.getAttribute( "width" );
      }
      if( img.getAttribute( "height" ) ) {
        imgParams.attrHeight = img.getAttribute( "height" );
      }

      // Replace image src with generated svg image
      img.src = this.createPlaceholder( imgParams );
      // console.log( imgParams );
    }.bind( this ) );
  }
  
  /**
   * 
   * @param {object} options 
   * width: image width, used for svg viewbox
   * height: image height, used for svg viewbox
   * bgColor: bg color for image if specified
   * attrWidth: width taken from img height attribute, used for svg width
   * attrHeight: height taken from img height attribute, used for svg height
   * @returns string with SVG image in data URI format
   */
  static createPlaceholder( options ) {

    // merge options with defaults
    let params = {
      width: 1600,
      height: 900,
      bgColor: this.generateColor(),
      ...options
    };
    // console.log( { params } );

    // additional svg attributes
    let atts = "";
    // if img tag has width and/or height attributes, use them for svg width and height
    if ( params.attrWidth ) {
      atts += " width=" + "\"" + params.attrWidth + "\""
    }
    if ( params.attrHeight ) {
      atts += " height=" + "\"" + params.attrHeight + "\""
    }

    // create svg markup
    var svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${params.width} ${params.height}"${atts}>
      <rect width="${params.width}" height="${params.height}" fill="${params.bgColor}"></rect>
      <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="sans-serif" font-size="18px" fill="#fcf7f7">${params.width} × ${params.height}</text>   
    </svg>`;
    // console.log( svg );
    let encodedData = this.svgToDataURL( svg );
    // console.log( encodedData );
    return encodedData;
  }
  /**
   * Generates random light low saturated color
   * @returns hsl color string
   */
  static generateColor() {
    return "hsl(" + Math.random() * 360 + ", 15%, 85%)";
  }

  /**
   * converts SVG markup string to data URI
   * @param {string} svg 
   * @returns data URI string
   */
  static svgToDataURL( svg ) {
    const encoded = encodeURIComponent( svg )
      // eslint-disable-next-line
      .replace(/'/g, "%27")
      // eslint-disable-next-line
      .replace(/"/g, "%22")
  
    const header = "data:image/svg+xml,";
    const dataUrl = header + encoded
  
    return dataUrl
  }
};