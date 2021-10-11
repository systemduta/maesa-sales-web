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
            'password'      => 'required|string',
            'device_token'  => 'string|nullable',
        ]);


        if(Auth::attempt([
            'email'         => $request->email,
            'password'      => $request->password,
            ])){

                $auth = Auth::user();

                //Save Token
                $user = User::query()->findOrFail($auth->id);
                if ($request->device_token){
                    $user->device_token = $request->device_token;
                    $user->save();
                }
                $success['token'] =  $auth->createToken('MyApp')->accessToken;
                $success['data'] = $user;
                return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Terjadi Kesalahan'], 401);
        }
    }

    public function update_token(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
}
