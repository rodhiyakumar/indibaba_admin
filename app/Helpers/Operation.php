<?php


namespace App\Helpers;

class Operation
{
    public function __construct() {}

    public static function GetData(string $api)
    {
        $response = Api::GetApi($api);
        if ($response && is_array($response)) {
            if ($response['status']) {
                $data = $response['data'];
            } else {
                $data = [];
            }
        } else {
            $data = [];
        }

        return $data;
    }

    public static function GetWithTokenData(string $api)
    {
        $response = Api::GetApiWithToken($api);
        if ($response && is_array($response)) {
            if ($response['status']) {
                $data = $response['data'];
            } else {
                $data = [];
            }
        } else {
            $data = [];
        }

        return $data;
    }

    public static function PostData(string $api, array $input)
    {
        try {
            $response = Api::PostApiWithToken($api, $input);
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
                    "code" => $response,
                    "d" => $input
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
        return $result;
    }

    public static function PutData(string $api, array $input)
    {
        try {
            $response = Api::PutApiWithToken($api, $input);
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
                    "code" => $response,
                    "d" => $input
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
        return $result;
    }

    public static function DeleteData(string $url)
    {
        $response = Api::DeleteApiWithToken($url);
        if ($response && is_array($response)) {
            if ($response['status']) {
                return $response;
            } else {
                return $response;
            }
        } else {
            return ["status" => false, "message" => "Something went wrong"];
        }
    }

    public static function DeleteImageData(string $url, array $data)
    {
        $response = Api::DeleteApiWithToken($url, $data);
        if ($response && is_array($response)) {
            if ($response['status']) {
                return $response;
            } else {
                return $response;
            }
        } else {
            return ["status" => false, "message" => "Something went wrong"];
        }
    }
}
