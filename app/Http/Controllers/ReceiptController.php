<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function payment(Request $request)
    {
        $tour = Tour::where('id', $request->id_tour)->first();
        if ($tour->slot_available >= $request->amount) {
            DB::table('tour')
            ->where('id', $request->id_tour)
            ->update([
                'slot_available' => $tour->slot_available -  $request->amount,
            ]);
        }else{
            return response()->json([
                'status_code' => 400,
                'message' => 'Not enough slot',
            ]);
        }
        $app = new Receipt();
        $app->id_tour = $request->id_tour;
        $app->id_customer = $request->id;
        $app->amount = $request->amount;
        $app->save();

        return response()->json([
            'status_code' => 200,
            'message' => 'success',
        ]);


    }
    public function purchasedOrder(Request $request)
    {
        $data = Receipt::Where('id_customer', $request->id)
        ->join('tour', 'tour.id', '=', 'receipt.id_tour')
        ->get();
        return response()->json([
            'status_code' => 200,
            'data' => $data,
            'message' => 'success',
        ]);


    }
}
