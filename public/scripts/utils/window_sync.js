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

  }

  onSyncMessage( e ) {
    console.log( "it works!", e.data );
    // if message comes from our instance do nothing
    if( e.data.msgID === this.lastMsgId ) {
      console.log( "this is our own message" );
      return;
    }
    document.getElementById( "synctest-output" ).append( e.data.data + "\n" );
    window.dispatchEvent( new Event( "basket_updated" ) )
  }

  send( data ) {
    let msgID = Math.floor(Math.random() * 100).toString() + Date.now();
    this.sync.port.postMessage( { data:data , msgID: msgID } );
    this.lastMsgId = msgID;
  }

  testHandlers() {
    let form = document.getElementById( "synctest" );
    let input = document.getElementById( "synctest-input" );
    form.addEventListener( "submit", function( e ) {
      e.preventDefault();
      this.send( document.getElementById( "synctest-input" ).value );
    }.bind( this ) );
  }

};