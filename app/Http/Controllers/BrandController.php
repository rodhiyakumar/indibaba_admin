<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
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
        return response()->json($result);
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
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.brand.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.brand.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchBrand()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.brand.get"));
        return response()->json(["data" => $result]);
    }
}
