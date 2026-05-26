<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class ProductBulkPriceController extends Controller
{
    public function index(int $pid)
    {
        $data['title'] = 'Product Bulk Price';
        $data['pid'] = $pid;
        return custom_view('bulkPrice.bulkPriceList', $data);
    }

    public function form(int $pid)
    {
        $data['title'] = 'Add / Update Bulk Price';
        $data['pid'] = $pid;
        $data['product'] = Operation::GetData(Config::get("apis.endpoints.product.get") . '/' . $pid);
        return custom_view('bulkPrice.bulkPriceForm', $data);
    }

    public function store(Request $request, int $pid)
    {
        $productId = $request->input('productId');
        $qtyRange = $request->input('qtyRange');
        $price = $request->input('price');
        $data = [
            "productId" => $productId,
            "qtyRange" => $qtyRange,
            "price" => $price
        ];

        $result = Operation::PostData(Config::get("apis.endpoints.bulkPrice.add"), $data);
        json_result($result);
    }

    public function edit(int $pid, int $id)
    {
        $data['title'] = 'Update Bulk Price';
        $data['id'] = $id;
        $data['pid'] = $pid;
        $data['product'] = Operation::GetData(Config::get("apis.endpoints.product.get") . '/' . $pid);
        $data['bulkPrice'] = Operation::GetData(Config::get("apis.endpoints.bulkPrice.get") . '/' . $id);
        return custom_view('bulkPrice.bulkPriceForm', $data);
    }

    public function update(Request $request, int $id)
    {
        $price = $request->input('price');
        $data = [
            "price" => $price
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.bulkPrice.update") . '/' . $id, $data);
        json_result($result);
    }

    public function delete(int $id)
    {
        $result = Operation::DeleteData(Config::get("apis.endpoints.bulkPrice.delete") . '/' . $id);
        json_result($result);
    }

    public function fetchProductBulkPrice(int $pid)
    {
        $response = Api::GetApi(Config::get("apis.endpoints.bulkPrice.get") . "?productId=" . $pid);
        if ($response && is_array($response)) {
            if ($response['status']) {
                return response()->json(["data" => $response['data']]);
            } else {
                return response()->json(["data" => []]);
            }
        } else {
            return response()->json(["data" => []]);
        }
    }
}
