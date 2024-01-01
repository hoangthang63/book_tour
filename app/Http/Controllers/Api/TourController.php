<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TourController extends Controller
{
    private $tour;
    public function __construct()
    {
        $this->tour = new Tour();
    }
    public function index(Request $request)
    {
        $toDay = Carbon::now()->format('Y-m-d');
        $query = Tour::where('name','like','%'.$request->get('key_word').'%');
        $list = '';

        if ($request->get('type') == 'in') {
            $list = $query->where('type',0);
        }

        if($request->get('start_at')){
            $list = $query->whereDate("start_at", '>=', Carbon::parse($request->get('start_at'))->format('Y-m-d'));
        }else{
            $list = $query->where("start_at", '>', $toDay);
        }

        if($request->get('end_at')){
            $list = $query->whereDate("end_at", '<=', Carbon::parse($request->get('end_at'))->format('Y-m-d'));
        }

        if ($request->get('type') == 'out') {
            $list = $query->where('type',1);
        }

        if ($request->get('price') == 'asc') {
            $list = $query->orderBy("price", "ASC");
        }

        if ($request->get('price') == 'desc') {
            $list = $query->orderBy("price", "desc");
        }

        if ($request->get('departure_place')) {
            $list = $query->where('departure_place', 'like','%'. $request->get('departure_place') .'%');
        }

        $list = $query->get();

        return response()->json([
            'data' => $list,
            'status' => 200
        ]
        );
    }

    public function detail(Request $request)
    {
        //schedules:day,title,image
        $query = $this->tour->with('schedules')->where('id', $request->id)->first();
        return response()->json([
            'data' => $query,
            'status' => 200
        ]
        );
    }
}
