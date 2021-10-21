<?php

namespace App\Http\Controllers;

use App\User;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
           'period' => 'string|nullable'
        ]);
        $period = $request->period;
        $visits = Visit::query()->byCompany()->when($period && $period=='day', function (Builder $query) {
            return $query->whereDate('visited_at', Carbon::now());
        })->when($period && $period=='week', function (Builder $query) {
            return $query->whereBetween('visited_at', [Carbon::now()->subWeek(), Carbon::now()]);
        })->when($period && $period=='month', function (Builder $query) {
            return $query->whereBetween('visited_at', [Carbon::now()->subMonth(), Carbon::now()]);
        })->orderByDesc('id')->get();

        return response()->view('visits.index', [
            'visits' => $visits,
            'title' => 'Visit Data'
        ]);
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
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        //
    }

    public function daily_visit_notification()
    {
        $recipients = User::query()->whereNotNull('device_token')->pluck('device_token');
        $title ='Selamat Siang Sales Budiman';
        $body='Lihat pencapaian visit hari ini dengan klik notifikasi berikut';

        return fcm()->to($recipients)
            ->timeToLive(0)
            ->priority('normal')
            ->notification([
                'title' => $title,
                'body' => $body,
            ])
//            ->data([
//                'id' => $transaction->getKey(),
//                'title' => $title,
//                'body' => $body,
//            ])
            ->send();
    }
}
