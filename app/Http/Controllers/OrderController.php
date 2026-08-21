<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\Operation;
use App\Helpers\UserOperation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{
    public function index()
    {
        $data['title'] = 'Order';
        return custom_view('order.orderList', $data);
    }

    public function detail($id)
    {
        $data['title'] = "Order #$id";
        $data['id'] = $id;
        $data['order'] = Operation::GetWithTokenData(Config::get("apis.endpoints.order.detail") . '/' . $id);
        $data['orderStatus'] = UserOperation::GetData(Config::get("apis.frontend.endpoints.meta.orderStatus"));
        $data['returnReason'] = UserOperation::GetData(Config::get("apis.frontend.endpoints.meta.returnReason"));
        return custom_view('order.orderDetail', $data);
    }

    public function update(Request $request, $id)
    {
        $paymentStatus = $request->input('paymentStatus');
        $orderStatusId = $request->input('orderStatusId');
        $reasonId = $request->input('reasonId');
        $data = [
            "paymentStatus" => $paymentStatus,
            "orderStatusId" => $orderStatusId,
            "reasonId" => $reasonId
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.order.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function updateShipping(Request $request, $id)
    {
        $trackingNo = $request->input('trackingNo');
        $trackingLink = $request->input('trackingLink');
        $data = [
            "trackingNo" => $trackingNo,
            "trackingLink" => $trackingLink
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.order.updateShipping") . '/' . $id, $data);
        return response()->json($result);
    }

    public function orderPrint($id)
    {
        $data['order'] = Operation::GetWithTokenData(Config::get("apis.endpoints.order.detail") . '/' . $id);
        // $data['returnReason'] = Operation::GetData(Config::get("apis.endpoints.meta.returnReason"));
        return view('order.order-print', $data);
    }

    public function fetchOrders($page)
    {
        $result = Operation::GetWithTokenData(Config::get("apis.admin.endpoints.order.get") . '/' . $page . '?search=' . request()->input('search'));
        return response()->json(["data" => $result]);
    }
}
