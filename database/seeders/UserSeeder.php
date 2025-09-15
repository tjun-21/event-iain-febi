<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Super Admin role ID berdasarkan slug
        $superAdminRole = DB::table('roles')->where('slug', 'super_admin')->first();

        // Create Super Admin user
        DB::table('users')->insert([
            'name' => 'Super Administrator',
            'email' => 'superadmin@febievent.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Ganti password ini di production!
            'role_id' => $superAdminRole->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
