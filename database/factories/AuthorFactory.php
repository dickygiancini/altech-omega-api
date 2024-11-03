<?php

namespace Database\Factories;

use App\Models\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Author::class;

    public function definition(): array
    {
        return [
            //
            'name' => fake()->name,
            'bio' => fake()->paragraph(5),
            'birth_date' => fake()->date()
        ];
    }
}
