<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\TransactionDetail;
use App\Company;
use Auth;

class PemesananController extends Controller
{

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

        return view('kasir.pemesanan',compact('transaction'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendnotification(Request $request)
    {
        $recipients = [
            'clKMv.......',
            'GxQQW.......',
        ];

        fcm()->to($recipients)
            ->timeToLive(0)
            ->priority('normal')
            ->notification([
                'title' => 'Hai, ada update transaksi!',
                'body' => 'Status Transaksi Invoice menjadi di Bayar',
            ])
            ->data([
                'title' => 'Hai, ada update transaksi!',
                'body' => 'Status Transaksi Invoice menjadi di Bayar',
            ])
            ->send();

        return redirect('pemesanan')->with('status','Status Berhasil di Update');

        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


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

        $pemesanan = Transaction::query()->with(['transaction_details'])->findOrFail($id);

        return view('kasir.detail',compact('pemesanan'),$data);
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

        return redirect('pemesanan')->with('status','Status Berhasil di Update');
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
        return redirect('pemesanan')->with('status','Transaksi berhasil di hapus');
    }
}
