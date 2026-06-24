<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use company model controller
use App\Http\Controllers\Api\CompanyController;

class Company extends Model
{
    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'status'
    ];
   public function users()
{
    return $this->hasMany(User::class);
}
}
