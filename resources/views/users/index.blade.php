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
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-user">Create</button>
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
                            <th>Name</th>
                            <th>NIK</th>
                            <th>Email</th>
                            <th>Division</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->devision_name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" title="detail" data-toggle="modal" data-target="#detail-{{ $item->id}}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm" title="Edit" data-toggle="modal" data-target="#edit-{{ $item->id}}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
{{--        modal detail--}}
        @foreach ($users as $user)
        <div class="modal fade" id="detail-{{ $user->id}}">
            <div class="modal-dialog" style="width:25rem;">
                <div class="modal-content">
                    <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                        <h4 class="modal-title">Detail User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                        <img src="/storage/{{ $user->avatar }}" class="rounded-circle mx-auto d-block" style="height: 10rem; width:10rem;" alt="Product Image">
                        <div style="height: 2rem;"></div>
                        <p class="font-weight-bold">Name</p>
                        <p>{{$user->name}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">NIK</p>
                        <p>{{$user->nik}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Email</p>
                        <p>{{$user->email}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Division</p>
                        <p>{{$user->devision_name}}</p>
                        <hr size="100%" width="100%">
                        <p class="font-weight-bold">Target Visit</p>
                        <p>{{$user->target_visit}}</p>
                        <p class="font-weight-bold">Target Low</p>
                        <p>{{number_format($user->target_low)}}</p>
                        <p class="font-weight-bold">Target Middle</p>
                        <p>{{number_format($user->target_middle)}}</p>
                        <p class="font-weight-bold">Target High</p>
                        <p>{{number_format($user->target_high)}}</p>
                        <p class="font-weight-bold">Omset</p>
                        <p>{{number_format($user->month_transaction()->sum('total_price'))}}</p>
                        <p class="font-weight-bold">Overachieved</p>
                        @if($user->month_transaction()->sum('total_price') <= $user->target_high)
                            <p>0</p>
                        @else
                            <p>{{number_format($user->month_transaction()->sum('total_price') - $user->target_high)}}</p>
                        @endif
                        <p class="font-weight-bold">New Partner</p>
                        <p>{{$user->getNewPartnerAttribute()}}</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @foreach ($users as $key => $user)
        <div class="modal fade" id="edit-{{ $user->id}}">
            <div class="modal-dialog" style="width:25rem;">
                <div class="modal-content">
                    <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('users.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class="form-control" name="nik" value="{{$user->nik}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="" placeholder="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                            <small class="form-text text-muted">kosongkan jika tidak ingin mengganti password</small>
                        </div>
                        <div class="form-group">
                            <label>Division*</label>
                            <select class="form-control" aria-label="Select Division" name="division_id" required>
                                <option value="{{$user->devision_id}}" selected>{{$user->devision?$user->devision->name:''}}</option>
                                @foreach($divisions as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Target Visit</label>
                            <input type="text" class="form-control" name="target_visit" value="{{$user->target_visit}}" id="target-visit-{{$key}}">
                        </div>
                        <div class="form-group">
                            <label>Target Low</label>
                            <input type="text" class="form-control" value="{{number_format($user->target_low)}}" id="target-low-{{$key}}">
                            <input type="hidden" name="target_low" id="target-low-hidden-{{$key}}">
                        </div>
                        <div class="form-group">
                            <label>Target Middle</label>
                            <input type="text" class="form-control" value="{{number_format($user->target_middle)}}" id="target-middle-{{$key}}">
                            <input type="hidden" name="target_middle" id="target-middle-hidden-{{$key}}">
                        </div>
                        <div class="form-group">
                            <label>Target High</label>
                            <input type="text" class="form-control" value="{{number_format($user->target_high)}}" id="target-high-{{$key}}">
                            <input type="hidden" name="target_high" id="target-high-hidden-{{$key}}">
                        </div>

                        <div class="form-group">
                            <label>Avatar</label>
                            <input type="file" class="form-control-file" name="avatar">
                            <small class="form-text text-muted">kosongkan jika tidak ingin mengganti avatar</small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" name="_method" value="PUT">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <script>
                function updateTextView(_obj){
                    var num = getNumber(_obj.val());
                    if(num==0){
                        _obj.val('');
                    }else{
                        _obj.val(num.toLocaleString());
                    }
                }
                function getNumber(_str){
                    var arr = _str.split('');
                    var out = new Array();
                    for(var cnt=0;cnt<arr.length;cnt++){
                        if(isNaN(arr[cnt])==false){
                            out.push(arr[cnt]);
                        }
                    }
                    return Number(out.join(''));
                }
                function removeComma(value){
                    let a=value;
                    a=a.replace(/\,/g,'');
                    return parseInt(a,10);
                }

                $(document).ready(function() {
                    $('#target-low-{{$key}}').on('keyup', function () {
                        updateTextView($(this));
                        $('#target-low-hidden-{{$key}}').val(removeComma($('#target-low-{{$key}}').val()));
                    });
                    $('#target-middle-{{$key}}').on('keyup', function () {
                        updateTextView($(this));
                        $('#target-middle-hidden-{{$key}}').val(removeComma($('#target-middle-{{$key}}').val()));
                    });
                    $('#target-high-{{$key}}').on('keyup', function () {
                        updateTextView($(this));
                        $('#target-high-hidden-{{$key}}').val(removeComma($('#target-high-{{$key}}').val()));
                    });
                });
            </script>
        @endforeach
{{--        modal create--}}
        <div class="modal fade" id="create-user">
            <div class="modal-dialog" style="width:25rem;">
                <div class="modal-content">
                    <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                            <div class="form-group">
                                <label>Name*</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>NIK*</label>
                                <input type="text" class="form-control" name="nik" required>
                            </div>
                            <div class="form-group">
                                <label>Email*</label>
                                <input type="text" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Password*</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            @if(!auth()->user()->company_id)
                            <div class="form-group">
                                <label>Company*</label>
                                <select class="form-control" aria-label="Select Company" name="company_id" required>
                                    <option value=""></option>
                                    @foreach($companies as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label>Division*</label>
                                <select class="form-control" aria-label="Select Division" name="division_id" required>
                                    <option value=""></option>
                                    @foreach($divisions as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Target Visit</label>
                                <input type="text" class="form-control" name="target_visit">
                            </div>
                            <div class="form-group">
                                <label>Target Low</label>
                                <input type="text" class="form-control" id="target-low">
                                <input type="hidden" name="target_low" id="target-low-hidden">
                            </div>
                            <div class="form-group">
                                <label>Target Middle</label>
                                <input type="text" class="form-control" id="target-middle">
                                <input type="hidden" name="target_middle" id="target-middle-hidden">
                            </div>
                            <div class="form-group">
                                <label>Target High</label>
                                <input type="text" class="form-control" id="target-high">
                                <input type="hidden" name="target_high" id="target-high-hidden">
                            </div>
                            <div class="form-group">
                                <label>Avatar</label>
                                <input type="file" class="form-control-file" name="avatar">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateTextView(_obj){
        var num = getNumber(_obj.val());
        if(num==0){
            _obj.val('');
        }else{
            _obj.val(num.toLocaleString());
        }
    }
    function getNumber(_str){
        var arr = _str.split('');
        var out = new Array();
        for(var cnt=0;cnt<arr.length;cnt++){
            if(isNaN(arr[cnt])==false){
                out.push(arr[cnt]);
            }
        }
        return Number(out.join(''));
    }
    function removeComma(value){
        let a=value;
        a=a.replace(/\,/g,'');
        return parseInt(a,10);
    }

    $(document).ready(function(){
        $('#target-low').on('keyup',function(){
            updateTextView($(this));
            $('#target-low-hidden').val(removeComma($('#target-low').val()));
        });
        $('#target-middle').on('keyup',function(){
            updateTextView($(this));
            $('#target-middle-hidden').val(removeComma($('#target-middle').val()));
        });
        $('#target-high').on('keyup',function(){
            updateTextView($(this));
            $('#target-high-hidden').val(removeComma($('#target-high').val()));
        });

        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    });
</script>
@endsection
