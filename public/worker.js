var cacheName = "lpg"


self.importScripts('/js/dexie.js');

self.addEventListener('install', function(e) {

  console.log("[SERVICEWORKER] Install")

  var filesToCache = [
    '/orders',
    '/js/app.js',
    '/js/dexie.js',
    '/css/app.css'
  ];

  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log("[SERVICEWORKER] Caching files")
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
        console.log("[SERVICEWORKER] Captured GET request for /api/orders.");

        // Open IndexedDB store
        var db = new Dexie("Orders");
        db.version(1).stores({
          orders: "++id,item,quantity,address,driver_id,completed,created_at,updated_at"
        });

        var allOrders = [];
        db.transaction("r", db.orders, function() {
          db.orders.toArray().then(function(orders) {
            allOrders = orders;
          });
        })

        // Potential race condition for return and transaction return?
        return new Response(JSON.stringify(allOrders));
      } else {
        return caches.match(event.request);
      }
    })
  );
});
