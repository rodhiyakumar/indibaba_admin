<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class CategoryController extends Controller
{
    public function index()
    {
        $data['title'] = 'Category';
        return custom_view('category.categoryList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Category';
        return custom_view('category.categoryForm', $data);
    }

    public function store(Request $request)
    {

        $categoryName = $request->input('categoryName');
        $image = $request->input('image');
        $data = [
            "categoryName" => $categoryName,
            "image" => $image
        ];
        $result = Operation::PostData(Config::get("apis.endpoints.category.store"), $data);
        json_result($result);
    }
    public function edit($id)
    {
        $data['title'] = 'Update Category';
        $data['id'] = $id;
        $data['category'] = Operation::GetData(Config::get("apis.endpoints.category.get") . '/' . $id);
        return custom_view('category.categoryForm', $data);
    }

    public function update(Request $request, $id)
    {

        $categoryName = $request->input('categoryName');
        $image = $request->input('image');
        $data = [
            "categoryName" => $categoryName,
            "image" => $image
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.category.update") . '/' . $id, $data);
        json_result($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteData(Config::get("apis.endpoints.category.delete") . '/' . $id);
        json_result($result);
    }

    public function fetchCategory()
    {
        $response = Api::GetApi(Config::get("apis.endpoints.category.get"));
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
