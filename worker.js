const CACHE_NAME = 'notif-cache';
const toCache = [
    '/'
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            return cache.addAll(toCache)
        })
        .then(self.skipWaiting())
    )
})

self.addEventListener('fetch', function(event) {
    event.respondWith(
        fetch(event.request)
        .catch(() => {
            return caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.match(event.request)
            })
        })
    )
})

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys()
        .then((keyList) => {
            return Promise.all(keyList.map((key) => {
                if (key !== CACHE_NAME) {
                    return caches.delete(key)
                }
            }))
        })
        .then(() => self.clients.claim())
    )
})

self.addEventListener('push', function(event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    let data = {};
    if (event.data) {
        data = event.data.json();
    }

    var options = {
        body: data.message,
        icon: '',
        vibrate: [200, 100, 200, 100, 200, 100, 400],
        data: {
            url: data.url,
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {action: 'buka', title: 'Buka'},
            {action: 'tutup', title: 'Tutup'},
        ]
    };

    event.waitUntil(
      self.registration.showNotification(data.title, options)
    );
  });

self.addEventListener('notificationclick', function(e) {
    var notification = e.notification;
    var primaryKey = notification.data.primaryKey;
    var action = e.action;

    if (action === 'tutup') {
        notification.close();
    } else {
        clients.openWindow(notification.data.url);
        notification.close();
    }
});