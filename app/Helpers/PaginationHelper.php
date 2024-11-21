<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginationHelper
{
    public static function ConvertApiPaginationToLaravelPaginator($apiData)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentData = array_slice($apiData['data'], ($currentPage - 1) * $perPage, $perPage);
        
        return new LengthAwarePaginator(
            $currentData,
            $apiData['total'],
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
}