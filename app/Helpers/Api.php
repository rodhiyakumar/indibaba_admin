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
        $code = $response->status();
        if ($code == 401) {
            return $code;
        } else {
            return json_decode($response, true);
        }
    }
    public static function PostApi(string $url, array $body)
    {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
        ])->post($url, $body);
        $code = $response->status();
        // echo $code;
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }
    public static function PatchApi(string $url, array $body)
    {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
        ])->patch($url, $body);
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }
    public static function GetApiWithToken(string $url)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->get($url);
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }

    public static function PostApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->post($url, $body);
        // echo $response;
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }
    public static function PatchApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->patch($url, $body);
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }

    public static function PutApiWithToken(string $url, array $body)
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->put($url, $body);
        // echo $response;
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
    }
    public static function DeleteApiWithToken(string $url, array $body = [])
    {
        $response = Http::withToken(getAccessToken(self::AUTH_KEY))->withHeaders([
            'content-type' => 'application/json',
        ])->delete($url, $body);
        $code = $response->status();
        switch ($code) {
            case '401':
                return $code;
            case '500':
                return $code;
            case '422':
                return $code;
            default:
                return json_decode($response, true);
        }
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
