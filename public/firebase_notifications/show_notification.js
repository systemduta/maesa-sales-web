messaging.onMessage(function(payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: '/AdminLTE/img/umkm.png',
        requireInteraction: true
    };
    // console.log(payload);
    var message = new Notification(noteTitle, noteOptions);

    message.onclick = function(){
        window.location.replace('/pemesanan/detail/'+payload.data.id)
    };
});
