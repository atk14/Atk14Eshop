// sees https://adocasts.com/lessons/cross-tab-communication-in-javascript-using-a-sharedworker

const browserInstances = [];
const messages = [];

onconnect = function(e) {
  const port = e.ports[0];

  // store the newly connected browser instance
  browserInstances.push(port);

  port.onmessage = function(event) {
    const message = event.data;

    // store/manipulate your message
    messages.push(message);

    // post message back out to your application
    browserInstances.forEach(instance => {
      instance.postMessage(message);
    });
  }
}