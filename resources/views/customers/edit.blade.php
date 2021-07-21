@extends('layouts.backend')

@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">Edit Data Customers</h1>
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
        <form action="/customer/update/{{ $customers->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Name</label>
                                <input name="name" value="{{ $customers->name}}" class="form-control" placeholder="Name">
                                <div class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                                <input name="address" value="{{ $customers->address}}" class="form-control" placeholder="Address">
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


<!-- bootstrap color picker -->
<script src="{{ asset('AdminLTE') }}/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script>
   //color picker with addon
   $('.my-colorpicker2').colorpicker()
   $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });
</script>
@endsection



{{-- <h3>Edit</h3>
<form action="/models/{{$model->id}}" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    Name: <input type="text" name="name" value="{{$model->name}}"></br>
    Address: <input type="text" name="address" value="{{$model->address}}"></br>
    <button type="submit" name="_method" value="PUT">Simpan</button>
    <button type="submit" name="_method" value="DELETE">Hapus</button>
</form> --}}
