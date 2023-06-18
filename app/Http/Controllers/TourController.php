<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Tour;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    private $tour;
    public function __construct()
    {
        $this->tour = new Tour();
    }

    public function index(Request $request)
    {
        $idApp = session()->get('id_app');
        $toDay = Carbon::now()->format('Y-m-d');

        if (!$request->type || $request->type == 'inPrepare') {
            $listTour = DB::table('tour')
            // ->select('name')
            ->where("tour.id_company", "=", $idApp)
            ->where("start_at", '>', $toDay)
            ->get();
        }

        if ($request->type == 'all') {
            $listTour = DB::table('tour')
            // ->select('name')
            ->where("tour.id_company", "=", $idApp)
            ->orderBy('id', 'desc')
            // ->where("start_at", '>', $toDay)
            // ->latest()
            ->get();
        }

        if ($request->type == 'inProgress') {
            $listTour = DB::table('tour')
            // ->select('name')
            ->where("tour.id_company", "=", $idApp)
            ->where("start_at", '<=', $toDay)
            ->where("end_at", '>=', $toDay)
            ->get();
        }

        if ($request->type == 'ended') {
            $listTour = DB::table('tour')
            // ->select('name')
            ->where("tour.id_company", "=", $idApp)
            ->where("end_at", '<', $toDay)
            ->get();
        }
        // $listApp = $this->tour->getAllApp();
        // $allApp = $this->tour->getAll();

        // dd($listTour->toSql());
        return view('user.list_tour', [
            'listTour' => $listTour,
            // 'all_apps' => $allApp,
        ]);
    }

    public function create()
    {
        return view('user.create_tour',);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            $idApp = session()->get('id_app');
            // $image =  '/storage/' . $request->logo->store('uploads_' . $idApp, 'public');
            $app = new Tour();
            $app->fill($request->only('name', 'type', 'description', 'departure_place', 'image', 'start_at', 'end_at', 'price', 'slot'));
            $app->slot_available = $request->slot;
            $app->id_company = $idApp;
            // $app->logo = $image;
            $app->save();

            for ($i = 1; $i <= $request->total; $i++) {
                $schedule = new Schedule();
                $schedule->day = $i;
                $schedule->id_tour = $app->id;
                $schedule->title = $request->get('schedule_title_' . $i);
                $schedule->description = $request->get('schedule_description_' . $i);
                $schedule->image = $request->get('schedule_image_' . $i);
                $schedule->save();
            }
            DB::commit();

            session()->put('notification', true);
            return redirect()->route('admin');
        } catch (\Throwable $th) {
            //throw $th;
            logger($th);
            dd("error");
            DB::rollBack();
        }
    }

    public function edit($tour)
    {
        $get = Tour::where('id', $tour)->first();
        $schedule = Schedule::where('id_tour', $tour)->get();
        $schedule->total = date_diff(new DateTime($get->start_at), new DateTime($get->end_at))->format("%a");

        if ($get == null) {
            return view('user.404');
        }
        return view('user.edit_tour', [
            'tour' => $get,
            'schedules' => $schedule,
        ]);
    }

    public function update($tour, Request $request)
    {
        // $image =  '/storage/' . $request->logo->store('uploads_' . $app, 'public');
        // $this->tour->updateApp($app, $request->name, $image);
        try {
            DB::beginTransaction();

            DB::table('tour')
            ->where('id', $tour)
            ->update([
                'name' => $request->name,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'price' => $request->price,
                'type' => $request->type,
                'description' => $request->description,
                // 'image' => $request->name,
                'slot' => $request->slot,
                'slot_available' => $request->slot - $request->booked,
                'departure_place' => $request->departure_place,
            ]);
    
            $schedules = Schedule::where('id_tour', $tour)->pluck('id')->toArray();
            // dd($tour);
            for ($i=1; $i <= $request->total; $i++) { 
                Schedule::updateOrCreate(
                    [
                       'id'   => $schedules[$i-1] ?? -1 ,
                    ],
                    [
                       'id_tour' => $tour,
                       'day'     => $i,
                       'title' => $request->get('schedule_title_' . $i),
                       'description'    => $request->get('schedule_description_' . $i),
                    //    'image'   => $request->get('schedule_image_' . $i),
                    ],
                );
            }
            DB::commit();

            session()->put('notification', true);
            return redirect()->route('admin');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd("error");
        }

    }

    public function destroy($app)
    {

        session()->put('notification', true);
        return redirect()->route('admin');
    }
}
