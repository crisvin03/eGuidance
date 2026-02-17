<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'student', 'description' => 'Student user'],
            ['name' => 'counselor', 'description' => 'Guidance Counselor'],
            ['name' => 'admin', 'description' => 'School Administrator'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
