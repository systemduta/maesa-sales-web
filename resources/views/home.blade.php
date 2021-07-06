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
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
</section>

<script src="{{ asset('firebase_notifications') }}/initialization_notification.js"></script>
{{--<script>--}}
{{--    var firebaseConfig = {--}}
{{--        apiKey: "AIzaSyDSsHNrxv2J83XrtWI128E7ouxGrt1InQM",--}}
{{--        authDomain: "salesapps-5df55.firebaseapp.com",--}}
{{--        projectId: "salesapps-5df55",--}}
{{--        storageBucket: "salesapps-5df55.appspot.com",--}}
{{--        messagingSenderId: "318435748321",--}}
{{--        appId: "1:318435748321:web:bde2bdd41a4b3c63cecaa0",--}}
{{--        measurementId: "G-D0HSWX8ZWC"--}}
{{--    };--}}
{{--    firebase.initializeApp(firebaseConfig);--}}
{{--    // firebase.analytics();--}}
{{--</script>--}}
{{--<script>--}}
{{--    const messaging = firebase.messaging();--}}
{{--    function initFirebaseMessagingRegistration() {--}}
{{--        messaging--}}
{{--            .requestPermission()--}}
{{--            .then(function () {--}}
{{--                return messaging.getToken()--}}
{{--            })--}}
{{--            .then(function(token) {--}}
{{--                $.ajaxSetup({--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    }--}}
{{--                });--}}
{{--                $.ajax({--}}
{{--                    url: '{{ route("update_token") }}',--}}
{{--                    type: 'POST',--}}
{{--                    data: {--}}
{{--                        token: token--}}
{{--                    },--}}
{{--                    dataType: 'JSON',--}}
{{--                    success: function (response) {--}}
{{--                        console.log('Token saved successfully.');--}}
{{--                    },--}}
{{--                    error: function (err) {--}}
{{--                        console.log('User Chat Token Error'+ err);--}}
{{--                    },--}}
{{--                });--}}
{{--            }).catch(function (err) {--}}
{{--            console.log('User Chat Token Error'+ err);--}}
{{--        });--}}
{{--    }--}}
{{--    initFirebaseMessagingRegistration();--}}

{{--    messaging.onMessage(function(payload) {--}}
{{--        const noteTitle = payload.notification.title;--}}
{{--        const noteOptions = {--}}
{{--            body: payload.notification.body,--}}
{{--            icon: '/AdminLTE/img/umkm.png',--}}
{{--            requireInteraction: true--}}
{{--        };--}}
{{--        console.log(payload, noteTitle, noteOptions);--}}
{{--        var message = new NotificationHistory(noteTitle, noteOptions);--}}

{{--        message.onclick = function(){--}}
{{--            window.location.replace('/pemesanan/detail/'+payload.data.id)--}}
{{--        };--}}
{{--    });--}}
{{--</script>--}}
@endsection

