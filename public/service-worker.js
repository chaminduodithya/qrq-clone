self.addEventListener('push', function (event) {
    if (!event.data) return;

    const data = event.data.json();
    const options = {
        body: data.body,
        icon: '/icon.png', // Replace with your icon path
        badge: '/badge.png', // Replace with your badge path
        data: data.url,
        actions: [
            { action: 'open_url', title: 'View Ticket' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    if (event.action === 'open_url' || !event.action) {
        event.waitUntil(
            clients.openWindow(event.notification.data)
        );
    }
});
