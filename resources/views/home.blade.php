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
            <h5>Rp {{number_format($transactions->sum('total_price'))}}</h5>

            <p>Total of transactions</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('transactions.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div> <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success"> <!-- bg-success/bg-warning/bg-danger -->
          <div class="inner">
            <h5>{{$visits->count()}}</h5>

            <p>Total of Visits</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{route('visits.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div> <!-- ./col -->
    </div> <!-- ./row -->
    <div class ="row">
      <div class="col-md-6">
        <!-- USER LIST -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Salespersons</h3>

            <div class="card-tools">
              <span class="badge badge-secondary">{{$users->count()}} Total Members</span>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <ul class="users-list clearfix">
              @foreach ($users as $key => $user)
                <li>
                  <img src="/storage/{{ $user->avatar }}" alt="User Image">
                  <a class="users-list-name" href="javascript:void(0)" data-toggle="modal" data-target="#user-modal-{{$key}}">{{ $user->name }}</a>
                  <span class="users-list-date">{{ $user->nik }}</span>
                </li>
                <!-- POP UP USER -->
                <div class="modal fade" id="user-modal-{{$key}}">
                    <div class="modal-dialog" style="width:25rem;">
                      <div class="modal-content">
                        <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                          <h4 class="modal-title">Profile</h4>
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
                            <p class="font-weight-bold">Email</p>
                            <p>{{$user->email}}</p>
                            <hr size="100%" width="100%">
                            <p class="font-weight-bold">NIK</p>
                            <p>{{$user->nik}}</p>
                            <p class="font-weight-bold">Target Visit</p>
                            <p>{{$user->target_visit}}</p>
                            <p class="font-weight-bold">Target Pencapaian</p>
                            <p>{{$user->visit_month()->count()}}</p>
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
                      </div> <!-- /.modal-content -->
                    </div> <!-- /.modal-dialog -->
                  </div> <!-- /.modal POP UP USER -->

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
                      <img src= "/storage/{{ $product->img }}" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title" data-toggle="modal" data-target="#product-modal-{{$key}}"> {{ $product->name }}
                        <span class="badge badge-warning float-right">Rp. {{ number_format($product->price) }}</span></a>
                      <span class="product-description">
                        {{ $product->description }}
                      </span>
                    </div>
                  </li>

                  <!-- POP UP PRODUCT -->
                  <div class="modal fade" id="product-modal-{{$key}}">
                    <div class="modal-dialog" style="width:27rem;">
                      <div class="modal-content" style="padding-left:1rem; padding-right:1rem;">
                        <div class="modal-header" style="height:3.5rem;">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <div class="modal-body">
                          <div class="row">
                            <img src="/storage/{{ $product->img }}" class="rounded mx-auto d-block" style="height: 10rem; width:10rem;" alt="Product Image">
                          </div>
                          <div style="height: 2rem;"></div>
                          <div class="form-group row">
                            <h5 class="col-sm-6 font-weight-bold">{{$product->name}}</h5>
                            <h5 class="col-sm-6 font-weight-bold text-right">Rp. {{number_format($product->price)}}</h5>
                          </div>
                          <div class="form-group row">
                            <h6 class="col-sm-6 font-weight-bold">Stock: {{$product->stok}}</h6>
                          </div>
                          <div class="form-group row">
                            <div class="col">
                              <p style="text-align: justify;"> {{$product->description}}</p>
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

