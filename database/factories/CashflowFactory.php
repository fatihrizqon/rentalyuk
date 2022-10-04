<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cashflow>
 */
class CashflowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'code' => Str::upper(Str::random(6)) . Carbon::now()->format('YmdHis'),
            'name' => $user->name,
            'user_id' => $user->id,
            'type' => $this->faker->randomElement(['Debit', 'Credit']),
            'value'=> ($this->faker->randomDigitNotNull() * 100000),
            'created_at' => $this->faker->dateTimeBetween('-12 month', 'today'),
            'updated_at' => $this->faker->dateTimeBetween('-12 month', 'today'),
        ];
    }
}
