<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryTranslation;
use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       // Action
       Category::create([
           'slug' => 'action',
           'is_active' => 1
       ]);
       CategoryTranslation::create([
           'category_id' => 1,
           'locale' => 'ar',
           'name' => 'أكشن',
       ]);
       CategoryTranslation::create([
           'category_id' => 1,
           'locale' => 'en',
           'name' => 'Action',
       ]);

       // Advanture
       Category::create([
           'slug' => 'advanture',
           'is_active' => 1
       ]);
       CategoryTranslation::create([
           'category_id' => 2,
           'locale' => 'ar',
           'name' => 'مغامرة',
       ]);
       CategoryTranslation::create([
           'category_id' => 2,
           'locale' => 'en',
           'name' => 'Advanture',
       ]);

       // Sci-Fi
       Category::create([
           'slug' => 'sci-fi',
           'is_active' => 1
       ]);
       CategoryTranslation::create([
           'category_id' => 3,
           'locale' => 'ar',
           'name' => 'خيال علمي',
       ]);
       CategoryTranslation::create([
           'category_id' => 3,
           'locale' => 'en',
           'name' => 'Sci-Fi',
       ]);
       
       // Simulation
       Category::create([
           'slug' => 'simulation',
           'is_active' => 1
       ]);
       CategoryTranslation::create([
           'category_id' => 4,
           'locale' => 'ar',
           'name' => 'محاكاة',
       ]);
       CategoryTranslation::create([
           'category_id' => 4,
           'locale' => 'en',
           'name' => 'Simulation',
       ]);

       // Puzzle
       Category::create([
           'slug' => 'puzzle',
           'is_active' => 1
       ]);
       CategoryTranslation::create([
           'category_id' => 5,
           'locale' => 'ar',
           'name' => 'ألغاز',
       ]);
       CategoryTranslation::create([
           'category_id' => 5,
           'locale' => 'en',
           'name' => 'Puzzle',
       ]);

       // SubCat [ War ]
       Category::create([
           'slug' => 'war',
           'is_active' => 1,
           'parent_id' => 1 // Action
       ]);
       CategoryTranslation::create([
           'category_id' => 6,
           'locale' => 'ar',
           'name' => 'حرب',
       ]);
       CategoryTranslation::create([
           'category_id' => 6,
           'locale' => 'en',
           'name' => 'War',
       ]);

       // SubCat [ With Time ]
       Category::create([
           'slug' => 'with-time',
           'is_active' => 1,
           'parent_id' => 5 // Puzzle
       ]);
       CategoryTranslation::create([
           'category_id' => 7,
           'locale' => 'ar',
           'name' => 'مع مؤقت',
       ]);
       CategoryTranslation::create([
           'category_id' => 7,
           'locale' => 'en',
           'name' => 'With Time',
       ]);
    }
}
