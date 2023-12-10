<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ListApp;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    const appAdmin = 0;
    private $admins;
    private $listApps;

    public function __construct()
    {

        $this->listApps = new ListApp();
        $this->admins = new Admin();
    }
    public function login()
    {
        return view('auth.login');
    }
    public function test()
    {


        return view('app1.index');
    }

    public function loginStaff(Request $request){
        $account = $request->get('account');
        $password = $request->get('password');
        $staff = $this->admins->where('account', $account)->first();
        if ($staff == null) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Account doesn\'t exist. ',
            ]);
        }

        if(Hash::check($request->password, $staff->password) && $staff->role == 2) {
            return response()->json([
                'status_code' => 200,
                'access_token' => $staff->access_token,
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'message' => 'Wrong password.',
            ]);
        }
    }

    public function processLogin(Request $request)
    {
        session()->flash("old",$request->get('account'));
        try {
            $account = $request->get('account');
            $password = $request->get('password');
            $admin = $this->admins->where('account', $account)->first();
            if ($admin == null) {
                return redirect()->route('login')->with('message', 'The username or password you entered is incorrect, please try again.');
            }

        if(Hash::check($password, $admin->password)) {
            // $admin = $this->admins->getAdmin($account, $password);
            session()->put('id_app', $admin->id_app);
            if ($admin->id_app == null) {
                $idFirstApp = $this->listApps->getFirstApp();
                session()->put('id_app', $idFirstApp->id_app);
            }
            session()->put('id', $admin->id);
            session()->put('name', $admin->name);
            session()->put('role', $admin->role);
            if ($admin->role == self::appAdmin) {
                $name = $this->listApps->getAppById($admin->id_app);
                session()->put('name_app', $name->name);
                return redirect()->route('tour.index');
            }
            return redirect()->route('admin');
        } else {
            return redirect()->route('login')->with('message', 'The username or password you entered is incorrect, please try again.');
        }

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('login')->with('message', 'The username or password you entered is incorrect, please try again.');
        }
    }
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
