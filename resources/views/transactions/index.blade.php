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
<!-- for export -->
<link href="{{asset('assets1/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{asset('assets1/css/style.css')}}" rel="stylesheet">

<style type="text/css">
    .img-container{
        text-align: center;
    }
    /* .main-sidebar{
        width: 350px;
    } */
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
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-transaction">Create</button>
                </div>
                <form class="form-inline" action="{{ route('transactions.periode') }}" method="GET">
                    <div class="form-group">
                        <label for="date">Tanggal Awal : </label>
                        <input type="date" class="form-control datepicker" name="tgl_awal" autocomplete="off" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="date">Tanggal Akhir : </label>
                        <input type="date" class="form-control datepicker" name="tgl_akhir" autocomplete="off" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group ml-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> {{session('status')}}</h5>
                    </div>
                @endif

                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="30px" class="text-center">No</th>
                                <th>Date</th>
                                <th>Invoice Number</th>
                                <th>Sales</th>
                                <th>Price</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            @foreach ($transaction as $item)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->invoice_number }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>Rp. {{ number_format($item->total_price) }}</td>
                                    <td>{{ $item->address }}</td>
                                    {{-- <td class="text-center">
                                        @if($item->bukti)
                                            <img src="{{ asset('bukti').'/'.$item->bukti }}" data-toggle="modal" data-target="#bukti{{ $item->id}}" width="100px">
                                        @else
                                            <img src="{{ asset('AdminLTE/icon/no-image-icon.png') }}" data-toggle="modal" data-target="#bukti{{ $item->id}}" width="100px"/>
                                        @endif
                                    </td> --}}
                                        @if($item->status =='New')
                                            <td class="text-center"><span class="badge badge-primary">New</span></td>
                                        @elseif($item->status == 'Repeat Order')
                                            <td class="text-center"><span class="badge badge-danger">Repeat Order</span></td>
                                        @else
                                            <td class="text-center"><span class="badge badge-light">{{$item->status}}</span></td>
                                        @endif
                                    <td class="text-center">
                                        <a href="/transactions/detail/{{ $item->id}}" class="btn btn-sm btn-flat btn-warning"><i class="fa fa-eye"></i></a>
                                        <button class="btn btn-sm btn-flat btn-primary" data-toggle="modal" data-target="#bukti{{ $item->id}}"><i class="fa fa-edit"></i></button>
                                        <a href="/transactions/delete/{{$item->id}}" class="btn btn-sm btn-flat btn-danger"><i class="fa fa-trash"></i></a>
                                        {{-- <button class="btn btn-sm btn-flat btn-danger" data-toggle="modal" data-target="#delete{{ $item->id}}"><i class="fa fa-trash"></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
            <!-- /.card-body -->
        </div>
         <!-- /.card -->
        @foreach ($transaction as $item)
        <div class="modal fade" id="bukti{{ $item->id}}">
            <div class="modal-dialog modal-xl">
                <div class="modal-content example">
                    <div class="modal-header">
                        <h4 class="modal-title">Customer Name : {{ $item->customer_name}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="/transactions/update/{{$item->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" class="form-control" name="customer_name" value="{{ $item->customer_name }}">
                                <div class="text-danger">
                                    @error('customer_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Noted</label>
                                <input type="text" class="form-control" name="noted" value="{{ $item->noted }}">
                                <div class="text-danger">
                                    @error('noted')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" name="address" rows="3" required>{{ $item->address}}</textarea>
                                <div class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control"  name="total_price" value="{{ $item->total_price}}">
                                <div class="text-danger">
                                    @error('total_price')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info">Save</button>
                        </div>
                    </form>
                </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @endforeach
        {{--        modal create--}}
        <div class="modal fade" id="create-transaction">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="height:3.5rem; padding-left:1rem;">
                        <h4 class="modal-title">Create Transaction</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('transactions.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body" style="padding-left:2rem; padding-right:2rem;">
                            <div class="form-group">
                                <label>Sales</label>
                                <select class="form-control" aria-label="Select Sales" name="user_id" required>
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Customer Name*</label>
                                <input type="text" class="form-control" name="customer_name" required>
                            </div>
                            <div class="form-group">
                                <label>Address*</label>
                                <textarea class="form-control" name="address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="total_price" required>
                            </div>
                            {{-- <h6><strong>Products</strong></h6>
                            <div id="inputFormRow-0">
                                <div class="form-inline">
                                    <select class="form-control mb-2 mr-sm-2" id="selectProduct" style="width: 10rem;" name="products[0][product_id]" onchange="handleSelectProduct(0,value)">
                                        <option value="">Choose Product...</option>
                                        @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="originPrice-0" class="form-control mb-2 mr-sm-2" style="width: 10rem;" name="products[0][price]" readonly>
                                    <button type="button" class="btn btn-info mb-2 mr-sm-2" onclick="minAmount(0)">-</button>
                                    <input type="text" class="form-control mb-2 mr-sm-2" id="amount-0" placeholder="0" style="width: 3em;" name="products[0][amount]" value="1">
                                    <button type="button" class="btn btn-info mb-2 mr-sm-2" onclick="addAmount(0)">+</button>
                                </div>
                            </div>
                            <div id="newProduct"></div>
                            <button id="addProduct" type="button" class="btn btn-outline-secondary btn-sm">Add Product</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="calculatePrice()">Calculate</button> --}}
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

<!-- for export all -->
<script src="{{URL::to('assets1/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{URL::to('assets1/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>


<script>
    $(document).ready(function(){
        $('.zoom').hover(function() {
            $(this).addClass('transisi');
        }, function() {
            $(this).removeClass('transisi');
        });
    });

    $(function () {
        $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Data Transaksi {{ date("d-m-Y") }}'},
                {extend: 'pdf', title: 'Data Transaksi {{ date("d-m-Y") }}'},

                {extend: 'print',
                 customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
                }
            ]
        });
    });

</script>

@endsection
@push('footer')
    <script type="text/javascript">
        // add row
        let id_input = 1;
        let products = @json($products);
        let product_choosen = [{}];
        let amount_choosen = [1];
        $("#addProduct").click(function () {
            let form = '';
            form += `<div id="inputFormRow">`;
            form += '<div class="form-inline">';
            form += `<select class="form-control mb-2 mr-sm-2" id="inlineFormCustomSelectPref" style="width: 10rem;" name="products[${id_input}][product_id]" onchange="handleSelectProduct(${id_input},value)">`;
            form += '<option value="">Choose Product...</option>';
            products.map(function (item) {
                form += `<option value="${item.id}">${item.name}</option>`;
            })
            form += '</select>';
            form += `<input type="text" id="originPrice-${id_input}" class="form-control mb-2 mr-sm-2" style="width: 10rem;" name="products[${id_input}][price]" readonly>`;
            form += `<button type="button" class="btn btn-info mb-2 mr-sm-2" onclick="minAmount(${id_input})">-</button>`;
            form += `<input type="text" class="form-control mb-2 mr-sm-2" id="amount-${id_input}" placeholder="0" style="width: 3em;" name="products[${id_input}][amount]" value="1">`;
            form += `<button type="button" class="btn btn-info mb-2 mr-sm-2" onclick="addAmount(${id_input})">+</button>`;
            form += `<button id="removeRow" type="button" class="btn btn-danger" data-value="${id_input}">Remove</button>`;
            form += '</div>';
            form += '</div>';

            product_choosen.push({});
            amount_choosen.push(1);
            $(`#masterTotalPrice`).val(null);
            id_input++;
            $('#newProduct').append(form);
        });

        function handleSelectProduct(form_id, value) {
            let product_selected = products.find(function (item) {
                return item.id == parseInt(value);
            });
            product_choosen[form_id] = product_selected;
            $(`#masterTotalPrice`).val(null);
            $(`#originPrice-${form_id}`).val(product_selected.price);
        }

        function addAmount(id) {
            let amount = $(`#amount-${id}`).val();
            amount++;
            amount_choosen[id] = amount;
            $(`#amount-${id}`).val(amount);
            $(`#masterTotalPrice`).val(null);
        }

        function minAmount(id) {
            let amount = $(`#amount-${id}`).val();
            if (amount > 1) {
                amount--;
                $(`#amount-${id}`).val(amount);
            }
            amount_choosen[id] = amount;
            $(`#masterTotalPrice`).val(null);
        }

        function calculatePrice() {
            let temp_price = 0;
            product_choosen.forEach(function (item, index) {
                if (Object.keys(item).length) {
                    temp_price += item.price * amount_choosen[index];
                }
            });
            $(`#masterTotalPrice`).val(temp_price);
        }

        // remove row
        $(document).on('click', '#removeRow', function () {
            let id = $(this).data("value");
            product_choosen[id] = {};
            amount_choosen[id] = null;
            $(`#masterTotalPrice`).val(null);
            $(this).closest('#inputFormRow').remove();
        });
    </script>
    <script>
{{--        setup read only--}}
        $(".readonly").keydown(function(e){
            e.preventDefault();
        });
    </script>
@endpush
