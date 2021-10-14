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
            <div class="card-header">
                <div class="card-tools">
                    <a class="btn btn-primary btn-sm" href="{{route('books.create')}}">Create</a>
                </div>
            </div>
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
                                <th>Title</th>
                                <th>Cover</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <img src="/{{$item->image}}" alt="book-img" style="width: 150px; height: auto;">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm" title="detail" data-toggle="modal" data-target="#book-{{ $item->id}}">
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
        @foreach ($books as $item)
        <div class="modal fade" id="book-{{ $item->id}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                        <h4 class="modal-title">{{ $item->title}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <img src="/storage/{{ $item->image }}" class="card-img-top" alt="visit-photos">
                    <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                        {!! $item->description !!}
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
    });
</script>
@endsection
