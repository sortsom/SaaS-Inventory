<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Default role
    $user->assignRole('Company Admin');

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'roles' => $user->getRoleNames(),
        'token' => $token,
    ], 201);
    }

   public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::select(
        'id',
        'name',
        'email',
        'password'
    )
    ->where('email', $request->email)
    ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'role' => $user->roles()->value('name'),
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]
    ]);
}

public function logout(Request $request)
{
    if ($request->user()) {
        $request->user()
            ->currentAccessToken()
            ?->delete();
    }

    return response()->json([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
}
    
    //កន្លែង​បង្កើតកំណត់សិទ្ធិចូលប្រើប្រាស់សម្រាប់ បុគ្គលិកក្នុងក្រុមហ៊ុន  


    public function createCompanyUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role' => 'required'
    ]);

    $companyAdmin = auth()->user();

    $user = User::create([
        'company_id' => $companyAdmin->company_id,
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    $user->assignRole($request->role);

    return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
        'role' => $request->role
    ]);
}
}