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
        $this->call([
            RoleSeeder::class,
            ConcernCategorySeeder::class,
        ]);

        // Create default admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@eguidance.com',
            'role_id' => 3, // admin
        ]);

        // Create sample counselor
        \App\Models\User::factory()->create([
            'name' => 'Counselor Smith',
            'email' => 'counselor@eguidance.com',
            'role_id' => 2, // counselor
        ]);

        // Create sample student
        \App\Models\User::factory()->create([
            'name' => 'Student John',
            'email' => 'student@eguidance.com',
            'role_id' => 1, // student
            'student_id' => 'STU001',
        ]);
    }
}
