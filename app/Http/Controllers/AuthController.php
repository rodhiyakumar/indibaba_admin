<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\Operation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //Login View
    public function index()
    {
        $data['title'] = 'Login';
        return view('login', $data);
    }

    public function action_login(Request $request)
    {

        $email = strtolower($request->input("email_id"));
        $password = $request->input("password");
        $input = [
            "email" => $email,
            "password" => $password
        ];
        $result = Operation::PostData(Config::get("apis.endpoints.login"), $input);
        if ($result['status']) {
            Session::put(Api::AUTH_KEY, $result['data']);
        }
        return response()->json($result);
    }
}
