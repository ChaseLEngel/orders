var cacheName = "lpg"

self.importScripts('/js/dexie.js');

self.addEventListener('install', function(e) {

  var filesToCache = [
    '/orders',
    '/js/app.js',
    '/css/app.css'
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
  console.log(event.request.method + " " + event.request.url);

  // Network falling back to cache approach.
  event.respondWith(
    fetch(event.request).catch(function() {
      if(event.request.url.match('/api/orders') && event.request.method == 'GET') {
        console.log("Captured GET request for /api/orders.");

        // Open IndexedDB store
        var db = new Dexie("Orders");
        db.version(1).stores({
          orders: "++id,item,quantity,address,driver_id,completed,created_at,updated_at"
        });

        // Return array
        return db.transaction("r", db.orders, function() {
          return new Response(db.orders);
        })
      } else {
        return caches.match(event.request);
      }
    })
  );
});
