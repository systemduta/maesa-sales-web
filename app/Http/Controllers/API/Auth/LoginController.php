<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public $successStatus = 200;


    public function login(Request $request)
    {
        $request->validate(
        [
            'email'         => 'required|email',
            'password'      => 'required',
        ]);


        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            ])){
                $user = Auth::user();
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['data'] = $user;
                return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Terjadi Kesalahan'], 401);
        }
    }
}
