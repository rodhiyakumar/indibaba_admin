<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Helpers\Operation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use App\Models\CarEnquiryModel;
// use App\Models\CarModel;

class DashboardContoller extends Controller
{
    private $data = [];
    public function index()
    {
        $this->data['title'] = 'Dashboard';
        // dd(session('admin_auth'));
        return custom_view('dashboard', $this->data);
    }

    //profile page
    public function profile()
    {
        $this->data['title'] = 'Profile';
        return custom_view('profile', $this->data);
    }

    //admin profile
    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'toastHeading' => config('constants.toastError.heading'),
                'toastIcon' => config('constants.toastError.icon')
            ]);
        } else {
            $type = $request->input("type");
            if ($type == "profile") {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'mobile' => 'required|numeric'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->errors()->first(),
                        'toastHeading' => config('constants.toastError.heading'),
                        'toastIcon' => config('constants.toastError.icon')
                    ]);
                } else {
                    $name = $request->input("name");
                    $mobile = $request->input("mobile");
                    $input = array("name" => $name, "mobile" => $mobile);
                    $response = Api::PatchApiWithToken(config('apis.endpoints.updateProfile'), $input);
                    if ($response && is_array($response)) {
                        if ($response['status']) {
                            $result = [
                                "status" => true,
                                "message" => $response['message'],
                                "toastHeading" => config('constants.toastSuccess.heading'),
                                "toastIcon" => config('constants.toastSuccess.icon'),
                                "name" => $name
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
                            "toastIcon" => config('constants.toastError.icon'),
                            "code" => $response
                        );
                    }
                    json_result($result);
                }
            }
            if ($type == "password") {
                $validator = Validator::make($request->all(), [
                    'new' => 'required',
                    'old' => 'required',
                    'confirm' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->errors()->first(),
                        'toastHeading' => config('constants.toastError.heading'),
                        'toastIcon' => config('constants.toastError.icon')
                    ]);
                } else {
                    $old = $request->input("old");
                    $new = $request->input("new");
                    $confirm = $request->input("confirm");
                    if ($new == $confirm) {
                        $input = array("newPassword" => $new, "oldPassword" => $old);
                        $response = Api::PutApiWithToken(config('apis.endpoints.updatePassword'), $input);
                        if ($response && is_array($response)) {
                            if ($response['status']) {
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
                                "toastIcon" => config('constants.toastError.icon'),
                                "code" => $response
                            );
                        }
                        json_result($result);
                    } else {
                        $result = array(
                            'status' => false,
                            'message' => 'Confirm password is incorrect',
                            'toastHeading' => config('constants.toastError.heading'),
                            'toastIcon' => config('constants.toastError.icon')
                        );
                        json_result($result);
                    }
                }
            }
        }
    }

    public function uploadImage(Request $request)
    {

        $image = $request->file('file');
        $name = $request->file('file')->getClientOriginalName();
        $fileMime = $request->file('file')->getClientMimeType();
        $fileTmpName = $request->file('file')->getRealPath();
        // return response()->json(['success' => $name, 'image' => $image]);
        // return response()->json($request->file('file'));
        $cfile = curl_file_create($fileTmpName, $fileMime, $name);
        $data = array(
            "type" => "course",
            "file" => $cfile
        );

        // print_r($data);
        $response = Api::PostWithMultpart(config('apis.DROPZONE_UPLOAD'), $data);
        json_result($response);
    }
}
