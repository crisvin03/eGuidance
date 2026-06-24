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
            ['name' => 'Academic Concerns', 'description' => 'Issues related to studies, grades, and academic performance'],
            ['name' => 'Mental Health', 'description' => 'Mental health and emotional wellness concerns'],
            ['name' => 'Bullying', 'description' => 'Reports of bullying incidents'],
            ['name' => 'Precursor to Bullying', 'description' => 'Early signs or behaviors that may lead to bullying'],
            ['name' => 'Family', 'description' => 'Family-related concerns and issues'],
            ['name' => 'Relationship', 'description' => 'Relationship concerns with peers, friends, or others'],
            ['name' => 'Safety and Protection', 'description' => 'Safety concerns and protection issues'],
            ['name' => 'Career and Future', 'description' => 'Career planning, guidance, and future aspirations'],
            ['name' => 'Counseling and Support Requests', 'description' => 'General counseling and support requests'],
            ['name' => 'Psychological Testing', 'description' => 'Requests for psychological testing and assessment'],
            ['name' => 'Others', 'description' => 'Other concerns not covered by specific categories'],
        ];

        foreach ($categories as $category) {
            ConcernCategory::create($category);
        }
    }
}
