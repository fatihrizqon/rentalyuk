<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        $user = User::create([
            'username'          => 'Admin',
            'name'              => 'Administrator',
            'email'             => 'test@example.com',
            'password'          => Hash::make('123123'),
            'image'             => 'users/avatar.png',
            'phone'             => '+62',
            'address'           => 'System',
            'email_verified_at' => Carbon::now()
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);

        $this->call([CategorySeeder::class]);
        $this->call([VehicleSeeder::class]);
    }
}
