// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyDSsHNrxv2J83XrtWI128E7ouxGrt1InQM",
    authDomain: "salesapps-5df55.firebaseapp.com",
    projectId: "salesapps-5df55",
    storageBucket: "salesapps-5df55.appspot.com",
    messagingSenderId: "318435748321",
    appId: "1:318435748321:web:bde2bdd41a4b3c63cecaa0",
    measurementId: "G-D0HSWX8ZWC"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
        messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            console.log(token);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route("save-token") }}',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    alert('Token saved successfully.');
                },
                error: function (err) {
                    console.log('User Chat Token Error'+ err);
                },
            });

        }).catch(function (err) {
            console.log('User Chat Token Error'+ err);
        });
 }

messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.status;
    const noteOptions = {
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
