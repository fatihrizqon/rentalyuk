<?php

namespace Database\Seeders;
 
use App\Models\Vehicle; 
use Illuminate\Database\Seeder; 
use Faker\Generator;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $faker = app(Generator::class);
        $vehicles = [
            [
                'license_number' => $faker->numerify('AB1###UZ'),
                'name' => 'Camry',
                'image' => '',
                'price' => 500000,
                'category_id' => 1,
            ],
            [
                'license_number' => $faker->numerify('AB2###UZ'),
                'name' => 'Fortuner',
                'image' => '',
                'price' => 550000,
                'category_id' => 1,
            ],
            [
                'license_number' => $faker->numerify('AB3###UZ'),
                'name' => 'Innova Reborn',
                'image' => '',
                'price' => 350000,
                'category_id' => 1,
            ],
            [
                'license_number' => $faker->numerify('AB4###UZ'),
                'name' => 'Yaris TRD',
                'image' => '',
                'price' => 325000,
                'category_id' => 1,
            ],
            [
                'license_number' => $faker->numerify('AB5###UZ'),
                'name' => 'Veloz',
                'image' => '',
                'price' => 350000,
                'category_id' => 1,
            ],
            [
                'license_number' => $faker->numerify('AB6###UZ'),
                'name' => 'CRV',
                'image' => '',
                'price' => 350000,
                'category_id' => 4,
            ],
            [
                'license_number' => $faker->numerify('AB7###UZ'),
                'name' => 'Accord',
                'image' => '',
                'price' => 375000,
                'category_id' => 4,
            ],
            [
                'license_number' => $faker->numerify('AB8###UZ'),
                'name' => 'Civic Type R',
                'image' => '',
                'price' => 400000,
                'category_id' => 4,
            ],
            [
                'license_number' => $faker->numerify('AB1###UZ'),
                'name' => 'Serena',
                'image' => '',
                'price' => 350000,
                'category_id' => 5,
            ],
            [
                'license_number' => $faker->numerify('AB2###UZ'),
                'name' => 'Xpander',
                'image' => '',
                'price' => 300000,
                'category_id' => 3,
            ],
            [
                'license_number' => $faker->numerify('AB3###UZ'),
                'name' => 'Terios',
                'image' => '',
                'price' => 300000,
                'category_id' => 2,
            ],
            [
                'license_number' => $faker->numerify('AB4###UZ'),
                'name' => 'C300',
                'image' => '',
                'price' => 300000,
                'category_id' => 6,
            ],
        ];

        Vehicle::insert($vehicles);
    }
}
