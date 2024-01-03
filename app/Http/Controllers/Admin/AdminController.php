<?php

namespace App\Http\Controllers\Admin;
use App\Models\ListApp;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private $admins;
    private $listApps;
    private $customer;

    public function __construct(){
        $this->admins = new Admin();
        $this->listApps = new ListApp();
        $this->customer = new Customer();
    }
    public function index(){
        $idApp = session()->get('id_app');
        $listAppAdmin = $this->admins->getAppAdminByIdApp($idApp);
        return view('app.index',[
            'list_app_admins' => $listAppAdmin,
        ]);
    }

    public function store(StoreRequest $request){
        $idApp = session()->get('id_app');
        $app = new Admin();
        $app->fill($request->except('_token'));
        $app->id_app = $idApp;
        $app->password = Hash::make($request->password) ;
        $app->role = 0;
        $app->save();
        session()->put('notification', true);
        return redirect()->route('app.admin');
    }

    public function update(Request $request,Admin $app){
        // $request->password = Hash::make($request->password);

        $app->update(
            [
                'password' => Hash::make($request->password),
                'account' => $request->account,
                'name' => $request->name,

            ]

        );
        session()->put('notification', true);
        return redirect()->route('app.admin');

    }

    public function edit(Admin $app){
        $checkExist = $this->admins->checkExist($app->id);
        if ($checkExist == null) {
            return view('user.404');
        }
        return view('app.edit_app_admin_account',[
            'app' => $app,
        ]);
    }
    public function destroy(Admin $app){
        $app->delete();
        // Admin::destroy($app->id);
        return redirect()->route('app.admin');
    }

    public function unlock($id){
        $customerId = base64_decode(base64_decode(base64_decode($id)));
        $customer = $this->customer->where('id', $customerId)->first();
        if ($customer == null) {
            abort(404);
        }

        DB::table('customer')
        ->where('id', $customerId)
        ->update([
            'login_attempt' => 5,
            'is_active' => 1,
        ]);

        return "Mở khóa tài khoản thành công";
    }
}
