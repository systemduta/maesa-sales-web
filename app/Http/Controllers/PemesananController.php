<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
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

        // dd(auth()->user()->company_id);
        $sort         = $request->filled('sort') && ($request->sort=='asc')?$request->sort:null;
        $transaction  = Transaction::query();

        $transaction->when($sort == 'asc', function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        })->when(auth()->user()->company_id, function($q){
            return $q->where('company_id',auth()->user()->company_id);
        });

        $transaction   = $transaction->get();

        return view('kasir.pemesanan',compact('transaction'), $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $data = [
            'title' => 'Detail Data Pemesanan'
        ];

        $pemesanan = Transaction::where('id',$id)->get();

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
        //
    }
}
