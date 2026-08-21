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

        $categoryName = "";
        $image = $request->input('image');
        $data = [
            "categoryName" => $categoryName,
            "image" => $image
        ];
        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.category.store"), $data);
        return response()->json($result);
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
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.category.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.category.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchCategory()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.category.get"));
        return response()->json(["data" => $result]);
    }
}
