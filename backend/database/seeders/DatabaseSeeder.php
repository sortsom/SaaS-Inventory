<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Create Roles & Permissions
        $this->call(RolePermissionSeeder::class);

        // Super Admin
        $superAdmin = User::factory()->superAdmin()->create();
        $superAdmin->assignRole('Super Admin');

        // Company Admin
        $companyAdmin = User::factory()->companyAdmin()->create();
        $companyAdmin->assignRole('Company Admin');

        // Warehouse Staff
        $warehouse = User::factory()->warehouseStaff()->create();
        $warehouse->assignRole('Warehouse Staff');

        // Sales Staff
        $sales = User::factory()->salesStaff()->create();
        $sales->assignRole('Sales Staff');
    }
}
