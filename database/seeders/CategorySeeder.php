<?php

namespace Database\Seeders;

use App\Models\Category; 
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = collect([
            "Toyota",
            "Daihatsu",
            "Mitsubitshi",
            "Honda",
            "Nissan",
            "Mercedes-Benz",
        ]);
 
        $categories->each(function($categories){
            Category::create([
                'name' => $categories,
                'slug' => Str::slug($categories)
            ]);
        });
    }
}
