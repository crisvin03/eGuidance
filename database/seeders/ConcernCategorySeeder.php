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
            ['name' => 'Personal/Emotional', 'description' => 'Personal problems and emotional issues'],
            ['name' => 'Bullying/Harassment', 'description' => 'Reports of bullying or harassment'],
            ['name' => 'Career Guidance', 'description' => 'Career planning and guidance'],
            ['name' => 'Other', 'description' => 'Other concerns not covered by specific categories'],
        ];

        foreach ($categories as $category) {
            ConcernCategory::create($category);
        }
    }
}
