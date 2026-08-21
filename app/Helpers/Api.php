<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Api
{
    public const AUTH_KEY = "admin_auth";
    public function __construct() {}
    public static function GetApi(string $url)
    {
        // echo $url;
        $response = Http::get($url);
        return handleApiResponse($response);
    }
    public static function PostApi(string $url, array $body)
    {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
        ])->post($url, $body);
        return handleApiResponse($response);
    }
    public static function PatchApi(string $url, array $body)
    {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
        ])->patch($url, $body);
        return handleApiResponse($response);
    }
    public static function GetApiWithToken(string $url)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->get($url);
        return handleApiResponse($response);
    }

    public static function PostApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->post($url, $body);
        // echo $response;
        return handleApiResponse($response);
    }
    public static function PatchApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->patch($url, $body);
        return handleApiResponse($response);
    }

    public static function PutApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->put($url, $body);
        // echo $response;
        return handleApiResponse($response);
    }
    public static function DeleteApiWithToken(string $url, array $body = [])
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->delete($url, $body);
        return handleApiResponse($response);
    }

    public static function GetApiWithUserToken($url)
    {
        // echo $url;
        $response = Http::withToken(getAccessToken('user_auth'))->get($url);
        return handleApiResponse($response);
    }

    public static function PostApiWithUserToken($url, $body)
    {
        $response = Http::withToken(getAccessToken('user_auth'))->withHeaders([
            'content-type' => 'application/json',
        ])->post($url, $body);
        // echo $response;
        // print_r($body);
        // print_r(json_decode($response, true));
        return handleApiResponse($response);
    }
    public static function PatchApiWithUserToken($url, $body)
    {
        $response = Http::withToken(getAccessToken('user_auth'))->withHeaders([
            'content-type' => 'application/json',
        ])->patch($url, $body);
        return handleApiResponse($response);
    }

    public static function PutApiWithUserToken($url, $body)
    {
        $response = Http::withToken(getAccessToken('user_auth'))->withHeaders([
            'content-type' => 'application/json',
        ])->put($url, $body);
        // echo $response;
        return handleApiResponse($response);
    }
    public static function DeleteApiWithUserToken($url)
    {
        $response = Http::withToken(getAccessToken('user_auth'))->withHeaders([
            'content-type' => 'application/json',
        ])->delete($url);
        return handleApiResponse($response);
    }
    public static function DeleteImageWithUserToken($url, $body)
    {
        $response = Http::withToken(getAccessToken('user_auth'))->withHeaders([
            'content-type' => 'application/json',
        ])->delete($url, $body);
        return handleApiResponse($response);
    }

    public static function PostWithMultpart(string $url, array $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600); //timeout in seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}


function extractValidationError($errors)
{
    if (is_array($errors)) {
        $firstError = $errors[0]['message'] ?? null;
        if (is_string($firstError)) return $firstError;
        if ($firstError && is_array($firstError)) return 'Validation error';
    }
    return 'Validation error';
};

function handleApiResponse(\Illuminate\Http\Client\Response $response)
{
    $statusCode = $response->status();
    // echo $response;
    return match ($statusCode) {
        200, 201 => [
            'status' => true,
            'data'    => $response->json('data'),
            'message' => $response->json('message') ?: 'Success',
            'statusCode'  => $statusCode,
        ],
        400 => [
            'status' => false,
            'message' => $response->json('message') ?: 'Bad Request',
            'statusCode'  => 400,
        ],
        401 => [
            'status' => false,
            'message' => $response->json('message') ?: 'Unauthorized',
            'statusCode'  => 401,
        ],
        422 => [
            'status' => false,
            'message' => extractValidationError($response->json('errors')),
            'statusCode'  => 422,
        ],
        500 => [
            'status' => false,
            'message' => $response->json('message') ?: 'External server error.',
            'statusCode'  => 500,
        ],
        default => [
            'status' => false,
            'message' => "Unhandled HTTP status code: {$statusCode}",
            'statusCode'  => $statusCode,
            'body'    => $response->json(),
        ],
    };
}
