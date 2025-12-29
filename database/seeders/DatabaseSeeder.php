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

        $this->call(RoleAndPermissionSeeder::class);
        $user=User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@haquestore.com',
            'password' => bcrypt('#haquestore#2025'),
        ]);
        $user->assignRole('superadmin');
    }
}
