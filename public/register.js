if ('serviceWorker' in navigator) {
  navigator.serviceWorker
    .register('/worker.js')
    .then(function() {
      console.log("Service worker registered");
    })
    .catch(function(error) {
      console.error("Error registering Service Worker :" + error);
    });
} else {
  console.error("Browser does not support Service Worker.")
}
