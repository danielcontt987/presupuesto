// const CACHE_NAME = 'my-site-cache-v1';
// const urlsToCache = [
//   '/login',
// ];

// self.addEventListener('install', event => {
//   event.waitUntil(
//     caches.open(CACHE_NAME)
//       .then(cache => {
//         return cache.addAll(urlsToCache);
//       })
//   );
// });

// self.addEventListener('fetch', event => {
//     if (event.request.method === 'GET') {
//       event.respondWith(
//         caches.match(event.request)
//           .then(response => {
//             // Cache hit: return response
//             if (response) {
//               return response;
//             }
  
//             // Clone the request to make a fetch
//             const fetchRequest = event.request.clone();
  
//             return fetch(fetchRequest)
//               .then(response => {
//                 // Check if we received a valid response
//                 if (!response || response.status !== 200 || response.type !== 'basic') {
//                   return response;
//                 }
  
//                 // Clone the response to cache it
//                 const responseToCache = response.clone();
  
//                 caches.open(CACHE_NAME)
//                   .then(cache => {
//                     cache.put(event.request, responseToCache);
//                   });
  
//                 return response;
//               });
//           })
//       );
//     } else {
//       // For non-GET requests, handle as usual without caching
//       event.respondWith(
//         fetch(event.request)
//       );
//     }
// });
  

//   self.addEventListener('activate', event => {
//     const cacheWhitelist = ['my-site-cache-v1'];
  
//     event.waitUntil(
//       caches.keys().then(cacheNames => {
//         return Promise.all(
//           cacheNames.map(cacheName => {
//             if (cacheWhitelist.indexOf(cacheName) === -1) {
//               return caches.delete(cacheName);
//             }
//           })
//         );
//       })
//     );
//   });
  