@extends('layouts.backend')

@push('head')
    <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/summernote/summernote-bs4.css">
@endpush
@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">Tambah Buku</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card card-outline">
{{--        <div class="card-header">--}}
{{--            <h3 class="card-title">Data Customers</h3>--}}
{{--        </div>--}}
        <form action="{{route('books.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Title</label>
                                <input type="text" name="title" class="form-control">
                                <div class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="textarea" placeholder="Place some text here" name="description"
                                      style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                <div class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control-file">
                            <div class="text-danger">
                                @error('content')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="{{route('books.index')}}" class="float-right btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footer')
    <script src="{{ asset('AdminLTE') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote()
        })
    </script>
@endpush
