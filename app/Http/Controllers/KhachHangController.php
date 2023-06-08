<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{
    private $customer;
    public function __construct()
    {
        $this->customer = new Customer();
    }
    public function login(Request $request)
    {
        $customer = $this->customer->where('email', $request->email)->first();
        if ($customer == null) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Account doesn\'t exist. ',
            ]);
        }

        if(Hash::check($request->password, $customer->password)) {
            return response()->json([
                'status_code' => 200,
                'access_token' => $customer->access_token,
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'message' => 'Wrong password.',
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        $customer = $this->customer->where('id', $request->id)->first();
        if ($customer == null) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Account doesn\'t exist. ',
            ]);
        }
        if(Hash::check($request->old_password, $customer->password)) {
            DB::table('customer')
            ->where('id', $customer->id)
            ->update([
                'password' => Hash::make($request->new_password),
            ]);
            return response()->json([
                'status_code' => 200,
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'message' => 'Current password is wrong.',
            ]);
        }
    }

    public function forgetPassword(Request $request)
    {
        try {
            $randomString = Str::random(8);
            $data = [
            'title' => 'Thang12345',
            'body' => $randomString
            ];
            DB::table('customer')
            ->where('id', $request->id)
            ->update([
                'password' => Hash::make($randomString),
            ]);
            Mail::to('hoangthang6301@gmail.com')->send(new MailNotify($data));
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }

    }

    public function register(Request $request)
    {
        try {
            $existEmail = $this->customer->where('email', $request->email)->exists();
            if ($existEmail) {
                return response()->json([
                    'status_code' => 400,
                    'message' => 'This email is already used!',
                ]);
            }
            $customer = $this->customer;
            $customer->fill($request->all());
            $customer->password = Hash::make($request->password);
            $customer->save();

            DB::table('customer')
                ->where('id', $customer->id)
                ->update([
                    'access_token' => bin2hex(random_bytes(16)) . $customer->id,
                ]);
            return response()->json([
                'status_code' => 200,
                'message' => 'thành công',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 400,
                'message' => $th,
            ]);
        }
    }
}
