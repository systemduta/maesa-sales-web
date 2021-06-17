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
    public function index(Request $request)
    {
        $sort         = $request->filled('sort') && ($request->sort=='asc')?$request->sort:null;
        $transaction  = Transaction::query();

        $transaction->when($sort == 'asc', function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        });

        $transaction   = $transaction->get();
        $transacdetail = TransactionDetail::all();

        return response()->json(['transaction' => $transaction, $transacdetail]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required|string',
            'address'           => 'required',
            'total_price'       => 'required',
        ]);

        $user = auth()->user();
        $invoice_number = '#1234';
        $transaction = Transaction::create([
            'user_id'           => $user->id ?? 1,
            'company_id'        => $user->company_id ?? 1,
            'invoice_number'    => $invoice_number,
            'customer_name'     => $request->customer_name,
            'address'           => $request->address,
            'total_price'       => $request->total_price,
            'noted'             => $request->noted,
            'status'            => "order",
//            'discount'          => $request->discount,
//            'voucher'           => $request->voucher,
        ]);

        $new_products = [];
        foreach ($request->products as $product) {
                array_push($new_products,[
                    'transaction_id' => $transaction->getKey(),
                    'product_id'     => $product['product_id'],
                    'amount'         => $product['amount'],
                    'price'          => $product['price'],
                ]);
        }

        TransactionDetail::insert($new_products);

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
        //
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

        return response()->json(['transaction' => $transdetail]);
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

        // $request->old($key = null, $default = null);

        // dd($request->hasFile('bukti'), $request->file('bukti'));

        $request->validate([
            'bukti' => 'required|image|max:2000',
        ]);

        $bukti = Transaction::where('id',$id)->first();

        if ($request->hasFile('bukti')) {
            //Hapus gambar Lama
            if ($bukti->bukti) {
                unlink(public_path('bukti'). '/' .$bukti->bukti);
            }
            $filenameWithExt = $request->file('bukti')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('bukti')->getClientOriginalExtension();
            $fileimgSimpan = $filename.'_'.time().'.'.$extension;
            $path = $request->file('bukti')->move(public_path('bukti'),$fileimgSimpan);
        }else{
            $fileimgSimpan = $bukti->bukti;
        }

        Transaction::findOrFail($id)->update([
            'bukti'            => $fileimgSimpan,
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
