<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function scan(Request $request)
    {
        // dd($request->all());
        $ticket = Ticket::where('ticket_code', $request->ticket_code)
        // ->where('id_tour', $request->id_tour)
        ->first();
        if (empty($ticket)) {
            return response()->json([
                'status_code' => 422,
                'status' => 3,
                'message' => 'fail',
            ]);
        }
        if ($ticket->status == 1) {
            DB::table('tickets')
            ->where('id', $ticket->id)
            ->update([
                'status' => 2,
                'scanned_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'status_code' => 200,
                'status' => 1,
                'message' => 'success',
            ]);
        }
        if ($ticket->status == 2) {
            return response()->json([
                'status_code' => 200,
                'status' => 2,
                'message' => 'fail',
            ]);
        }

            return response()->json([
                'status_code' => 422,
                'status' => 3,
                'message' => 'fail',
            ]);
    }
    public function listTour(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $tours = Tour::where('start_at', $today)->get();
        return response()->json([
            'status_code' => 200,
            'data' => $tours,
            'message' => 'success',
        ]);
    }
}
