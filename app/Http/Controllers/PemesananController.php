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

    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendnotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = 'AAAASiQ_6eE:APA91bFELTTv0YghgFpkMvlhrR00zwYTsrasAZJ4tyz8NAXInfKlF0YPOrxrqVqDjjuLSCkpSzOlKBTkFnn1wVFjHfBs_3yoUWsAAyNaTXErQ9p390H0xH6TqIGZmtMGk-R66T4xsrsW';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "status" => $request->status,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        dd($response);

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
