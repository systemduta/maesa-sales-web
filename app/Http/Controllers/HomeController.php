<?php

namespace App\Http\Controllers;
use App\Product;
use App\User;
use App\Transaction;

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
        $transactions = Transaction::query()->byCompany();
        $products = Product::query()->byCompany();
        $products = $products->orderBy('created_at', 'desc')->get();
        $users = User::query();
        $users = $users->when(auth()->user()->company_id, function ($query) {
                return $query->where('company_id', auth()->user()->company_id);
            })->where('role_id',2)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('home', ['title' => 'Dashboard',
                            'transactions' => $transactions,
                            'products' => $products, 
                            'users' => $users]);
    }
}
