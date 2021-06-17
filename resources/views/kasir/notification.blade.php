@extends('layouts.backend')


@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')

    <!-- firebase integration started -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <!-- Firebase App is always required and must be first -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>

    <!-- Add additional services that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-firestore.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-functions.js"></script>

    <!-- firebase integration end -->

    <!-- Comment out (or don't include) services that you don't want to use -->
    <!-- <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-storage.js"></script> -->

    <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.8.0/firebase-analytics.js"></script>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title }}</h3>
                    <div class="card-tools">
                        <a href="/pemesanan" type="button" class="btn btn-secondary btn-sm btn-flat">
                            <i class="fa fa-undo"></i>Back
                        </a>
                    </div>
                <!-- /.card-tools -->
                </div>
                <div class="card-body">

                    Notofication
                    <a href="{{url('send-notification')}}">send notification</a>
                </div>
                <!-- /.card-body -->
            </div>
         <!-- /.card -->
        </div>
    </div>
</div>

<script>
    // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyBy3lrwZysG6_Ic5UzaXMj0QbgLvu1UhtI",
            authDomain: "salesapps-e4c5f.firebaseapp.com",
            projectId: "salesapps-e4c5f",
            storageBucket: "salesapps-e4c5f.appspot.com",
            messagingSenderId: "921848182167",
            appId: "1:921848182167:web:913e2f1550e25ca3d0c0d2",
            measurementId: "G-4DWDFPKEXC"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        //firebase.analytics();
        const messaging = firebase.messaging();
            messaging.requestPermission()
            .then(function () {
                //MsgElem.innerHTML = "Notification permission granted."
                console.log("Notification permission granted.");

                // get the token in the form of promise
                return messaging.getToken()
            })
            .then(function(token) {
                alert(token);
                // print the token on the HTML page
                console.log(token);
            })
            .catch(function (err) {
                console.log("Unable to get permission to notify.", err);
            });

        messaging.onMessage(function(payload) {
            console.log(payload);
            var notify;
            notify = new Notification(payload.notification.title,{
                body: payload.notification.body,
                icon: payload.notification.icon,
                tag: "Dummy"
            });
            console.log(payload.notification);
        });

            //firebase.initializeApp(config);
        var database = firebase.database().ref().child("/users/");

        database.on('value', function(snapshot) {
            renderUI(snapshot.val());
        });

        // On child added to db
        database.on('child_added', function(data) {
            console.log("Comming");
            if(Notification.permission!=='default'){
                var notify;

                notify= new Notification('CodeWife - '+data.val().username,{
                    'body': data.val().message,
                    'icon': 'bell.png',
                    'tag': data.getKey()
                });
                notify.onclick = function(){
                    alert(this.tag);
                }
            }else{
                alert('Please allow the notification first');
            }
        });

        self.addEventListener('notificationclick', function(event) {
            event.notification.close();
        });

</script>

@endsection
