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
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info"> <!-- bg-success/bg-warning/bg-danger -->
          <div class="inner">
            <h3>{{$transactions->count()}}</h3>

            <p>Number of Transactions</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div> <!-- ./col -->
    </div> <!-- ./row -->
    <div class ="row">
      <div class="col-md-6">
        <!-- USER LIST -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Sales</h3>

            <div class="card-tools">
              <span class="badge badge-secondary">{{$users->count()}} Total Members</span>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <ul class="users-list clearfix">
              @foreach ($users as $key => $user)
                <li>
                  <img src="{{ $user->avatar }}" alt="User Image">
                  <a class="users-list-name" href="#">{{ $user->name }}</a>
                  <span class="users-list-date">{{ $user->nik }}</span>
                </li>
              @endforeach
            </ul>
            <!-- /.users-list -->
          </div>
          <!-- /.card-body -->
          <!-- <div class="card-footer text-center">
            <a href="javascript::">View All Users</a>
          </div> -->
          <!-- /.card-footer -->
        </div> <!--/.card USER LIST-->
      </div><!-- ./col -->
      <div class="col-md-6">
        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">All Products</h3>
              <div class="card-tools">
                <span class="badge badge-secondary">{{$products->count()}} Total Products</span>
              </div>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach ($products as $key => $product)
                  <li class="item">
                    <div class="product-img">
                      <img src= "{{ $product->img }}" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title" data-toggle="modal" data-target="#product-modal"> {{ $product->name }}
                        <span class="badge badge-warning float-right">Rp. {{ $product->price }}</span></a>
                      <span class="product-description">
                        {{ $product->description }}
                      </span>
                    </div>
                  </li>

                  <!-- POP UP PRODUCT -->
                  <div class="modal fade" id="product-modal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">{{ $product->name }}</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="form-group row">
                            <label for="product_desc" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext text-wrap" id="product_desc" value="{{$product->description}}">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="product_price" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="product_price" value="Rp. {{$product->price}}">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="product_stok" class="col-sm-2 col-form-label">Stock</label>
                            <div class="col-sm-10">
                              <input type="text" readonly class="form-control-plaintext" id="product_stok" value="{{$product->stok}}">
                            </div>
                          </div>
                        </div>
                      </div> <!-- /.modal-content -->
                    </div> <!-- /.modal-dialog -->
                  </div> <!-- /.modal POP UP PRODUCT -->
                @endforeach
                <!-- /.item -->
              </ul>
            </div><!-- /.card-body -->
            <!-- <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div> /.card-footer -->
        </div> <!-- /.card PRODUCT LIST-->
      </div> <!-- ./col -->
    </div> <!-- ./row -->
  </div> <!-- /.container-fluid -->
</section>

<script src="{{ asset('firebase_notifications') }}/initialization_notification.js"></script>
@endsection

