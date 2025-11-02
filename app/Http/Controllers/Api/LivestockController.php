<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLivestockRequest;
use App\Models\Livestock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LivestockController extends Controller
{
    public function index()
    {
        return response()->json(Livestock::orderBy('recorded_at','desc')->paginate(20));
    }


    public function store(StoreLivestockRequest $request)
    {
        $data = $request->validated();
        $livestock = Livestock::create($data);
        return response()->json($livestock, 201);
    }


    public function show(Livestock $livestock)
    {
        return response()->json($livestock);
    }


    public function update(StoreLivestockRequest $request, Livestock $livestock)
    {
        $livestock->update($request->validated());
        return response()->json($livestock);
    }


    public function destroy(Livestock $livestock)
    {
        $livestock->delete();
        return response()->json(['message' => 'Deleted']);
    }




    // summary totals
    public function summary()
    {
        $totals = Livestock::select(
        DB::raw('SUM(total_count) as total_animals'),
        DB::raw('SUM(alive_count) as alive'),
        DB::raw('SUM(sick_count) as sick'),
        DB::raw('SUM(dead_count) as dead')
    )->first();


    return response()->json($totals);
    }


    public function trends(Request $request)
    {
        $months = (int) $request->get('months', 12);


        $data = Livestock::select(
        DB::raw("DATE_FORMAT(recorded_at, '%Y-%m') as month"),
        DB::raw('SUM(total_count) as total'),
        DB::raw('SUM(alive_count) as alive'),
        DB::raw('SUM(sick_count) as sick'),
        DB::raw('SUM(dead_count) as dead')
    )
    ->whereNotNull('recorded_at')
    ->groupBy('month')
    ->orderBy('month','asc')
    ->limit($months)
    ->get();


    return response()->json($data);
    }
}