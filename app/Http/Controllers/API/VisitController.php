<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Visit;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VisitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $auth = Auth::user();
        $visit_count = Visit::query()
            ->where('user_id', $auth->id)
            ->whereMonth('visited_at', Carbon::now()->format('m'))
            ->get()->count();
        $visits = Visit::query()
            ->where('user_id', $auth->id)
            ->whereMonth('visited_at', Carbon::now()->format('m'))
            ->orderByDesc('id')->paginate();

        return response()->json([
            'current_page' => $visits->currentPage(),
            'data' => $visits->items(),
            'first_page_url' => null,
            'from' => $visits->currentPage(),
            'last_page' => $visits->lastPage(),
            'last_page_url' => null,
            'next_page_url' => $visits->nextPageUrl(),
            'path' => $visits->path(),
            'per_page' => $visits->perPage(),
            'prev_page_url' => $visits->previousPageUrl(),
            'to' => null,
            'total' => $visits->total(),
            'visit_performance' => [
                'achieved'=> $visit_count,
                'target'=> $auth->target_visit ?? 0
            ]
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'address'   => 'required|string',
            'phone'     => 'required|string',
            'product'     => 'string|nullable',
            'status'     => 'string|nullable',
            'result'    => 'required|string',
            'photo'     => 'nullable',

        ]);

        try {
            $auth = Auth::user();
            $photo = null;
            if ($request->hasFile('photo')) {
                $photo = $request
                    ->file('photo')
                    ->storeAs('visits', $auth->name.'_'.rand(100000,999999).'.'.$request->photo->getClientOriginalExtension(), 'public');
            }

            $visit = new Visit();
            $visit->user_id = $auth->id;
            $visit->name = $request->name;
            $visit->address = $request->address;
            $visit->phone = $request->phone;
            $visit->product = $request->product;
            $visit->status = $request->status;
            $visit->result = $request->result;
            $visit->visited_at = date('Y-m-d H:i:s');
            $visit->photo = $photo;
            $visit->save();

            return response()->json([
                'data' => $visit,
                'message' => "Data created successfully"
            ], 200);

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new HttpException(500, $exception->getMessage(), $exception);
        }
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
