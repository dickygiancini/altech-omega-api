<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            //
            'title' => fake()->randomElement(['Mr.', 'Mrs.', 'Sir', 'Madam']),
            'name' => fake()->name(),
            'gender' => fake()->randomElement(['M', 'F']),
            'phone_number' => fake()->unique()->e164PhoneNumber(),
            // 'image' => $this->faker->imageUrl(800,600),
            'image' => fake()->imageUrl(800, 600),
            'email' => fake()->email(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
