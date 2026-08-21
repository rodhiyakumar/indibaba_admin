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
        $result = Operation::GetWithTokenData(Config::get("apis.endpoints.user.get"));
        // dd($response);
        return response()->json(["data" => $result]);
    }
}
