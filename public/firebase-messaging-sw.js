/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
        apiKey: "AIzaSyDSsHNrxv2J83XrtWI128E7ouxGrt1InQM",
        authDomain: "salesapps-5df55.firebaseapp.com",
        projectId: "salesapps-5df55",
        storageBucket: "salesapps-5df55.appspot.com",
        messagingSenderId: "318435748321",
        appId: "1:318435748321:web:bde2bdd41a4b3c63cecaa0",
        measurementId: "G-D0HSWX8ZWC"
    });

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Update Status";
    const notificationOptions = {
        body: "Status Berhasil di Update",
        icon: "/AdminLTE/img/umkm.png",
        action: "https://google.com",
        requireInteraction: true
    };

    self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );

    // self.registration.showNotification("New mail from Alice", {
    //     actions: [
    //         {
    //             action: 'archive',
    //             title: 'Archive'
    //         }
    //     ]
    // });

    self.addEventListener('notificationclick', function(event) {
        event.notification.close();
        clients.openWindow('/pemesanan');
    }, false);
});
