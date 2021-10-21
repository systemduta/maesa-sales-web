<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\NotificationHistory;

class NotificationHistoryController extends Controller
{
     public function __construct()
     {
         $this->middleware('auth');
     }

    public function listNotification(Request $request)
    {
        $sort         = $request->filled('sort') && ($request->sort=='asc')?'asc':null;
        $notification  = NotificationHistory::query()->when($sort == 'asc', function ($q) use ($sort) {
            return $q->orderBy('created_at', $sort);
        },function ($q) {
            return $q->orderBy('created_at', 'desc');
        })->when(auth()->user(), function($q){
            return $q->where('to_user',auth()->user()->id)->orWhere('from_user',auth()->user()->id);
        })->get();
        $users = User::query()->ByUser()->where('role_id', 2)->get();
        return view('notifications.index', [
            'notification' => $notification,
            'users' => $users,
            'title'=>'List Notification'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required|exists:users,id',
            'body'        => 'required|string|max:255',
        ]);

        $user = User::query()->findOrFail($request->destination);
        if ($user->device_token) {
            $recipients = [$user->device_token];
            $title ='Hai kak '.$user->name.', ada pesan baru untukmu';
            $body=$request->body;

            $res = fcm()->to($recipients)
                ->timeToLive(0)
                ->priority('normal')
                ->data([
                    'title' => $title,
                    'body' => $body,
                ])
                ->notification([
                    'title' => $title,
                    'body' => $body,
                ])->send();

            $notification_history = new NotificationHistory;
            $notification_history->transaction_id = null;
            $notification_history->title = $title;
            $notification_history->body = $body;
            $notification_history->from_user = auth()->user()->id;
            $notification_history->to_user = $user->id;
            $notification_history->save();

            return response()->redirectToRoute('notifications.list');
        }
        return response()->redirectToRoute('notifications.list')->withErrors('device token not found');

    }
}
