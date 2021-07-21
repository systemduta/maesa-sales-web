@extends('layouts.backend')

@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">Tambah Data Customers</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Customers</h3>
        </div>
        <form action="/customer/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                                <input name="name" class="form-control" placeholder="Name">
                                <div class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                                <input name="address" class="form-control" placeholder="Address">
                                <div class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/customer" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection


{{-- <h3>Create</h3>
@if (count($errors) > 0)
<p> {{$errors->first()}}</p>
@endif
<form action="/models" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    ID: <input type="text" name="id"></br>
    Name: <input type="text" name="name"></br>
    Address: <input type="text" name="address"></br>
    <input type="submit"></br>
</form> --}}
