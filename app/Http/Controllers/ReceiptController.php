<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function vnpay($total, $idReceipt)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/api/status-payment";
        $vnp_TmnCode = "MI82RAA9"; //Mã website tại VNPAY 
        $vnp_HashSecret = "AQBSOIXSYSAOCVPNINJOQIEJFNYRWSYO"; //Chuỗi bí mật

        $vnp_TxnRef = time(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $idReceipt;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        return $vnp_Url;
    }
    public function payment(Request $request)
    {
        $tour = Tour::where('id', $request->id_tour)->first();
        if ($tour->slot_available >= $request->amount) {
            DB::table('tour')
                ->where('id', $request->id_tour)
                ->update([
                    'slot_available' => $tour->slot_available -  $request->amount,
                ]);
        } else {
            return response()->json([
                'status_code' => 400,
                'message' => 'Not enough slot',
            ]);
        }
        $app = new Receipt();
        $app->id_tour = $request->id_tour;
        $app->id_customer = $request->id;
        $app->amount = $request->amount;
        $app->total = $request->amount * $tour->price;
        $app->save();

        return response()->json([
            'status_code' => 200,
            'pay_url' => $this->vnpay($app->total, $app->id),
            'id_receipt' => $app->id,
            'message' => 'success',
        ]);
    }
    public function purchasedOrder(Request $request)
    {
        $data = Receipt::Where('id_customer', $request->id)->with('tour')
            // ->join('tour', 'tour.id', '=', 'receipt.id_tour')
            ->get();
        return response()->json([
            'status_code' => 200,
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function statusPayment(Request $request)
    {
        if ($request->has('id_receipt')) {
            try {
                $receipt = Receipt::where('id', $request->get('id_receipt'))->first();
                if ($receipt == null) {
                    return response()->json([
                        'status_code' => 400,
                        'message' => 'Something went wrong!',
                    ]);
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'status_code' => 400,
                    'message' => 'Something went wrong!',
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'status' => $receipt->status,
                'message' => 'success',
            ]);
        }
        if ($request->get('vnp_ResponseCode') == '00') {
            DB::table('receipt')
            ->where('id', $request->get('vnp_OrderInfo'))
            ->update([
                'status' => 1,
            ]);
            return "Thanh toán thành công!";
        }

        return "Thanh toán thất bại!";
    }
}
