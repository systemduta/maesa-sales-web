
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo') }}/SalesApp.png">
  <title>@yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE') }}/dist/css/adminlte.min.css">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

  <!-- jQuery -->
  <script src="{{ asset('AdminLTE') }}/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('AdminLTE') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables -->
  <script src="{{ asset('AdminLTE') }}/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ asset('AdminLTE') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{ asset('AdminLTE') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{ asset('AdminLTE') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('AdminLTE') }}/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('AdminLTE') }}/dist/js/demo.js"></script>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

  <script src="https://code.highcharts.com/highcharts.js"></script>

    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-messaging.js"></script>
    <script src="{{ asset('firebase_notifications') }}/config.js"></script>
    @stack('head')


</head>
@php
$daily_notification_count = \App\NotificationHistory::query()->when(auth()->user(), function($q){
            return $q->where('to_user',auth()->user()->id);
        })->whereDate('created_at', \Carbon\Carbon::today())->count();
@endphp
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell mr-3"></i>
            <span class="badge badge-warning navbar-badge">{{$daily_notification_count}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{$daily_notification_count}} Notifications</span>
          <div class="dropdown-divider"></div>
            <a href="/notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fas fa-power-off"></i>
                Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-red elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="{{ asset('logo') }}/SalesApp.png" alt="logo-sales-app" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sales App</span>
    </a>
    <br>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/storage/{{auth()->user()->avatar}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="javascript:void(0)" class="d-block" data-toggle="modal" data-target="#edit-profile-modal">{{auth()->user()->name}}</a>
                <a href="javascript:void(0)" class="d-block" data-toggle="modal" data-target="#edit-profile-modal">{{auth()->user()->company_id ? auth()->user()->company->name :'-'}}</a>
                <a href="javascript:void(0)" class="d-block" data-toggle="modal" data-target="#edit-profile-modal">{{auth()->user()->devision_id ? auth()->user()->devision->name :'-'}}</a>
{{--                <a href="#" class="d-block">{{auth()->user()->role->display_name}}</a>--}}
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->

              <li class="nav-item">
                  <a href="/home" class="nav-link {{request()->is('home')? 'active': ''}}">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                          Dashboard
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="/transactions" class="nav-link {{request()->is('transactions')? 'active': ''}}">
                      <i class="nav-icon fa fa-retweet"></i>
                      <p>
                          Transaction
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{route('visits.index')}}" class="nav-link {{request()->is('visits')? 'active': ''}}">
                      <i class="nav-icon fa fa-street-view"></i>
                      <p>
                          Visit
                      </p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{route('users.index')}}" class="nav-link {{request()->is('users')? 'active': ''}}">
                      <i class="nav-icon fa fa-users"></i>
                      <p>
                          User
                      </p>
                  </a>
              </li>
              <!-- <li class="nav-item">
                <a href="/customer" class="nav-link {{request()->is('customer')? 'active': ''}}">
                    <i class="nav-icon fas fa-clone"></i>
                    <p>
                        Customers
                    </p>
                </a>
              </li> -->
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('judul1')

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         @yield('content')
      </div>
{{--        modal edit user--}}
        <div class="modal fade" id="edit-profile-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Profile</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form role="form" id="edit_profile_form" method="post" enctype="multipart/form-data" action="{{ route('update_profile') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user_name">Name</label>
                            <input type="text" class="form-control" id="user_name" value="{{auth()->user()->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" id="user_email" value="{{auth()->user()->email}}" required>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" id="user_password">
                            <span class="text-secondary">Kosongkan jika tidak ingin merubah password</span>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password Confirmation</label>
                            <input type="password" class="form-control" id="user_password_confirmation">
                            <span id="tag_password_confirmation" class="text-secondary">Kosongkan jika tidak ingin merubah password</span>
                            <span id="password_not_match" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="user_avatar">Avatar</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="user_avatar">
                                    <label class="custom-file-label" for="user_avatar" id="user_avatar_label">Choose Avatar</label>
                                </div>
                            </div>
                            <span id="user_password" class="text-secondary">Kosongkan jika tidak ingin merubah avatar</span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 </strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.4
    </div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="{{ asset('firebase_notifications') }}/show_notification.js"></script>
<script src="{{ asset('AdminLTE') }}/plugins/browser-image-compressions/polyfill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@1.0.14/dist/browser-image-compression.min.js"></script>
{{--<script src="{{ asset('AdminLTE') }}/plugins/browser-image-compressions/browser-image-compression.js"></script>--}}
<script>
    window.setTimeout(function(){
      $(".alert").fadeTo(500,0).slideUp(500,function(){
        $(this).remove();
      });
    },3000);

    $(document).ready(function(){
        var avatar = null;

        $("#user_avatar").on('change', function (event) {
            var file = event.target.files[0];
            $("#user_avatar_label").text(file.name);
            var options = {
                maxSizeMB: 1,
                maxWidthOrHeight: 1024
            }
            imageCompression(file, options).then(function (output) {
                avatar = output;
            })
        })

        $("#edit_profile_form").submit(function(event) {
            event.preventDefault();
            const fd = new FormData();
            let user_name = $('#user_name').val();
            let user_email = $('#user_email').val();
            let user_password = $('#user_password').val();
            let user_password_confirmation = $('#user_password_confirmation').val();
            if (user_password !== user_password_confirmation) {
                $('#tag_password_confirmation').hide();
                return $('#password_not_match').text("Konfirmasi kata sandi tidak sama");
            }
            let ava = avatar;
            // console.log(ava, (ava.size / 1024 / 1024).toFixed(2) + 'mb');

            fd.append('_method','PUT');
            if(user_name) fd.append('name',user_name);
            if(user_email) fd.append('email',user_email);
            if(user_password) fd.append('password',user_password);
            if(ava) fd.append('avatar',ava);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('update_profile') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Success',
                        body: response
                    });
                    window.location.reload();
                },
            });
        });
    });
  </script>
  @stack('modals')
    @stack('footer')
</body>
</html>
