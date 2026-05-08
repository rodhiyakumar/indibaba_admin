<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class BrandController extends Controller
{
    public function index()
    {
        $data['title'] = 'Brands';
        return custom_view('brand.brandList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Brand';
        return custom_view('brand.brandForm', $data);
    }

    public function store(Request $request)
    {

        $brandName = $request->input('brandName');
        $image = $request->input('image');
        $data = [
            "brandName" => $brandName,
            "image" => $image
        ];
        $result = Operation::PostData(Config::get("apis.endpoints.brand.store"), $data);
        json_result($result);
    }
    public function edit($id)
    {
        $data['title'] = 'Update Brand';
        $data['id'] = $id;
        $data['brand'] = Operation::GetData(Config::get("apis.endpoints.brand.get") . '/' . $id);
        return custom_view('brand.brandForm', $data);
    }

    public function update(Request $request, $id)
    {

        $brandName = $request->input('brandName');
        $image = $request->input('image');
        $data = [
            "brandName" => $brandName,
            "image" => $image
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.brand.update") . '/' . $id, $data);
        json_result($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteData(Config::get("apis.endpoints.brand.delete") . '/' . $id);
        json_result($result);
    }

    public function fetchBrand()
    {
        $response = Api::GetApi(Config::get("apis.endpoints.brand.get"));
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
