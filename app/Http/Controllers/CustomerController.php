<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'address'   => 'required',
        ]);

        Customer::create([
            'name'      => $request->name,
            'address'   => $request->address,
        ]);

        return redirect('customer')->with('status','Data Berhasil Di Simpan !!');
    }

    public function edit($id)
    {

        $customers = Customer::where('id',$id)->first();
        return view('customers.edit',compact('customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'address'   => 'required',
        ]);

        Customer::findOrFail($id)->update([
            'name'      => $request->name,
            'address'   => $request->address,
        ]);
        return redirect('customer')->with('status','Data Berhasil Di Update !!');
    }

    public function destroy($id)
    {

        Customer::destroy($id);
        return redirect('customer')->with('status', 'Data Berhasil Di Delete');
    }
}
