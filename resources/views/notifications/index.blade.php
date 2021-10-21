@extends('layouts.backend')


@section('judul1')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-12">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Update Unsuccessfully!</h5>
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        </div>
                    @endif
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
        <div class="card card-outline">
            <div class="card-header">
                <h3 class="card-title">Notifications</h3>
                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-notification">Create</button>
                </div>
            </div>
            <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30px" class="text-center">No</th>
                                <th>Date</th>
                                <th>Content</th>
{{--                                <th>Invoice</th>--}}
                                <th>From</th>
                                <th>To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notification as $key => $notif)
                                <tr>
                                    <td class="text-center">{{ $key+1 }}</td>
                                    <td>{{ $notif->created_at }}</td>
                                    <td>{{ $notif->body}}</td>
{{--                                    <td>--}}
{{--                                        <a href="{{route('transactions.detail', ['id'=>$notif->transaction_id])}}">--}}
{{--                                            {{ $notif->transaction->invoice_number}}--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
                                    <td>{{ $notif->from_user_name->name}}</td>
                                    <td>{{ $notif->to_user_name->name}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
        {{--        modal create--}}
        <div class="modal fade" id="create-notification">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                        <h4 class="modal-title">Create New Message</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('notifications.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                            <div class="form-group">
                                <label>To</label>
                                <select class="form-control" aria-label="Select Sales" name="destination" required>
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Message*</label>
                                <textarea class="form-control" name="body" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
