<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\NotificationHistory;

class NotificationHistoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function listNotification(Request $request)
    {
        $sort         = $request->filled('sort') && ($request->sort=='asc')?$request->sort:null;
        $notification  = NotificationHistory::query();

        $notification->when($sort == 'asc', function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        })->when(auth()->user(), function($q){
            return $q->where('to_user',auth()->user()->id);
        });

        $notification   = $notification->get();
        return view('notifications.index', ['notification' => $notification]);
    }

}
