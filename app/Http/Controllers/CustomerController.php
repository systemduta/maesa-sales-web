<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    public function index(){
        $customers = Customer::all();
        return view('customers.index', ['customers' => $customers]);
    }

    public function create(){
        return view('customers.create');
    }

    public function store(Request $request){
        return 'haha';
    }

    public function edit($id){
        return 'haha';
    }

    public function update(Request $request, $id){
        return 'haha';
    }

    public function destroy($id){
        return 'haha';
    }
}
