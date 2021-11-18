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
        <div class="card card-outline">
{{--            <div class="card-header">--}}
{{--                <h3 class="card-title">{{$title }}</h3>--}}
{{--            </div>--}}
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> {{session('status')}}</h5>
                    </div>
                @endif
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <div class="d-flex justify-content-end">
                                <div class="p-sm-1"><strong>Filter: </strong></div>
                                <div class="p-sm-1"><a href="{{route('visits.index', ['period' => 'day'])}}" class="btn btn-outline-dark btn-sm">A Today</a></div>
                                <div class="p-sm-1"><a href="{{route('visits.index', ['period' => 'week'])}}" class="btn btn-outline-dark btn-sm">A Week</a></div>
                                <div class="p-sm-1"><a href="{{route('visits.index', ['period' => 'month'])}}" class="btn btn-outline-dark btn-sm">A Month</a></div>
                            </div>
                        </div>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30px" class="text-center">No</th>
                                <th>Visited At</th>
                                <th>Sales</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visits as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td>{{ $item->visited_at }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        @if($item->status =='New')
                                            <span class="badge badge-primary">New</span>
                                        @elseif($item->status == 'Follup')
                                            <span class="badge badge-danger">Follup</span>
                                        @elseif($item->status == 'Existing')
                                            <span class="badge badge-warning">Existing</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm" title="detail" data-toggle="modal" data-target="#visit-{{ $item->id}}">
                                            <i class="fa fa-eye"></i>
                                        </button>
{{--                                         <button class="btn btn-sm btn-flat btn-danger" data-toggle="modal" data-target="#delete{{ $item->id}}"><i class="fa fa-trash"></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
        @foreach ($visits as $item)
        <div class="modal fade" id="visit-{{ $item->id}}">
            <div class="modal-dialog" style="width:30rem;">
                <div class="modal-content">
                  <div class="modal-header">
                        <h4 class="modal-title">A visit from : {{ $item->user->name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <img src="/storage/{{ $item->photo }}" class="card-img-top" alt="visit-photos">
                    <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                        <div style="height: 2rem;"></div>
                        <p class="font-weight-bold">Visited At</p>
                        <p>{{$item->visited_at}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Name</p>
                        <p>{{$item->name}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Phone</p>
                        <p>{{$item->phone}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Address</p>
                        <p>{{$item->address}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Status</p>
                        <p>{{$item->status}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Product</p>
                        <p>{{$item->product}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Result</p>
                        <p>{{$item->result}}</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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
