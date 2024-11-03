<?php

namespace Database\Factories;

use App\Models\Models\Author;
use App\Models\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BooksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Book::class;

    public function definition(): array
    {
        return [
            //
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Author::inRandomOrder()->value('id')
        ];
    }
}
