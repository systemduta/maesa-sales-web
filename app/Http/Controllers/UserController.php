<?php

namespace App\Http\Controllers;

use App\Company;
use App\Devision;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
    public function index()
    {

        $users = User::query()->byUser()->get();
        // $achieved = $users->transaction()->sum('total_price');
        // dd($achieved);
        $companies = Company::query()->when(auth()->user()->role_id != 1, function ($q) {
            return $q->where('id', auth()->user()->company_id);
        })->with('devisions')->get();
        $divisions = Devision::query()->when(auth()->user()->company_id, function ($q) {
            return $q->where('company_id', auth()->user()->company_id);
        })->get();
        return response()->view('users.index', [
            'users' => $users,
            'companies' => $companies,
            'divisions' => $divisions,
            'title' => 'User Data'
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|unique:users',
            'nik'      => 'required|string',
            'password' => 'required|string',
            'company_id' => auth()->user()->role_id == 1 ?'required|':''.'numeric'.auth()->user()->role_id != 1 ?'':'|nullable',
            'division_id' => 'required|numeric',
            'target_visit' => 'numeric|nullable',
            'target_low' => 'numeric|nullable',
            'target_middle' => 'numeric|nullable',
            'target_high' => 'numeric|nullable',
            'avatar'   => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->company_id = $request->company_id ?? auth()->user()->company_id;
        $user->devision_id = $request->division_id;
        $user->nik = $request->nik;
        $user->target_visit = $request->target_visit;
        $user->target_low = $request->target_low;
        $user->target_middle = $request->target_middle;
        $user->target_high = $request->target_high;
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('users', 'public');
        }
        $user->save();

        return response()->redirectToRoute('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'string|nullable',
            'email'    => 'unique:users|nullable',
            'nik'      => 'string|nullable',
            'password' => 'string|nullable',
            'division_id' => 'numeric|nullable',
            'target_visit' => 'numeric|nullable',
            'target_low' => 'numeric|nullable',
            'target_middle' => 'numeric|nullable',
            'target_high' => 'numeric|nullable',
            'avatar'   => 'mimes:jpeg,jpg,png,bmp,gif,svg|max:2048|nullable',
        ]);

        if ($request->name) $user->name = $request->name;
        if ($request->email) $user->email = $request->email;
        if ($request->password) $user->password = Hash::make($request->password);
        if ($request->nik) $user->nik = $request->nik;
        if ($request->division_id) $user->devision_id = $request->division_id;
        if ($request->target_visit) $user->target_visit = $request->target_visit;
        if ($request->target_low) $user->target_low = $request->target_low;
        if ($request->target_middle) $user->target_middle = $request->target_middle;
        if ($request->target_high) $user->target_high = $request->target_high;
        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('users', 'public');
        }
        $user->save();

        return response()->redirectToRoute('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function update_token(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
}
