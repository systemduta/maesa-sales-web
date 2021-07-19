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

<style type="text/css">
    .img-container{
        text-align: center;
    }
    img.zoom {
        width: 750px;
        height: 400px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        -ms-transition: all .2s ease-in-out;
    }

    .transisi {
        -webkit-transform: scale(1.8);
        -moz-transform: scale(1.8);
        -o-transform: scale(1.8);
        transform: scale(1.8);
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Notifications</h3>

                <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">No</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                    <th>Invoice</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @for ($i = 1; $i <= 50; $i++)
                                    <tr>
                                        <td class="text-center">{{$i}}</td>
                                        <td>9/9/9999</td>
                                        <td>Cek jadi ini isinya body {{$i}}</td>
                                        <td>OKeh judul {{$i}}</td>
                                        <td>usernya sapa {{$i}}</td>
                                    </tr>
                                @endfor
                                @foreach ($notification as $notif)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $notif->created_at }}</td>
                                        <td>{{ $notif->body}}</td>
                                        <td>{{ $notif->title}}</td>
                                        <td>{{ $notif->from_user}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- /.card-body -->
            </div>
         <!-- /.card -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.zoom').hover(function() {
            $(this).addClass('transisi');
        }, function() {
            $(this).removeClass('transisi');
        });
    });

    $(function () {
        $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        });
        $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        });
    });
</script>

