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
        $moq = $request->input('moq');
        $qty = $request->input('qty');
        $actualPrice = $request->input('actualPrice');
        $listingPrice = $request->input('listingPrice');
        $weight = $request->input('weight');
        $applicationImage = $request->input('applicationImage');
        $description = $request->input('description');
        $images = $request->input('images');
        $reviewCount = $request->input('reviewCount');
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
            "moq" => $moq,
            "qty" => $qty,
            "actualPrice" => $actualPrice,
            "listingPrice" => $listingPrice,
            "weight" => $weight,
            "applicationImage" => $applicationImage,
            "images" => $images,
            "reviewCount" => $reviewCount,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription,
            "specification" => $specification,
            "isActive" => $isActive,
        ];
        $result = Operation::PostData(Config::get("apis.endpoints.product.store"), $data);
        json_result($result);
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

    public function update(Request $request, $id)
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
        $moq = $request->input('moq');
        $qty = $request->input('qty');
        $actualPrice = $request->input('actualPrice');
        $listingPrice = $request->input('listingPrice');
        $weight = $request->input('weight');
        $applicationImage = $request->input('applicationImage');
        $description = $request->input('description');
        $images = $request->input('images');
        $isActive = $request->input('isActive');
        $reviewCount = $request->input('reviewCount');
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
            "moq" => $moq,
            "qty" => $qty,
            "actualPrice" => $actualPrice,
            "listingPrice" => $listingPrice,
            "weight" => $weight,
            "applicationImage" => $applicationImage,
            "images" => $images,
            "reviewCount" => $reviewCount,
            "metaTitle" => $metaTitle,
            "metaKeyword" => $metaKeyword,
            "metaDescription" => $metaDescription,
            "specification" => $specification,
            "isActive" => $isActive,
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.product.update") . '/' . $id, $data);
        json_result($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteData(Config::get("apis.endpoints.product.delete") . '/' . $id);
        json_result($result);
    }

    public function fetchProducts()
    {
        $response = Api::GetApi(Config::get("apis.endpoints.product.get"));
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
