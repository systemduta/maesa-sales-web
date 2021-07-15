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

<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title }}</h3>

                <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> {{session('status')}}</h5>
                        </div>
                    @endif
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="30px" class="text-center">No</th>
                                    <th>Invoice Number</th>
                                    <th>Sales</th>
                                    <th>Price</th>
                                    <th>Bukti</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                @foreach ($transaction as $item)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $item->invoice_number }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>Rp. {{ number_format($item->total_price) }}</td>
                                        <td class="text-center">
                                            @if($item->bukti)
                                                <img src="{{ asset('bukti').'/'.$item->bukti }}" data-toggle="modal" data-target="#bukti{{ $item->id}}" width="100px">
                                            @else
                                                <img src="{{ asset('AdminLTE/icon/no-image-icon.png') }}" width="100px"/>
                                            @endif
                                        </td>
                                            @if($item->status =='cancel')
                                                <td class="text-center"><span class="badge badge-primary">Cancel</span></td>
                                            @elseif($item->status == 'order')
                                                <td class="text-center"><span class="badge badge-danger">Order</span></td>
                                            @elseif($item->status == 'paid')
                                                <td class="text-center"><span class="badge badge-success">Paid</span></td>
                                            @endif
                                        <td class="text-center">
                                            <a href="/transactions/detail/{{ $item->id}}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-eye"></i></a>
                                            {{-- <button class="btn btn-sm btn-flat btn-danger" data-toggle="modal" data-target="#delete{{ $item->id}}"><i class="fa fa-trash"></i></button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
                <!-- /.card-body -->
            </div>
         <!-- /.card -->
        </div>
        @foreach ($transaction as $item)
        <div class="modal fade" id="bukti{{ $item->id}}">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                        <h4 class="modal-title">Customer Name : {{ $item->customer_name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/transactions/update/{{$item->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <h3>Price : Rp.{{ number_format($item->total_price)}} </h3>
                            <div class="img-container">
                                @if($item->bukti)
                                    <img src="{{ asset('bukti') }}/{{ $item->bukti }}" class="zoom">
                                @endif
                            </div>
                            <br>
                            <label>Update Status</label>
                                <select name="status" class="form-control">
                                    <option value="{{$item->status}}">{{$item->status}}</option>
                                    <option value="cancel">Cancel</option>
                                    <option value="order">Order</option>
                                    <option value="paid">Paid</option>
                                </select>
                                <div class="text-danger">
                                    @error('status')
                                        {{ $message }}
                                    @enderror
                                </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning">Save</button>
                        </div>
                    </form>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @endforeach
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
@endsection
