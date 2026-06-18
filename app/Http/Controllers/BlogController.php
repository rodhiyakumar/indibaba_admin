<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\Operation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BlogController extends Controller
{
    public function index()
    {
        $data['title'] = 'Blog';
        return custom_view('blog.blogList', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Blog';

        return custom_view('blog.blogForm', $data);
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $image = $request->input('image');
        $description = $request->input('description');

        $metaDescription = $request->input('metaDescription');
        $data = [
            "description" => $description,
            "title" => $title,
            "image" => $image,
            "isActive" => 1,
            "metaDescription" => $metaDescription,
        ];
        $result = Operation::PostData(Config::get("apis.endpoints.blog.store"), $data);
        json_result($result);
    }

    public function edit($id)
    {
        $data['title'] = 'Update Blog';
        $data['id'] = $id;
        $data['blog'] = Operation::GetData(Config::get("apis.endpoints.blog.get") . '/' . $id);
        return custom_view('blog.blogForm', $data);
    }

    public function update(Request $request, $id)
    {
        $title = $request->input('title');
        $image = $request->input('image');
        $description = $request->input('description');
        $isActive = $request->input('isActive');
        $metaDescription = $request->input('metaDescription');
        $data = [
            "description" => $description,
            "title" => $title,
            "image" => $image,
            "isActive" => $isActive,
            "metaDescription" => $metaDescription
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.blog.update") . '/' . $id, $data);
        json_result($result);
    }

    public function deleteBlogFile($id)
    {
        $data = [
            "image" => ""
        ];
        $result = Operation::PutData(Config::get("apis.endpoints.blog.update") . '/' . $id, $data);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = Operation::DeleteData(Config::get("apis.endpoints.blog.delete") . '/' . $id);
        json_result($result);
    }

    public function fetchBlogs()
    {
        $response = Api::GetApi(Config::get("apis.endpoints.blog.get"));
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
