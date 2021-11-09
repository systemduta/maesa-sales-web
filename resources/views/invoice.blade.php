<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Invoice</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins';
            color: #808080;
            margin: 0;
        }
        #invoice {
            width: 400px;
            margin: 0 auto;
            padding: 10px 20px;
            border: 1px solid #808080;;
            border-radius: 10px;
        }
        .title {
            font-style: normal;
            font-weight: bold;
            font-size: 24px;
            line-height: 20px;
            margin: 15px 0;
        }
        .horizontal-line {
            border: 1px solid rgba(128, 128, 128, 0.7);
            margin-bottom: 15px;
        }
        .subtitle {
            font-style: normal;
            font-weight: bold;
            font-size: 16px;
            line-height: 16px;
            margin: 10px 0;
        }
        .section-1 {
            margin-bottom: 10px;
        }
        .product-table {
            text-align: left;
            border-collapse: collapse;
            width: 100%;
        }
        .product-table td, .product-table th {
            border-bottom: 1px solid #808080;
            padding: 8px;
        }
        /*.section-2 {*/
        /*    display: flex;*/
        /*    justify-content: space-around;*/
        /*    padding-top: 15px;*/
        /*    border-radius: 5px;*/
        /*    margin: 15px 0;*/
        /*    height: 70px;*/
        /*    border: 1px solid #808080*/
        /*}*/
        /*.product-img {*/
        /*    width: 50px;*/
        /*    height: 50px;*/
        /*    border-radius: 5px;*/
        /*}*/
        .product-label {
            margin: 0;
        }
        .section-payment-total {
            display: flex;
            justify-content: space-between;
        }
        .save-button-wrapper {
            margin-top: 15px;
            display: flex;
            justify-content: center;
        }
        .save-invoice {
            width: 400px;
            background: #E6C02F;
            border-color: #E6C02F;
            color: #ffffff;
            padding: .5rem 1rem;
            font-size: 1.25rem;
            line-height: 1.5;
            border-radius: .3rem;
        }
    </style>
</head>
<body>
<div id="invoice">
    <h4 class="title">Invoice - {{$transaction->invoice_number}}</h4>
    <hr class="horizontal-line"/>
    <div class="section-1">
        @if($transaction->transaction_details->count())
        <h5 class="subtitle">Detail Pembayaran</h5>
        <table class="product-table">
            <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
                @foreach($transaction->transaction_details as $detail)
                    <tr>
                        <td>{{$detail->product_name}}</td>
                        <td>{{number_format($detail->price,2,',','.')}}</td>
                        <td>{{$detail->amount}}</td>
                        <td>{{number_format(($detail->price*$detail->amount),2,',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <div class="section-payment-total">
        <div><h5 class="subtitle">Total Bayar</h5></div>
        <div><h5 class="subtitle">{{"Rp " . number_format($transaction->total_price,2,',','.')}}</h5></div>
    </div>
    <hr class="horizontal-line"/>
    <div class="section-1">
        <h5 class="subtitle">Status Pembayaran</h5>
        <h5 class="subtitle" style="color: #E6C02F;">{{$transaction->status}}</h5>
    </div>
    <div class="section-1">
        <h5 class="subtitle">Silahkan transfer ke nomor rekening:</h5>
        <p class="product-label">{{ $transaction->user->company->payment }}</p>
    </div>
</div>
<div class="save-button-wrapper">
    <button class="save-invoice" onclick="saveInvoice()">Simpan Invoice</button>
</div>
<script src="{{ asset('AdminLTE') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('AdminLTE') }}/plugins/canvas2/html2canvas.min.js"></script>
<script src="{{ asset('AdminLTE') }}/plugins/canvas2/canvas2image.js"></script>
<script>
    function saveInvoice() {
        var elm = $("#invoice").get(0);
        html2canvas(elm).then(function (canvas) {
            Canvas2Image.saveAsImage(canvas, "400", "600", 'png', "{{'Invoice - '.$transaction->invoice_number}}");
        });
    }
</script>
</body>

</html>
