const CACHE_NAME = 'yaguara-cache-v2';
const STATIC_ASSETS = [
    '/index.php',
    '/public/assets/css/directorio.css',
    '/public/assets/js/search.js',
    '/public/assets/js/maps.js'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            // Ignorar errores de caché en estáticos durante instalación
            return cache.addAll(STATIC_ASSETS).catch(err => console.warn('PWA Cache error:', err));
        })
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        })
    );
});

// Network First strategy
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;
    
    event.respondWith(
        fetch(event.request).then((networkResponse) => {
            return caches.open(CACHE_NAME).then((cache) => {
                if (event.request.url.startsWith('http')) {
                    cache.put(event.request, networkResponse.clone());
                }
                return networkResponse;
            });
        }).catch(() => {
            return caches.match(event.request);
        })
    );
});
