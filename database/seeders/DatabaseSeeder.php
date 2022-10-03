<?php

namespace Database\Seeders;
 
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {  
        $user = User::create([
            'id'                => 0,
            'username'          => 'Admin',
            'name'              => 'Administrator',
            'email'             => 'admin@rentalyuk.id',
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
