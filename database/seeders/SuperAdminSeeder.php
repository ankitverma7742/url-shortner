<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::insert(
            "INSERT INTO users
            (name, email, password, role, company_id, created_at, updated_at)
            VALUES (?, ?, ?, 'superadmin', NULL, ?, ?)",
            [
                'Super Admin',
                'superadmin@url.com',
                Hash::make('Admin@123'),
                now(),
                now()
            ]
        );
    }
}