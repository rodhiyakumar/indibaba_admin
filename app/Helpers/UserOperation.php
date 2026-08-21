<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class UserOperation
{
    public function __construct() {}

    public static function GetData($api)
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

    public static function GetWithTokenData($api)
    {
        $response = Api::GetApiWithUserToken($api);
        if (!is_array($response) || empty($response['status'])) {
            return [];
        }
        return $response['data'] ?? [];
    }

    public static function PostWithTokenData($api, $input)
    {
        try {
            $response = Api::PostApiWithUserToken($api, $input);
            if (!is_array($response)) {
                return [
                    'status'       => false,
                    'message'      => 'something server error',
                    'toastHeading' => config('constants.toastError.heading'),
                    'toastIcon'    => config('constants.toastError.icon'),
                    'code'         => $response['statusCode'],
                    'd'            => $input,
                ];
            }

            $isSuccess  = !empty($response['status']);
            $toastType  = $isSuccess ? 'toastSuccess' : 'toastError';
            return [
                'status'       => $isSuccess,
                'message'      => $response['message'] ?? 'An unexpected error occurred.',
                'data'         => $response['data'] ?? [],
                'toastHeading' => config("constants.{$toastType}.heading"),
                'toastIcon'    => config("constants.{$toastType}.icon"),
                'code'         => $response['statusCode'],
                ...(array_key_exists('data', $response) ? ['data' => $response['data']] : []),
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                'code'         => 500,
                "e" => $e->getMessage(),
            ];
        }
    }

    public static function PutWithTokenData($api, $input)
    {
        try {
            $response = Api::PutApiWithUserToken($api, $input);
            if (!is_array($response)) {
                return [
                    'status'       => false,
                    'message'      => 'something server error',
                    'toastHeading' => config('constants.toastError.heading'),
                    'toastIcon'    => config('constants.toastError.icon'),
                    'code'         => $response['statusCode'],
                    'd'            => $input,
                ];
            }

            $isSuccess  = !empty($response['status']);
            $toastType  = $isSuccess ? 'toastSuccess' : 'toastError';
            return [
                'status'       => $isSuccess,
                'message'      => $response['message'] ?? 'An unexpected error occurred.',
                'toastHeading' => config("constants.{$toastType}.heading"),
                'toastIcon'    => config("constants.{$toastType}.icon"),
                'code'         => $response['statusCode'],
                ...(array_key_exists('data', $response) ? ['data' => $response['data']] : []),
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                'code'         => 500,
                "e" => $e->getMessage(),
            ];
        }
    }

    public static function PatchWithTokenData($api, $input)
    {
        try {
            $response = Api::PatchApiWithUserToken($api, $input);
            if (!is_array($response)) {
                return [
                    'status'       => false,
                    'message'      => 'something server error',
                    'toastHeading' => config('constants.toastError.heading'),
                    'toastIcon'    => config('constants.toastError.icon'),
                    'code'         => $response['statusCode'],
                    'd'            => $input,
                ];
            }

            $isSuccess  = !empty($response['status']);
            $toastType  = $isSuccess ? 'toastSuccess' : 'toastError';
            return [
                'status'       => $isSuccess,
                'message'      => $response['message'] ?? 'An unexpected error occurred.',
                'toastHeading' => config("constants.{$toastType}.heading"),
                'toastIcon'    => config("constants.{$toastType}.icon"),
                'code'         => $response['statusCode'],
                ...(array_key_exists('data', $response) ? ['data' => $response['data']] : []),
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                'code'         => 500,
                "e" => $e->getMessage(),
            ];
        }
    }

    public static function DeleteWithTokenData($url)
    {
        try {
            $response = Api::DeleteApiWithUserToken($url);
            if (!is_array($response)) {
                return [
                    'status'       => false,
                    'message'      => 'something server error',
                    'toastHeading' => config('constants.toastError.heading'),
                    'toastIcon'    => config('constants.toastError.icon'),
                    'code'         => $response['statusCode'],
                ];
            }
            $isSuccess  = !empty($response['status']);
            $toastType  = $isSuccess ? 'toastSuccess' : 'toastError';
            return [
                'status'       => $isSuccess,
                'message'      => $response['message'] ?? 'An unexpected error occurred.',
                'toastHeading' => config("constants.{$toastType}.heading"),
                'toastIcon'    => config("constants.{$toastType}.icon"),
                'code'         => $response['statusCode'],
                ...(array_key_exists('data', $response) ? ['data' => $response['data']] : []),
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                'code'         => 500,
                "e" => $e->getMessage(),
            ];
        }
    }

    public static function DeleteWithTokenImageData($url, $data)
    {
        try {
            $response = Api::DeleteApiWithUserToken($url, $data);
            if (!is_array($response)) {
                return [
                    'status'       => false,
                    'message'      => 'something server error',
                    'toastHeading' => config('constants.toastError.heading'),
                    'toastIcon'    => config('constants.toastError.icon'),
                    'code'         => $response['statusCode'],
                ];
            }
            $isSuccess  = !empty($response['status']);
            $toastType  = $isSuccess ? 'toastSuccess' : 'toastError';
            return [
                'status'       => $isSuccess,
                'message'      => $response['message'] ?? 'An unexpected error occurred.',
                'toastHeading' => config("constants.{$toastType}.heading"),
                'toastIcon'    => config("constants.{$toastType}.icon"),
                'code'         => $response['statusCode'],
                ...(array_key_exists('data', $response) ? ['data' => $response['data']] : []),
            ];
        } catch (\Exception $e) {
            return [
                "status" => false,
                "message" => "Internal server error",
                "toastHeading" => config('constants.toastError.heading'),
                "toastIcon" => config('constants.toastError.icon'),
                'code'         => 500,
                "e" => $e->getMessage(),
            ];
        }
    }
}
