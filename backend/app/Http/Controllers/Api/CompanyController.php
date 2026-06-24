<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Spatie\Permission\Models\Role;
class CompanyController extends Controller
{
    //
    public function index()
    {
        return response()->json(
            Company::latest()->get()
        );
    }

     public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'code' => 'required|unique:companies,code',

        'admin_name' => 'required',
        'admin_email' => 'required|email|unique:users,email',
        'admin_password' => 'required|min:8',
    ]);

    $company = Company::create([
        'name' => $request->name,
        'code' => $request->code,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'status' => 'active',
    ]);

    $admin = User::create([
        'company_id' => $company->id,
        'name' => $request->admin_name,
        'email' => $request->admin_email,
        'password' => bcrypt($request->admin_password),
    ]);

    $admin->assignRole('Company Admin');

    return response()->json([
        'message' => 'Company and Company Admin created successfully',
        'company' => $company,
        'admin' => $admin,
    ]);
}
    //store data in database
    public function show(Company $company)
    {
        return response()->json($company);
    }

    
    
    
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:companies,code,' . $company->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $company->update($request->all());

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => $company,
        ]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json([
            'message' => 'Company deleted successfully',
        ]);
    }
}
