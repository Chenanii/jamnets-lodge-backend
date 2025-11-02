<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBananaFarmRequest;
use App\Models\BananaFarm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BananaFarmController extends Controller
{
    public function index()
    {
        return response()->json(BananaFarm::orderBy('recorded_at','desc')->paginate(20));
    }


    public function store(StoreBananaFarmRequest $request)
    {
        $farm = BananaFarm::create($request->validated());
        return response()->json($farm, 201);
    }


    public function show(BananaFarm $bananaFarm)
    {
        return response()->json($bananaFarm);
    }


    public function update(StoreBananaFarmRequest $request, BananaFarm $bananaFarm)
    {
        $bananaFarm->update($request->validated());
        return response()->json($bananaFarm);
    }


    public function destroy(BananaFarm $bananaFarm)
    {
        $bananaFarm->delete();
        return response()->json(['message' => 'Deleted']);
    }


    // summary totals
    public function summary()
    {
        $totals = BananaFarm::select(
        DB::raw('SUM(total_trees) as total_trees'),
        DB::raw('SUM(fruiting_trees) as fruiting_trees'),
        DB::raw('SUM(sick_trees) as sick_trees'),
        DB::raw('SUM(dead_trees) as dead_trees')
        )->first();


    return response()->json($totals);
    }


    // monthly trends (last N months)
    public function trends(Request $request)
    {
        $months = (int) $request->get('months', 12);


        $data = BananaFarm::select(
        DB::raw("DATE_FORMAT(recorded_at, '%Y-%m') as month"),
        DB::raw('SUM(total_trees) as total'),
        DB::raw('SUM(fruiting_trees) as fruiting'),
        DB::raw('SUM(sick_trees) as sick'),
        DB::raw('SUM(dead_trees) as dead')
        )
        ->whereNotNull('recorded_at')
        ->groupBy('month')
        ->orderBy('month','asc')
        ->limit($months)
        ->get();


    return response()->json($data);
    }
}