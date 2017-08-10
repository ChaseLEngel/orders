var cacheName = "lpg"

var cacheWhitelist = [
  '/orders',
  '/js/app.js',
  '/js/dexie.js',
  '/css/app.css'
];

self.importScripts('/js/dexie.js');

self.addEventListener('install', function(event) {

  event.waitUntil(
    caches.open(cacheName).then(function(cache) {
      return cache.addAll(cacheWhitelist)
    })
  );

});

self.addEventListener('fetch', function(event) {
  event.respondWith(contactNetwork(event.request));
});

// Fetch request from network and fall back to cache if network fails.
function contactNetwork(request) {

  return fetch(request).then(function(response) {
    console.log("Successful response for " + request.url);

    updateCache(request, response.clone());

    return response;
  }).catch(function(error) {
    console.log("Failed response for " + request.url + " error :" + error);

    if(request.url.match('/api/orders') && request.method == 'GET') {
      return new Response(JSON.stringify([]));
    } else {
      return caches.match(request);
    }

  })

}

// Update cached request/response pair only if request has been previously cached.
function updateCache(request, response) {
  return caches.open(cacheName).then(function(cache) {
    return cache.match(request).then(function(match) {
      if(match) {
        console.log("Updated cache for " + request.url);
        return cache.put(request, response);
      }
    })
  })
}
