<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Schedule;
use App\Models\Tour;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    private $tour;
    private $receipt;
    public function __construct()
    {
        $this->tour = new Tour();
        $this->receipt = new Receipt();
    }

    public function index(Request $request)
    {
        $idApp = session()->get('id_app');
        $toDay = Carbon::now()->format('Y-m-d');

        if (!$request->type || $request->type == 'inPrepare') {
            $listTour = DB::table('tour')
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
            ->where("tour.id_company", "=", $idApp)
            ->where("start_at", '<=', $toDay)
            ->where("end_at", '>=', $toDay)
            ->get();
        }

        if ($request->type == 'ended') {
            $listTour = DB::table('tour')
            ->where("tour.id_company", "=", $idApp)
            ->where("end_at", '<', $toDay)
            ->get();
        }

        return view('user.list_tour', [
            'listTour' => $listTour,
        ]);
    }

    public function create()
    {
        return view('user.create_tour',);
    }

    public function store(Request $request)
    {
        $arrLink = [
            'https://muongthanh.com/',
            'https://lasinfoniadelreyhotel.com/',
            'https://vinpearl.com/vi/hotels/vinpearl-resort-spa-ha-long',
            'https://flchotelsresorts.com/quan-the/flc-sam-son',
        ];
        $arrReview = ['4.5', '4.6', '4.7', '4.8', '4.9'];
        try {
            DB::beginTransaction();
            // dd($request->all(),$request['schedule_image_' . 1]);
            $idApp = session()->get('id_app');
            $image =  '/storage/' . $request->image->store('uploads_' . $idApp, 'public');
            $app = new Tour();
            $app->fill($request->only('name', 'type', 'description', 'departure_place', 'image', 'start_at', 'end_at', 'price', 'slot'));
            $app->slot_available = $request->slot;
            $app->id_company = $idApp;
            $app->reviews = $arrReview[rand(0,4)];
            $app->links = $arrLink[rand(0,3)];
            $app->image = $image;
            $app->save();

            for ($i = 1; $i <= $request->total; $i++) {
                $schedule = new Schedule();
                $schedule->day = $i;
                $schedule->id_tour = $app->id;
                $schedule->title = $request->get('schedule_title_' . $i);
                $schedule->description = $request->get('schedule_description_' . $i);
                $schedule->image = '/storage/' . $request['schedule_image_' . $i]->store('uploads_' . $idApp, 'public');
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

        $editable = ($get->slot == $get->slot_available) ? true : false;
        if ($get == null) {
            return view('user.404');
        }
        return view('user.edit_tour', [
            'tour' => $get,
            'schedules' => $schedule,
            'editable' => $editable,
        ]);
    }

    public function update($tour, Request $request)
    {
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
                'slot' => $request->slot,
                'slot_available' => $request->slot - $request->booked,
                'departure_place' => $request->departure_place,
            ]);
    
            $schedules = Schedule::where('id_tour', $tour)->pluck('id')->toArray();

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
    public function stat()
    {
        $idApp = session()->get('id_app');

        $get1 = DB::select("SELECT DATE_FORMAT(created_at,'%e-%m') 
        as ngay, SUM(total) as count  from receipt join tour on receipt.id_tour = tour.id where id_company = $idApp and status = 1 group by ngay;");

        $max_date = 30;
        $today = date('d');
        $get_day_last_month = $max_date - $today;
        $this_month = date('m');
        $last_month = date('m', strtotime(" - 1 month"));
        $last_month_date = date('Y-m-d', strtotime(" -1 month"));
        $max_day_last_month = (new DateTime($last_month_date))->format('t');
        $start_day_last_month = $max_day_last_month - $get_day_last_month;
        for ($i = $start_day_last_month; $i <= $max_day_last_month; $i++) {
            $key = $i . '-' . $last_month;
            $arr[$key] = 0;
        }

        for ($i = 1; $i <= $today; $i++) {
            $key = $i . '-' . $this_month;
            $arr[$key] = 0;
        }

        foreach ($get1 as $each) { 
            $arr[$each->ngay] = (int)$each->count;
        }

        $arrX = array_keys($arr);
        $arrY = array_values($arr);

        return view('user.chart', [
            'arrX' => $arrX,
            'arrY' => $arrY,
        ]);
    }

    public function ratio()
    {
        $idApp = session()->get('id_app');
        // dd($idApp);
        $inland = $this->tour->where('type' , 0)->where('id_company' , $idApp)->pluck('id')->toArray();
        $international = $this->tour->where('type' , 1)->where('id_company' , $idApp)->pluck('id')->toArray();

        // dd($inland, );
        $inlandTotal = (int) $this->receipt->getRatio($inland);
        $internationalTotal = (int) $this->receipt->getRatio($international);
        $inlandRatio = round($inlandTotal/($inlandTotal + $internationalTotal) * 100,2);
        $internationalRatio = 100-$inlandRatio;
        // dd($inlandRatio, $internationalRatio);

        return view('user.ratio', [
            'inlandRatio' => $inlandRatio,
            'internationalRatio' => $internationalRatio,
        ]);
    }
    public function destroy($tour)
    {
        Tour::where('id', $tour)->delete();

        session()->put('notification', true);
        return redirect()->route('admin');
    }
}
