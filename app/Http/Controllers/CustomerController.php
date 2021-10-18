<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' =>'required|string',
            'address' => 'required|string'
        ]);

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->save();

        // return redirect()->route('customers.show', [$customer->id]);
        return redirect()->route('customers.index');
    }

    public function edit($id){
        $customer = Customer::find($id);
        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' =>'required|string',
            'address' => 'required|string'
        ]);

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->save();

        // return redirect()->route('customers.show', [$customer->id]);
        return redirect()->route('customers.index');
    }

    public function destroy($id){
        Customer::find($id)->delete();
        return redirect()->route('customers.index');
    }
}
