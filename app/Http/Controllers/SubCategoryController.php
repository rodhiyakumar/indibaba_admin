<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data['title'] = 'Sub Category';
        return custom_view('subCategory.subCategoryList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Sub Category';
        $data['categories'] = Operation::GetData(Config::get("apis.endpoints.category.get"));
        return custom_view('subCategory.subCategoryForm', $data);
    }

    public function store(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $subCategoryName = $request->input('subCategoryName');
        $sizeImage = $request->input('sizeImage');
        $metaTitle = $request->input('metaTitle');
        $metaKeyword = $request->input('metaKeyword');
        $metaDescription = $request->input('metaDescription');
        $data = [
            "categoryId" => $categoryId,
            "subCategoryName" => $subCategoryName,
            "sizeImage" => $sizeImage,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription
        ];
        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.subCategory.store"), $data);
        return response()->json($result);
    }
    public function edit($id)
    {
        $data['title'] = 'Update Sub Category';
        $data['id'] = $id;
        $data['categories'] = Operation::GetData(Config::get("apis.endpoints.category.get"));
        $data['subCategory'] = Operation::GetData(Config::get("apis.endpoints.subCategory.get") . '/' . $id);
        return custom_view('subCategory.subCategoryForm', $data);
    }

    public function update(Request $request, $id)
    {
        $categoryId = $request->input('categoryId');
        $subCategoryName = $request->input('subCategoryName');
        $sizeImage = $request->input('sizeImage');
        $metaTitle = $request->input('metaTitle');
        $metaKeyword = $request->input('metaKeyword');
        $metaDescription = $request->input('metaDescription');
        $data = [
            "categoryId" => $categoryId,
            "subCategoryName" => $subCategoryName,
            "sizeImage" => $sizeImage,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.subCategory.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function deleteFile(Request $request, $id)
    {
        $sizeImage = $request->input('sizeImage');
        $data = [
            "sizeImage" => $sizeImage
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.subCategory.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.subCategory.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchSubCategory()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.subCategory.get"));
        return response()->json(["data" => $result]);
    }
}
