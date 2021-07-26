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
  <div class="container-fluid yhaa">
    <!-- Small boxes (Stat box) -->
    <div class="row row1">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>150</h3>

            <p>New Orders</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>53<sup style="font-size: 20px">%</sup></h3>

            <p>Bounce Rate</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>44</h3>

            <p>User Registrations</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>

            <p>Unique Visitors</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div> <!-- ./col -->
    </div> <!-- ./row -->
    <div class ="row">
      <div class="col-md-4">
        <!-- PRODUCT LIST -->
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Recently Added Products</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div> <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                @foreach ($products as $key => $product)
                <li class="item">
                  <div class="product-img">
                    <img src="dist/img/default-150x150.png" alt="img" class="img-size-50">
                  </div>
                  <div class="product-info">
                    <a href="javascript:void(0)" class="product-title"> {{ $product->name }}
                      <span class="badge badge-warning float-right">Rp. {{ $product->price }}</span></a>
                    <span class="product-description">
                      {{ $product->description }}
                    </span>
                  </div>
                </li>
                @endforeach
                <!-- /.item -->
              </ul>
            </div><!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div> <!-- /.card-footer -->
        </div> <!-- /.card PRODUCT LIST-->
      </div> <!-- ./col -->
    </div> <!-- ./row -->
  </div> <!-- /.container-fluid -->
</section>

<script src="{{ asset('firebase_notifications') }}/initialization_notification.js"></script>
@endsection

<!-- <style>
  .row{
    background:yellowgreen;
  }
  .row1{
    background:aqua;
  }

  .yhaa{
    background:pink;
  }
</style> -->

