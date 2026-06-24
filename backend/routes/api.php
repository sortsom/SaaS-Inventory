<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\DashboardController;
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

     Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', function (\Illuminate\Http\Request $request) {
        return $request->user();
    });

    Route::middleware(['auth:sanctum', 'role:Super Admin'])
    ->post('/companies', [CompanyController::class, 'store']);

    Route::middleware('permission:product.view')
        ->get('/products', function () {
            return response()->json([
                'message' => 'You have product.view permission'
            ]);
        });
Route::middleware(['auth:sanctum', 'role:Super Admin'])
    ->post('/users/{user}/assign-company', [AuthController::class, 'assignCompany']);
Route::get('/my-company', function (\Illuminate\Http\Request $request) {

    return response()->json([
        'user' => $request->user()->name,
        'company_id' => $request->user()->company_id,
        'company' => $request->user()->company
    ]);

});
// Route បង្កើតកំណត់សិទ្ធិចូលប្រើប្រាស់សម្រាប់ បុគ្គលិកក្នុងក្រុមហ៊ុន
        Route::middleware([
    'auth:sanctum',
    'role:Company Admin'
])->post('/company/users', [AuthController::class, 'createCompanyUser']);




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
});