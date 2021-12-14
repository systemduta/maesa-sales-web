<?php

namespace App\Http\Controllers;

use App\Customer;
use App\NotificationHistory;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\TransactionDetail;
use App\Company;
use Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('invoice');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_id = auth()->user()->company_id ?? 1;
        $transaction  = Transaction::query()->when($company_id, function($q) use ($company_id){
            return $q->where('company_id',$company_id);
        })->orderBy('created_at', 'desc')->get();
        $users = User::query()->where('company_id', $company_id)->get();
        $products = Product::query()->where('company_id', $company_id)->get();

        return response()->view('transactions.index', [
            'transaction'   => $transaction,
            'users'         => $users,
            'products'      => $products,
            'title'         => 'Transaction Data'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::query()->with(['transaction_details'])->findOrFail($id);

        return response()->view('transactions.show',[
            'transaction' => $transaction,
            'title'        => 'Transaction Detail'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'exists:users,id|nullable',
            'customer_name' => 'required|string',
            'address'       => 'required|string',
            'total_price'   => 'required|string',
            // 'products'      => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $user = ($request->has('user_id')) ? User::query()->findOrFail($request->user_id) : auth()->user();
            $company_code = $user->company_id ? $user->company->code : 'MH';
            $latest_trx = Transaction::query()
                ->where('company_id', $user->company_id ?? 1)
                ->latest()->first();
            $numb = str_pad(($latest_trx ? ($latest_trx->getKey() + 1) : 1), 4, '0', STR_PAD_LEFT);
            $invoice_number = '#'.$company_code.$numb;

            Transaction::create([
                'user_id'           => $user->id ?? 1,
                'company_id'        => $user->company_id ?? 1,
                'invoice_number'    => $invoice_number,
                'customer_name'     => $request->customer_name,
                'address'           => $request->address,
                'total_price'       => $request->total_price,
                'noted'             => $request->noted,
                'status'            => "Order",
            ]);

            // $new_products = [];
            // foreach ($request->products as $product) {
            //     array_push($new_products,[
            //         'transaction_id' => $transaction->getKey(),
            //         'product_id'     => $product['product_id'],
            //         'amount'         => $product['amount'],
            //         'price'          => $product['price'],
            //     ]);
            // }
            // TransactionDetail::insert($new_products);

            $customers          = new Customer;
            $customers->user_id = $user->id;
            $customers->name    = $request->customer_name;
            $customers->address = $request->address;
            $customers->save();

//            $cashier = User::query()->where('company_id', '=', ($user->company_id ?? 1))
//                ->whereHas('role', function ($q) {
//                    return $q->where('name', 'cashier');
//                })->first();
//
//            if ($cashier) {
//                $recipients = [$cashier->device_token];
//                $title ='Hai, ada transaksi baru ini!';
//                $body='Sales atas nama '.$user->name.' telah melakukan transaksi dengan nomor '.$invoice_number;
//
//                $res = fcm()->to($recipients)
//                    ->timeToLive(0)
//                    ->priority('normal')
//                    ->data([
//                        'id' => $transaction->getKey(),
//                        'title' => $title,
//                        'body' => $body,
//                    ])
//                    ->notification([
//                        'title' => $title,
//                        'body' => $body,
//                    ])->send();
//
//                $notification_history = new NotificationHistory;
//                $notification_history->transaction_id = $transaction->getKey();
//                $notification_history->title = $title;
//                $notification_history->body = $body;
//                $notification_history->from_user = $user->id;
//                $notification_history->to_user = $cashier->getKey();
//                $notification_history->save();
//            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new HttpException(500, $exception->getMessage(), $exception);
        }

        return response()->redirectToRoute('transactions.index');
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
            // 'user_id' => 'exists:users,id|nullable',
            'customer_name' => 'required|string',
            'address'       => 'required|string',
            'total_price'   => 'required|string',
            'noted'         => 'required|string',
            // 'products'      => 'required|array',
        ]);

        Transaction::findOrFail($id)->update([
            'customer_name'     => $request->customer_name,
            'address'           => $request->address,
            'total_price'       => $request->total_price,
            'noted'             => $request->noted,
        ]);
//         $transaction         = Transaction::findOrFail($id);
//         $transaction->status = $request->status;
//         $transaction->save();

//         if ($transaction->user->device_token) {
//             $recipients = [$transaction->user->device_token];
//             $title ='Hai, update status tagihan!';
//             $body='Tagihan atas nama pelanggan '.$transaction->customer_name.' telah berubah status menjadi '.$transaction->status;

//             $res = fcm()->to($recipients)
//                 ->timeToLive(0)
//                 ->priority('normal')
//                 ->data([
//                     'id' => $transaction->getKey(),
//                     'title' => $title,
//                     'body' => $body,
//                 ])
//                 ->notification([
//                     'title' => $title,
//                     'body' => $body,
//                 ])->send();

// //        save history notification
//             $notification_history = new NotificationHistory;
//             $notification_history->transaction_id = $transaction->getKey();
//             $notification_history->title = $title;
//             $notification_history->body = $body;
//             $notification_history->from_user = auth()->user()->id;
//             $notification_history->to_user = $transaction->user->id;
//             $notification_history->save();
//         }

        return redirect('transactions')->with('status','Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::find($id)->delete();
        return redirect('transactions')->with('status','Transaksi berhasil di hapus');
    }

    public function invoice($id)
    {
        $transaction = Transaction::query()->findOrFail($id);
        return view('invoice', ['transaction' => $transaction]);
    }
}
