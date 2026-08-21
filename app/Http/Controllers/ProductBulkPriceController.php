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

        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.bulkPrice.add"), $data);
        return response()->json($result);
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
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.bulkPrice.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete(int $id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.bulkPrice.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchProductBulkPrice(int $pid)
    {
        $result = Operation::GetData(Config::get("apis.endpoints.bulkPrice.get") . "?productId=" . $pid);
        return response()->json(["data" => $result]);
    }
}
