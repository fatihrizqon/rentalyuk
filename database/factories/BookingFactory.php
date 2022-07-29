<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vehicle; 
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition()
    { 
        return [
            'code' => Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis'),
            'user_id' => $this->faker->numberBetween(1, User::count()),
            'vehicle_id' => $this->faker->numberBetween(1, Vehicle::count()),
            'from' => $this->faker->dateTimeBetween('-12 month', 'today'),
            'to' => $this->faker->dateTimeBetween('+2 week', '+8 week'),
            'price' => ($this->faker->randomDigitNotNull() * 100000),
            'status' => $this->faker->numberBetween(0, 1),
            'created_at' => $this->faker->dateTimeBetween('-12 month', 'today'),
            'updated_at' => $this->faker->dateTimeBetween('-12 month', 'today'),
        ];
    }
}
