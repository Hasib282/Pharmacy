<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Login_User;
use App\Models\User_Info;


if (!function_exists('filterByCompany')) {
    function filterByCompany($query)
    {
        $company = UserCompany();
        $role = UserRole();

        if ($role != 1) {
            $query->where(function ($q) use ($company) {
                $q->where('company_id', $company)
                  ->orWhereNull('company_id');
            });
        }

        return $query;
    }
}