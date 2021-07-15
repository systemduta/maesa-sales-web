<?php

namespace App\Http\Controllers;

use App\NotificationHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\TransactionDetail;
use App\Company;
use Auth;

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
        $data = [
            'title' => 'Data Transaction',
        ];

        $sort         = $request->filled('sort') && ($request->sort=='desc')?$request->sort:null;
        $transaction  = Transaction::query();

        $transaction->when(auth()->user()->company_id, function($q){
            return $q->where('company_id',auth()->user()->company_id);
        })->when($sort, function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        });

        $transaction = $transaction->get();

        return view('kasir.transaction',compact('transaction'), $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
            'title' => 'Detail Data Pemesanan'
        ];

        $transaction = Transaction::query()->with(['transaction_details'])->findOrFail($id);

        return view('kasir.detail',compact('transaction'),$data);
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
        $transaction         = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        if ($transaction->user->device_token) {
            $recipients = [$transaction->user->device_token];
            $title ='Hai, update status tagihan!';
            $body='Tagihan atas nama pelanggan '.$transaction->customer_name.' telah berubah status menjadi '.$transaction->status;

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

//        save history notification
            $notification_history = new NotificationHistory;
            $notification_history->transaction_id = $transaction->getKey();
            $notification_history->title = $title;
            $notification_history->body = $body;
            $notification_history->from_user = auth()->user()->id;
            $notification_history->to_user = $transaction->user->id;
            $notification_history->save();
        }

        return redirect('transactions')->with('status','Status Berhasil di Update');
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
