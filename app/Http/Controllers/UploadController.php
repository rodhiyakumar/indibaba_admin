<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\Operation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class UploadController extends Controller
{
    public function uploadFile(Request $request)
    {
        $image = $request->file('file');
        $type = $request->input('type');
        $name = $request->file('file')->getClientOriginalName();
        $fileMime = $request->file('file')->getClientMimeType();
        $fileTmpName = $request->file('file')->getRealPath();
        $cfile = curl_file_create($fileTmpName, $fileMime, $name);
        $data = array(
            "type" => $type,
            "file" => $cfile
        );

        // print_r($data);
        $response = Api::PostWithMultpart(Config::get("apis.endpoints.file.upload"), $data);
        json_result($response);
    }
}
