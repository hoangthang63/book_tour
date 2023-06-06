<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    private $tour;
    public function __construct()
    {
        $this->tour = new Tour();
    }

    public function index()
    {
        $listApp = $this->tour->getAllApp();
        $allApp = $this->tour->getAll();

        return view('layout.index', [
            'list_apps' => $listApp,
            'all_apps' => $allApp,
        ]);
    }

    public function create()
    {
        return view('user.create_tour',);
    }

    public function store(Request $request)
    {
        $idApp = session()->get('id_app');
        $image =  '/storage/' . $request->logo->store('uploads_' . $idApp, 'public');
        $app = new Tour();
        $app->fill($request->except('_token'));
        $app->logo = $image;
        $app->save();
        session()->put('notification', true);
        return redirect()->route('admin');
    }

    public function edit($app)
    {
        $get = Tour::where('id_app', $app)->first();
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
        $this->tour->updateApp($app, $request->name, $image);
        session()->put('notification', true);
        return redirect()->route('admin');
    }

    public function destroy($app)
    {

        session()->put('notification', true);
        return redirect()->route('admin');
    }
}
