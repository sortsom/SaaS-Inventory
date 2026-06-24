<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;

class DashboardController extends Controller
{
    public function index()
    {
         $start = microtime(true);

    $user = auth()->user();

    $response = [
        'success' => true,
        'data' => [
            'logged_user' => $user->name,
            'email' => $user->email,
            'role' => $user->roles()->value('name'),
            'total_users' => User::count(),
            'total_companies' => Company::count(),
        ]
    ];

    logger('Dashboard Time: ' .
        round((microtime(true) - $start) * 1000, 2) . 'ms');

    return response()->json($response);
    }
}