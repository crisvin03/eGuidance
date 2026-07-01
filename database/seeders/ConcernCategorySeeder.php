<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConcernCategory;

class ConcernCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Academic', 'description' => 'Issues related to studies, grades, and academic performance'],
            ['name' => 'Emotional and Mental Wellness', 'description' => 'Mental health, emotional wellness, and psychological concerns'],
            ['name' => 'Social and Peer', 'description' => 'Concerns involving social interactions and peer relationships'],
            ['name' => 'Family', 'description' => 'Family-related concerns and issues'],
            ['name' => 'Behavioral', 'description' => 'Behavioral concerns and conduct-related issues'],
            ['name' => 'Personal and Relationship', 'description' => 'Personal concerns and relationship issues'],
            ['name' => 'Bullying/Safety', 'description' => 'Reports of bullying, harassment, or safety concerns'],
            ['name' => 'Career and Future', 'description' => 'Career planning, guidance, and future aspirations'],
            ['name' => 'Counseling and Support', 'description' => 'General counseling and support requests'],
        ];

        foreach ($categories as $category) {
            ConcernCategory::create($category);
        }
    }
}
