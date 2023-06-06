<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::where('ten','like','%'.$request->get('keyword').'%');
        $list = '';

        if ($request->get('type') == 'in') {
            $list = $query->where('loai',0);
        }

        if ($request->get('type') == 'out') {
            $list = $query->where('loai',1);
        }

        if ($request->get('price_sort') == 'asc') {
            $list = $query->orderBy("gia", "ASC");
        }

        if ($request->get('price_sort') == 'desc') {
            $list = $query->orderBy("gia", "desc");
        }

        $list = $query->get();

        return response()->json([
            'data' => $list,
            'status' => 200
        ]
        );
    }
}
