<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class CouponController extends Controller
{
    public function index()
    {
        $data['title'] = 'Coupon';
        return custom_view('coupon.couponList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Coupon';
        return custom_view('coupon.couponForm', $data);
    }

    public function store(Request $request)
    {

        $couponName = $request->input('couponName');
        $couponDiscount = $request->input('couponDiscount');
        $data = [
            "couponName" => $couponName,
            "couponDiscount" => $couponDiscount
        ];
        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.coupon.store"), $data);
        return response()->json($result);
    }
    public function edit($id)
    {
        $data['title'] = 'Update Coupon';
        $data['id'] = $id;
        $data['coupon'] = Operation::GetData(Config::get("apis.endpoints.coupon.get") . '/' . $id);
        return custom_view('coupon.couponForm', $data);
    }

    public function update(Request $request, $id)
    {

        $couponName = $request->input('couponName');
        $couponDiscount = $request->input('couponDiscount');
        $data = [
            "couponName" => $couponName,
            "couponDiscount" => $couponDiscount
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.coupon.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.coupon.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchCategory()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.coupon.get"));
        return response()->json(["data" => $result]);
    }
}
