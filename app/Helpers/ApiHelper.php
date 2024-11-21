<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ApiHelper
{
    public static function fetchFromApi($endpoint, $queryParams = [])
    {
        $token = session('api_token');
        return Http::withToken($token)->get($endpoint, $queryParams);
    }
}
