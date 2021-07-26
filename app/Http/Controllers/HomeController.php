<?php

namespace App\Http\Controllers;
use App\Product;

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
        $products = Product::query();
        $products = $products->orderBy('updated_at', 'desc')->get();
        return view('home', ['title' => 'Dashboard','products' => $products]);
    }
}
