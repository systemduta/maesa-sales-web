<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;



class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction   = Transaction::all();
        $transacdetail = TransactionDetail::all();

        return response()->json(['Transaction' => $transaction, $transacdetail]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // dd($request->toArray());
        $request->validate([
            'user_id'           => 'required',
            'company_id'        => 'required|string',
            'invoice_number'    => 'required',
            'customer_name'     => 'required|string',
            'address'           => 'required',
            'total_price'       => 'required',
            // 'status'            => 'required',
            // 'product_id'        => 'required',
            // 'amount'            => 'required',
        ]);

        $transaction = Transaction::create([
            'user_id'           => auth()->user()->id,
            'company_id'        => $request->company_id,
            'invoice_number'    => $request->invoice_number,
            'customer_name'     => $request->customer_name,
            'address'           => $request->address,
            $total = $request->total_price - ($request->total_price * $request->discount/100) - $request->voucher,
            'total_price'       => $total,
            'discount'          => $request->discount,
            'voucher'           => $request->voucher,
            'noted'             => $request->noted,
            'status'            => $request->status,
        ]);

        $new_products = collect([]);
        foreach ($request->products as $product) {
                $new_products->push([
                    'transaction_id' => $transaction->getKey(),
                    'product_id'     => $product->product_id,
                    'amount'         => $product->amount,
                    'price'          => $product->price,
                ]);
        }
        dd($new_products);
        TransactionDetail::create();

    return response()->json(['message' => 'Data Add Successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $carts = Cart::where('user_id', Auth::user()->id);
        // $cartUser = $carts->get();

        // $transaction = Transaction::create([
        //     'user_id' => Auth::user()->id
        // ]);

        // foreach ($cartUser as $cart) {
        //     $transaction->detail()->create([
        //         'product_id' => $cart->product_id,
        //         'qty' => $cart->qty
        //     ]);
        // }

        // Mail::to($carts->first()->user->email)->send(new CheckoutMail($cartUser));
        // Cart::where('user_id', Auth::user()->id)->delete();
        // return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transdetail = TransactionDetail::where('id', $id)->with('transaction')->first();

        return response()->json(['Transaction' => $transdetail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::where('id',$id)->first();

        $request->validate([
            'user_id'           => 'required',
            'company_id'        => 'required|string',
            'invoice_number'    => 'required',
            'customer_name'     => 'required|string',
            'address'           => 'required',
            'total_price'       => 'required',
            'status'            => 'required',
            'product_id'        => 'required',
            'amount'            => 'required',
            'transaction_id'    => 'required',
        ]);

        Transaction::findOrFail($id)->update([
            'user_id'           => auth()->user()->id,
            'company_id'        => $request->company_id,
            'invoice_number'    => $request->invoice_number,
            'customer_name'     => $request->customer_name,
            'address'           => $request->address,
            'total_price'       => $request->total_price,
            'discount'          => $request->discount ?? $transaction->discount,
            'voucher'           => $request->voucher ?? $transaction->voucher,
            'noted'             => $request->noted ?? $transaction->noted,
            'status'            => $request->status,
        ]);

        TransactionDetail::findOrFail($id)->update([
            'transaction_id' => $request->transaction_id,
            'product_id'     => $request->product_id,
            $price           =  $request->total_price  - ($request->total_price * ($request->discount/100)) - $request->voucher,
            $total           =  $price  * $request->amount,
            'price'          => $total,
            'amount'         => $request->amount,
            'flag'           => $request->flag,
        ]);

        return response()->json(['message' => 'Data Update Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        TransactionDetail::destroy($id);
        Transaction::destroy($id);

        return response()->json(['message' => 'Data Deleted Successfully ']);
    }
}
