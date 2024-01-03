<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Mail\UnlockAccountMail;
use App\Models\Customer;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

        if ($customer->is_active == 0) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Your account has been locked. Please check your email to unlock',
            ]);
        }

        if ($customer->login_attempt == 0) {
            $data = [
                'unlock_url' => config('app.domain') . '/unlock/' . base64_encode(base64_encode(base64_encode($customer->id))),
            ];
            Mail::to($request->email)->send(new UnlockAccountMail($data));
            DB::table('customer')
            ->where('email', $request->email)
            ->update([
                'is_active' => 0,
            ]);
            return response()->json([
                'status_code' => 403,
                'message' => 'Your account has been locked',
            ]);
        }

        if(Hash::check($request->password, $customer->password)) {
            DB::table('customer')
            ->where('email', $request->email)
            ->update([
                'is_active' => 1,
                'login_attempt' => 5,
            ]);
            return response()->json([
                'status_code' => 200,
                'access_token' => $customer->access_token,
            ]);
        } else {
            DB::table('customer')
            ->where('email', $request->email)
            ->update([
                'login_attempt' => $customer->login_attempt - 1,
            ]);
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
            // $apiURL = "https://travelkma.onrender.com/nodemail";
            $customer = $this->customer->where('email', $request->email)->exists();
            if (!$customer) {
                return response()->json([
                    'status_code' => 400,
                    'message' => 'Accout does not exist',
                ]);
            }
            $randomString = Str::random(8);
            $data = [
            'email' => $request->email,
            'password' => $randomString
            ];
            DB::table('customer')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($randomString),
            ]);
            Mail::to($request->email)->send(new MailNotify($data));
            // $headers = [
            //     'X-header' => 'value'
            // ];
            
            // $response = Http::withHeaders($headers)->post($apiURL, $data);
            
            // $statusCode = $response->status();            
            
            // if ($statusCode == 200) {
            //     $responseBody = json_decode($response->getBody(), true);
            //     $data = $responseBody;
            // }
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 400,
                'message' => $th,
            ]);
        }

    }

    public function profile(Request $request)
    {
        try {
            $data = $this->customer->select('id', 'name', 'phone_number', 'address', 'email')->where('id', $request->id)->first();
            return response()->json([
                'status_code' => 200,
                'data' => $data,
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Something went wrong',
            ]);
        }

    }

    public function editProfile(Request $request)
    {
        try {
            DB::table('customer')
            ->where('id', $request->id)
            ->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
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
            $customer->phone_number = $this->encryptData($request->phone_number);
            $customer->address = $this->encryptData($request->address);
            $customer->password = Hash::make($request->password);
            $customer->save();

            DB::table('customer')
                ->where('id', $customer->id)
                ->update([
                    'access_token' => bin2hex(random_bytes(16)) . $customer->id,
                ]);
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 400,
                'message' => $th,
            ]);
        }
    }

    private function encryptData($data) {
        $iv = str_repeat("0", openssl_cipher_iv_length(config('app.ciper')));
        $option = 0;
        return openssl_encrypt($data, config('app.ciper'), config('app.secret_key'), $option, $iv);
    }

    private function decryptData($data) {
        $iv = str_repeat("0", openssl_cipher_iv_length(config('app.ciper')));
        $option = 0;
        return openssl_decrypt($data, config('app.ciper'), config('app.secret_key'), $option, $iv);
    }
}
