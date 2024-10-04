window.UTILS = window.UTILS || { };

window.UTILS.WindowSync = class {

  sync; // shared worker instance
  lastMsgId = 0;

  constructor() {
    console.log( "hello me" );
    this.sync = new SharedWorker( "/public/dist/scripts/window_sync_worker.js" );
    
    this.sync.port.onmessage = this.onSyncMessage.bind( this );
    console.log( this.sync );
    this.testHandlers();
    this.setWindowEventHandlers();
  }

  // Incoming message
  onSyncMessage( e ) {
    console.log( "it works!", e.data );
    // if message comes from our instance ignore it / return
    if( e.data.msgID === this.lastMsgId ) {
      console.log( "this is our own message" );
      return;
    }

    // write message to test div
    document.getElementById( "synctest-output" ).append( e.data.data + "\n" );

    // Process known message, ignore unknown messages
    if( e.data.data ){
      let eventName = null;
      // Check for valid messages
      switch ( e.data.data ){
        case "basket_updated":
          eventName = "basket_remote_updated";
          break;
        case "favourites_updated":
          eventName = "favourites_remote_updated";
          break;
      }
      // Trigger appropriate event if message was valid
      if( eventName ) {
        console.log( "WindowSync event:", eventName );
        window.dispatchEvent( new Event( eventName ) );
      } else {
        console.warn( "Invalid WindowSync event:", e.data.data );
      }
    }
    
  }

  // Method to serd message to all other browser instances
  send( data ) {
    // Make unique ID
    let msgID = Math.floor(Math.random() * 100).toString() + Date.now();
    // Send
    this.sync.port.postMessage( { data: data , msgID: msgID } );
    // Remember sent message ID
    this.lastMsgId = msgID;
  }

  // Testing
  testHandlers() {
    let form = document.getElementById( "synctest" );
    form.addEventListener( "submit", function( e ) {
      e.preventDefault();
      this.send( document.getElementById( "synctest-input" ).value );
    }.bind( this ) );
  }

  // Listen for local events (local basket add/remove, local favourites add/remove etc.)
  setWindowEventHandlers() {
    window.addEventListener( "basket_updated", this.onBasketUpdate.bind( this ) );
    window.addEventListener( "favourites_updated", this.onFavoritesUpdate.bind( this ) );
  }

  // On local basket update
  onBasketUpdate() {
    console.log( "BASKET UPDATED EVENT" );
    console.log( "--------------------" );
    this.send( "basket_updated" )
  }

  // On local favorites update
  onFavoritesUpdate() {
    console.log( "FAVOURITES UPDATED EVENT" );
    console.log( "--------------------" );
    this.send( "favourites_updated" )
  }

};