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
<script>
$(document).ready(function(){
    $('.zoom').hover(function() {
        $(this).addClass('transisi');
    }, function() {
        $(this).removeClass('transisi');
    });
});
</script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <!-- /.card-header -->

                @foreach ($pemesanan as $item)
                <div class="card-header">
                    <h2 class="card-title">Invoice Number : {{$item->id}}</h2>
                    <div class="card-tools">
                        <a href="/pemesanan" type="button" class="btn btn-secondary btn-sm btn-flat">
                            <i class="fa fa-undo"></i>Back
                        </a>
                    </div>
                <!-- /.card-tools -->
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <table id="example1" class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td>Name Sales</td>
                                        <td>{{$item->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Company</td>
                                        <td>{{$item->company->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Name Customer</td>
                                        <td>{{$item->customer_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>{{$item->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Totoal Price</td>
                                        <td>{{$item->total_price}}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>{{$item->discount}}</td>
                                    </tr>
                                    <tr>
                                        <td>Voucher</td>
                                        <td>{{$item->voucher}}</td>
                                    </tr>
                                    <tr>
                                        <td>Noted</td>
                                        <td>{{$item->noted}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        @if($item->status =='cancel')
                                            <td><span class="text-primary">Cancel</span></td>
                                        @elseif($item->status == 'unpaid')
                                            <td><span class="text-danger">Unpaid</span></td>
                                        @elseif($item->status == 'paid')
                                            <td><span class="text-success">Paid</span></td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12">
                            <label>Bukti</label>
                            <div class="img-container">
                                @if($item->bukti)
                                    <img src="{{ asset('bukti')}}/{{ $item->bukti}}" class="zoom">
                                @else
                                    <p class="text-danger">Belum Ada Bukti Pembayaran</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
         <!-- /.card -->
        </div>
    </div>
</div>

        <script>
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

@endsection
