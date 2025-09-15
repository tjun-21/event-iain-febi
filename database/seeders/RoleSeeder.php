<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data roles berdasarkan kolom di migration: name, slug, timestamps
        $roles = [
            [
                'name' => 'Super Administrator',
                'slug' => 'super_admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}
