<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Haque Store',
            'logo' => 'logo.png',
            'website' => 'https://haquestore.com',
            'email' => '',
            'phone' => '+8801XXXXXXXXX',
            'secondary_phone' => '',
            'address' => 'Dhaka, Bangladesh',
            'description' => '',
        ]);
    }
}
