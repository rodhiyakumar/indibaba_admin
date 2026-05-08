<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Operation;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = 'User';
        return custom_view('user.userList', $data);
    }

    public function fetchUser()
    {
        $response = Api::GetApiWithToken(Config::get("apis.endpoints.user.get"));
        // dd($response);
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
