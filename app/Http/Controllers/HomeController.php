<?php

namespace App\Http\Controllers;
use App\Product;
use App\User;
use App\Transaction;

use App\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_cashier');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = Transaction::query()->byCompany()->whereMonth('created_at', Carbon::now()->format('m'));
        $visits = Visit::query()->byCompany()->whereMonth('visited_at', Carbon::now()->format('m'));
        $products = Product::query()->byCompany()->orderBy('created_at', 'desc')->get();
        $users = User::query()->byUser()->where('role_id',2)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('home', [
            'title' => 'Dashboard',
            'transactions' => $transactions,
            'visits' => $visits,
            'products' => $products,
            'users' => $users
        ]);
    }
}
