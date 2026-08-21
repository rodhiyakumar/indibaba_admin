<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{
    public function index()
    {
        $data['title'] = 'Product';
        return custom_view('product.productList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Product';
        $data['categories'] = Operation::GetData(Config::get("apis.endpoints.category.get"));
        $data['brands'] = Operation::GetData(Config::get("apis.endpoints.brand.get"));
        return custom_view('product.productForm', $data);
    }

    public function store(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $brandId = $request->input('brandId');
        $name = $request->input('name');
        $masterImage = $request->input('masterImage');
        $isFeatured = $request->input('isFeatured');
        $electricalSpecsValue = $request->input('electricalSpecsValue');
        $electricalSpecsUnit = $request->input('electricalSpecsUnit');
        $grade = $request->input('grade');
        $model = $request->input('model');
        $inventoryCode = $request->input('inventoryCode');
        $hsn = $request->input('hsn');
        $taxRate = $request->input('taxRate');
        $moq = $request->input('moq');
        $qty = $request->input('qty');
        $originalPrice = $request->input('originalPrice');
        $sellingPrice = $request->input('sellingPrice');
        $weight = $request->input('weight');
        $applicationImage = $request->input('applicationImage');
        $description = $request->input('description');
        $images = $request->input('images');
        $reviewCount = $request->input('reviewCount');
        $rating = $request->input('rating');
        $metaTitle = $request->input('metaTitle');
        $metaKeyword = $request->input('metaKeyword');
        $metaDescription = $request->input('metaDescription');
        $specification = $request->input('specification');
        $isActive = 0;
        $data = [
            "categoryId" => $categoryId,
            "brandId" => $brandId,
            "name" => $name,
            "masterImage" => $masterImage,
            "description" => $description,
            "isFeatured" => $isFeatured,
            "electricalSpecsValue" => $electricalSpecsValue,
            "electricalSpecsUnit" => $electricalSpecsUnit,
            "grade" => $grade,
            "model" => $model,
            "inventoryCode" => $inventoryCode,
            "hsn" => $hsn,
            "taxRate" => $taxRate,
            "moq" => $moq,
            "qty" => $qty,
            "originalPrice" => $originalPrice,
            "sellingPrice" => $sellingPrice,
            "weight" => $weight,
            "applicationImage" => $applicationImage,
            "images" => $images,
            "reviewCount" => $reviewCount,
            "rating" => $rating,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription,
            "specification" => $specification,
            "isActive" => $isActive,
        ];
        $result = Operation::PostWithTokenData(Config::get("apis.endpoints.product.store"), $data);
        return response()->json($result);
    }
    public function edit(int $id)
    {
        $data['title'] = 'Update Product';
        $data['id'] = $id;
        $data['categories'] = Operation::GetData(Config::get("apis.endpoints.category.get"));
        $data['product'] = Operation::GetData(Config::get("apis.endpoints.product.get") . '/' . $id);
        $data['brands'] = Operation::GetData(Config::get("apis.endpoints.brand.get"));
        $data['productImages'] = isset($id) && isset($data['product']["images"]) ? array_map(function ($arr) {
            return [
                "uuid" => time(),
                "file" => $arr
            ];
        }, explode(",", $data['product']["images"])) : null;
        return custom_view('product.productForm', $data);
    }

    public function update(Request $request, int $id)
    {
        $categoryId = $request->input('categoryId');
        $brandId = $request->input('brandId');
        $name = $request->input('name');
        $masterImage = $request->input('masterImage');
        $isFeatured = $request->input('isFeatured');
        $electricalSpecsValue = $request->input('electricalSpecsValue');
        $electricalSpecsUnit = $request->input('electricalSpecsUnit');
        $grade = $request->input('grade');
        $model = $request->input('model');
        $inventoryCode = $request->input('inventoryCode');
        $hsn = $request->input('hsn');
        $taxRate = $request->input('taxRate');
        $moq = $request->input('moq');
        $qty = $request->input('qty');
        $originalPrice = $request->input('originalPrice');
        $sellingPrice = $request->input('sellingPrice');
        $weight = $request->input('weight');
        $applicationImage = $request->input('applicationImage');
        $description = $request->input('description');
        $images = $request->input('images');
        $isActive = $request->input('isActive');
        $reviewCount = $request->input('reviewCount');
        $rating = $request->input('rating');
        $metaTitle = $request->input('metaTitle');
        $metaKeyword = $request->input('metaKeyword');
        $metaDescription = $request->input('metaDescription');
        $specification = $request->input('specification');
        $data = [
            "categoryId" => $categoryId,
            "brandId" => $brandId,
            "name" => $name,
            "masterImage" => $masterImage,
            "description" => $description,
            "isFeatured" => $isFeatured,
            "electricalSpecsValue" => $electricalSpecsValue,
            "electricalSpecsUnit" => $electricalSpecsUnit,
            "grade" => $grade,
            "model" => $model,
            "inventoryCode" => $inventoryCode,
            "hsn" => $hsn,
            "taxRate" => $taxRate,
            "moq" => $moq,
            "qty" => $qty,
            "originalPrice" => $originalPrice,
            "sellingPrice" => $sellingPrice,
            "weight" => $weight,
            "applicationImage" => $applicationImage,
            "images" => $images,
            "reviewCount" => $reviewCount,
            "rating" => $rating,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription,
            "specification" => $specification,
            "isActive" => $isActive,
        ];
        $result = Operation::PutWithTokenData(Config::get("apis.endpoints.product.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete(int $id)
    {
        $result = Operation::DeleteWithTokenData(Config::get("apis.endpoints.product.delete") . '/' . $id);
        return response()->json($result);
    }

    public function fetchProducts()
    {
        $result = Operation::GetData(Config::get("apis.endpoints.product.get"));
        return response()->json(["data" => $result]);
    }
}
