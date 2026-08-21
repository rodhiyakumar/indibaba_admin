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
                    $result = Operation::PatchWithTokenData(config('apis.endpoints.updateProfile'), $input);
                    return response()->json($result);
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
                        $result = Operation::PutWithTokenData(config('apis.endpoints.updatePassword'), $input);
                        return response()->json($result);
                    } else {
                        $result = array(
                            'status' => false,
                            'message' => 'Confirm password is incorrect',
                            'toastHeading' => config('constants.toastError.heading'),
                            'toastIcon' => config('constants.toastError.icon')
                        );
                        return response()->json($result);
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
        return response()->json($response);
    }
}
