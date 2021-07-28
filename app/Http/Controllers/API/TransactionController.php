<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use App\NotificationHistory;
use App\User;
use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;


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
        $order_by_latest = ($request->filled('sort') && $request->sort == 'desc') ? 'desc' : null;
        $transaction  = Transaction::query()
            ->byUser()
            ->with(['transaction_details'])->when($order_by_latest, function ($query, $order_by_latest){
            return $query->orderBy('created_at', $order_by_latest);
        })->get();

        return response()->json(['transaction' => $transaction]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'address'       => 'required|string',
            'total_price'   => 'required|numeric',
            'products'      => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();
            $company_code = $user->company_id ? $user->company->code : 'MH';
            $latest_trx = Transaction::query()
                ->where('company_id', $user->company_id ?? 1)
                ->latest()->first();
            $numb = str_pad(($latest_trx ? ($latest_trx->getKey() + 1) : 1), 4, '0', STR_PAD_LEFT);
            $invoice_number = '#'.$company_code.$numb;

            $transaction = Transaction::create([
                'user_id'           => $user->id ?? 1,
                'company_id'        => $user->company_id ?? 1,
                'invoice_number'    => $invoice_number,
                'customer_name'     => $request->customer_name,
                'address'           => $request->address,
                'total_price'       => $request->total_price,
                'noted'             => $request->noted,
                'status'            => "order"
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

            $customers          = new Customer;
            $customers->user_id = $user->id;
            $customers->name    = $request->customer_name;
            $customers->address = $request->address;
            $customers->save();

            $cashier = User::query()->where('company_id', '=', ($user->company_id ?? 1))
                ->whereHas('role', function ($q) {
                    return $q->where('name', 'cashier');
                })->first();

            if ($cashier) {
                $recipients = [$cashier->device_token];
                $title ='Hai, ada transaksi baru ini!';
                $body='Sales atas nama '.$user->name.' telah melakukan transaksi dengan nomor '.$invoice_number;

                $res = fcm()->to($recipients)
                    ->timeToLive(0)
                    ->priority('normal')
                    ->data([
                        'id' => $transaction->getKey(),
                        'title' => $title,
                        'body' => $body,
                    ])
                    ->notification([
                        'title' => $title,
                        'body' => $body,
                    ])->send();

                $notification_history = new NotificationHistory;
                $notification_history->transaction_id = $transaction->getKey();
                $notification_history->title = $title;
                $notification_history->body = $body;
                $notification_history->from_user = $user->id;
                $notification_history->to_user = $cashier->getKey();
                $notification_history->save();
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return response()->json(['message' => 'Transaction data added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('id', $id)->with(['transaction_details'])->first();

        return response()->json(['transaction' => $transaction]);
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
