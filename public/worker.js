self.addEventListener('install', function(e) {
  var cacheName = "lpg"

  var filesToCache = [
    '/orders'
  ];
  console.log("[Service Worker] Install")
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log("[Service Worker] Caching files")
      return cache.addAll(filesToCache)
    })
  );
});

self.addEventListener('fetch', function(event) {
  console.log(event)
  event.respondWith(caches.match(event.request))
});
