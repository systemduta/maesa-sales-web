<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\TransactionDetail;
use App\Company;
use Auth;

class TransactionController extends Controller
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

        return redirect('transaction')->with('status','Status Berhasil di Update');
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
        return redirect('transaction')->with('status','Transaksi berhasil di hapus');
    }
}
