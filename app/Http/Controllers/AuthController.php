<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
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
        try {
            $email = strtolower($request->input("email_id"));
            $password = $request->input("password");
            $input = [
                "email" => $email,
                "password" => $password
            ];
            $response = Api::PostApi(Config::get("apis.endpoints.login"), $input);
            if ($response && is_array($response)) {
                if ($response['status']) {
                    // print_r($response['data']);
                    // $request->session()->put('admin_auth', $response['data']);
                    Session::put(Api::AUTH_KEY, $response['data']);
                    $result = [
                        "status" => true,
                        "message" => $response['message'],
                        "toastHeading" => config('constants.toastSuccess.heading'),
                        "toastIcon" => config('constants.toastSuccess.icon')
                    ];
                } else {
                    $result = [
                        'status' => false,
                        'message' => $response['message'],
                        'toastHeading' => config('constants.toastError.heading'),
                        'toastIcon' => config('constants.toastError.icon')
                    ];
                }
            } else {
                $result = array(
                    "status" => false,
                    "message" => "something server error",
                    "toastHeading" => config('constants.toastError.heading'),
                    "toastIcon" => config('constants.toastError.icon')
                );
            }
        } catch (\Exception $e) {
            $result = array(
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                "e" => $e->getMessage(),
            );
        }
        json_result($result);
    }
}
