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
    public function sendnotification()
    {
        $token = "dAwIgmLZ6M8:APA91bF_E9a0vW9qw57dROZIHL7ddaMrfMSWHA1iJ0cNnJYnCa0SzyzVDjOm78zgBoTOiL3RSWfCfT9NKF3dEPHXnh9abUSpEkFBsREWM53HFnHJHj0SOyU_fYm1fKpVStlup-upAihT";
        $from = "AAAA1qJu9Zc:APA91bHdaN91pCfYTI8j1QQiqbQP68cGoGe1SnEBr4lYiOvHSJwdO5NBHQkkbQDQePoFmVr3ilGAHoIAQTNvkK3Gfw6l5MteB4hjWe3KSxef5egr-jtHyhcb-ZZ-UwXIV7Cc-lJMvZqh";
        $msg = array
              (
                'body'  => "Pengiriman Pemesanan",
                'title' => "Hi, dari mana",
                'receiver' => 'erw',
                'icon'  => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                );

        $headers = array
                (
                    'Authorization: key='.$from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'title' => 'Data Notification'
        ];
        return view('kasir.notification', $data);
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
