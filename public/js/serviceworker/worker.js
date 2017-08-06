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
