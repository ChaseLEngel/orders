if ('serviceWorker' in navigator) {
  navigator.serviceWorker
    .register('./js/serviceworker/worker.js')
    .then(function() {console.log("Service worker registered");})
}
