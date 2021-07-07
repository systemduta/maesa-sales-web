function initFirebaseMessagingRegistration() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function(token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/update_token',
                type: 'POST',
                data: {
                    token: token
                },
                dataType: 'JSON',
                success: function (response) {
                    console.log('Setup notif successfully.');
                },
                error: function (err) {
                    console.log('User Chat Token Error'+ err);
                },
            });
        }).catch(function (err) {
        console.log('User Chat Token Error'+ err);
    });
}
initFirebaseMessagingRegistration();
