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
<script>
$(document).ready(function(){
    $('.zoom').hover(function() {
        $(this).addClass('transisi');
    }, function() {
        $(this).removeClass('transisi');
    });
});
</script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <!-- /.card-header -->

                <div class="card-header">
                    <h2 class="card-title">Invoice Number : {{$transaction->invoice_number}}</h2>
                    <div class="card-tools">
                        <a href="/pemesanan" type="button" class="btn btn-secondary btn-sm btn-flat">
                            <i class="fa fa-undo"></i>Back
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <td style="width: 25%;">Name Sales</td>
                                        <td>{{$transaction->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Company</td>
                                        <td>{{$transaction->company->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Name Customer</td>
                                        <td>{{$transaction->customer_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>{{$transaction->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td>{{$transaction->total_price}}</td>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <td>Discount</td>--}}
{{--                                        <td>{{$transaction->discount}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Voucher</td>--}}
{{--                                        <td>{{$transaction->voucher}}</td>--}}
{{--                                    </tr>--}}
                                    <tr>
                                        <td>Noted</td>
                                        <td>{{$transaction->noted}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        @if($transaction->status =='cancel')
                                            <td><span class="text-primary">Cancel</span></td>
                                        @elseif($transaction->status == 'order')
                                            <td><span class="text-danger">Order</span></td>
                                        @elseif($transaction->status == 'paid')
                                            <td><span class="text-success">Paid</span></td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 text-center mt-3">
                            <label>Bukti Pembayaran</label>
                            <div class="img-container">
                                @if($transaction->bukti)
                                    <img src="{{ asset('bukti/').$transaction->bukti}}" class="zoom">
                                @else
                                    <p class="text-danger">Belum Ada Bukti Pembayaran</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h5>Detail Pesanan</h5>
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transaction->transaction_details as $key => $td)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $td->product->name }}</td>
                                    <td>{{ $td->price }}</td>
                                    <td>{{ $td->amount }}</td>
                                    <td>{{ $td->price * $td->amount }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <form action="{{ route('transactions.delete', [$transaction->id]) }}" method="POST" onsubmit="return confirm('Anda yakin ingin Hapus?');" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm float-right" name="_method" value="DELETE">
                            <i class="fas fa-trash"></i> Delete Transaction
                        </button>
                    </form>
                </div>
            </div>
         <!-- /.card -->
        </div>
    </div>
</div>

@endsection
