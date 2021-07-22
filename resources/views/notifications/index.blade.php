@extends('layouts.backend')


@section('judul1')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
{{--                    <h1 class="m-0">{{ $title }}</h1>--}}
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
                                    <th>From</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notification as $key => $notif)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td>{{ $notif->created_at }}</td>
                                        <td>{{ $notif->body}}</td>
                                        <td>
                                            <a href="{{route('transactions.detail', ['id'=>$notif->transaction_id])}}">
                                                {{ $notif->transaction->invoice_number}}
                                            </a>
                                        </td>
                                        <td>{{ $notif->from_user_name->name}}</td>
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

@endsection
