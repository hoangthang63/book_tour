<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Coupon;
use App\Models\CouponWinningLists;
use App\Models\ListApp;
use App\Models\OrdinalImages;
use App\Models\ScanHistories;
use App\Models\StampCards;
use App\Models\Store;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListAppController extends Controller
{
    private $listApps;
    public function __construct()
    {
        $this->listApps = new ListApp();
    }

    public function index()
    {
        $listApp = $this->listApps->getAllApp();
        $allApp = $this->listApps->getAll();

        return view('layout.index', [
            'list_apps' => $listApp,
            'all_apps' => $allApp,
        ]);
    }

    public function chooseApp(Request $request)
    {
        $name = $this->listApps->getAppById($request->id_app);
        session()->put('id_app', $request->id_app);
        session()->put('name_app', $name->name);
        return response()->json([
            'status_code' => 200,
            'message' => 'thành công',
            'name' => $name->name,
        ]);
    }
    public function store(Request $request)
    {
        $idApp = session()->get('id_app');
        $image =  '/storage/' . $request->logo->store('uploads_' . $idApp, 'public');
        $app = new ListApp();
        $app->fill($request->except('_token'));
        $app->logo = $image;
        $app->save();
        session()->put('notification', true);
        return redirect()->route('admin');
    }

    public function edit($app)
    {
        $get = ListApp::where('id_app', $app)->first();
        if ($get == null) {
            return view('user.404');
        }
        return view('app.edit_app', [
            'app' => $get,
        ]);
    }

    public function update($app, Request $request)
    {
        $image =  '/storage/' . $request->logo->store('uploads_' . $app, 'public');
        $this->listApps->updateApp($app, $request->name, $image);
        session()->put('notification', true);
        return redirect()->route('admin');
    }

    public function destroy($app)
    {
        DB::transaction(function () use ($app) {
            Admin::where('id_app', $app)->delete();
            Tour::where('id_company', $app)->delete();
            ListApp::where('id_app', $app)->delete();
        });
        session()->put('notification', true);
        return redirect()->route('admin');
    }
}
