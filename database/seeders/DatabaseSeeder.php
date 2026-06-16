<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
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
        $adminRole = Role::where('name', 'admin')->first();
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@eguidance.com',
            'role_id' => $adminRole->id,
        ]);

        // Create sample counselor
        $counselorRole = Role::where('name', 'counselor')->first();
        \App\Models\User::factory()->create([
            'name' => 'Counselor Smith',
            'email' => 'counselor@eguidance.com',
            'role_id' => $counselorRole->id,
        ]);

        // Create sample student
        $studentRole = Role::where('name', 'student')->first();
        \App\Models\User::factory()->create([
            'name' => 'Student John',
            'email' => 'student@eguidance.com',
            'role_id' => $studentRole->id,
            'student_id' => 'STU001',
        ]);

        // Create sample teacher
        $teacherRole = Role::where('name', 'teacher')->first();
        \App\Models\User::factory()->create([
            'name' => 'Teacher Maria',
            'email' => 'teacher@eguidance.com',
            'role_id' => $teacherRole->id,
        ]);
    }
}
