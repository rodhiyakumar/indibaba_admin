<?php

use Illuminate\Support\Str;
use App\Helpers\Api;
use Illuminate\Support\Facades\Config;

function json_result(array $array)
{
    header('Content-Type: application/json');
    echo json_encode($array);
}

function custom_view(string $view, array $data)
{
    if (session('admin_auth')) {
        $currentUser = Api::GetApiWithToken(Config::get("apis.endpoints.profile"));
        // print_r($currentUser);
        if ($currentUser && is_array($currentUser)) {
            if ($currentUser['status']) {
                $currentUser = $currentUser['data'];
            } else {
                $currentUser = [];
            }
        } else {
            $currentUser = [];
        }
        if (count($currentUser) > 0) {
            $data['currentUser'] = $currentUser;
        } else {
            return redirect('logout');
        }
    }
    return view($view, $data);
}

function str_random($len)
{
    return Str::random($len);
}

function file_random()
{
    return time() . rand(1, 100);
}

function slug($data)
{
    return Str::slug($data, '-');
}

function str_trim(string $data)
{
    return Str::of($data)->trim();
}

function data_output_datatable(array $columns, array $data)
{
    $out = array();
    for ($i = 0, $ien = count($data); $i < $ien; $i++) {
        $row = array();
        for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
            $column = $columns[$j];
            // Is there a formatter?
            if (isset($column['formatter'])) {
                $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);
            } else {
                $row[$column['dt']] = $data[$i][$columns[$j]['db']];
            }
        }
        $out[] = $row;
    }
    return $out;
}

function custom_date_format(string $date, string $format)
{
    return date($format, strtotime($date));
}

function small_pro_desc(string $data, int $length)
{
    if (strlen($data) > $length) {
        $data = strip_tags($data);
        $str = substr($data, 0, $length) . "...";
    } else {
        $data = strip_tags($data);
        $str = $data;
    }
    return $str;
}

function str_char(string $data, int $length)
{
    if (strlen($data) > $length) {
        $str = substr($data, 0, $length) . "...";
    } else {
        $str = $data;
    }
    return $str;
}

function getAccessToken(string $authType)
{
    if (!empty($authType)) {
        $sessionData = session($authType) ?? [];
        if (is_array($sessionData) && array_key_exists('accessToken', $sessionData)) {
            return $sessionData['accessToken'];
        } else {
            return '';
        }
    } else {
        return '';
    }
}

function secondsToMinutes(int $seconds)
{
    echo gmdate("i:s", $seconds);
}

function minutesToHour(int $minutes)
{
    $hours = floor($minutes / 60);
    $mins = ($minutes -   floor($minutes / 60) * 60);
    echo (($hours < 10) ? '0' . $hours : $hours) . ':' . (($mins < 10) ? '0' . $mins : $mins);
}

function showRating(int $rating)
{
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            echo '<i class="icon-star fill"></i>';
        } else {
            echo '<i class="icon-star"></i>';
        }
    }
}
