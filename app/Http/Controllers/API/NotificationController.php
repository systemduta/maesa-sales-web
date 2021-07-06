<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function listNotification(Request $request)
    {
        $sort         = $request->filled('sort') && ($request->sort=='asc')?$request->sort:null;
        $notification  = Notification::query();

        $notification->when($sort == 'asc', function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        })->when(auth()->user()->id, function($q){
            return $q->where('to_user',auth()->user()->id);
        });

        $notification   = $notification->get();

        return response()->json(['Notification' => $notification]);
    }
}
