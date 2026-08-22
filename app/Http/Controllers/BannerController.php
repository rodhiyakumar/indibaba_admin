<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use Illuminate\Support\Facades\Config;

class BannerController extends Controller
{
    public function index()
    {
        $data['title'] = 'Banner';
        return custom_view('banner.bannerList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Banner';
        return custom_view('banner.bannerForm', $data);
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $name = $request->input('name');
        $image = $request->input('image');
        $url = $request->input('url');
        $data = [
            "type" => $type,
            "name" => $name,
            "image" => $image,
            "url" => $url
        ];
        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.banner.store"), $data);
        return response()->json($result);
    }
    public function edit($id)
    {
        $data['title'] = 'Update Banner';
        $data['id'] = $id;
        $data['banner'] = Operation::GetData(Config::get("apis.endpoints.banner.get") . '/' . $id);
        return custom_view('banner.bannerForm', $data);
    }

    public function update(Request $request, $id)
    {
        $type = $request->input('type');
        $name = $request->input('name');
        $image = $request->input('image');
        $url = $request->input('url');
        $data = [
            "type" => $type,
            "name" => $name,
            "image" => $image,
            "url" => $url
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.banner.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.banner.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchBanner()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.banner.get"));
        return response()->json(["data" => $result]);
    }
}
