<?php

namespace Tests\Unit;

use App\Models\Models\Author;
use App\Models\Models\Book;
use App\Services\BookServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase;

    private BookServices $bookService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookService = app(BookServices::class);
    }

    public function test_can_create_book(): void
    {
        Author::factory()
        ->count(2)
        ->create();

        $bookData = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Author::inRandomOrder()->first()->id,
        ];

        $book = $this->bookService->createBook($bookData);
        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals($bookData['title'], $book->title);
        $this->assertEquals($bookData['description'], $book->description);
        $this->assertEquals($bookData['publish_date'], $book->publish_date);
        $this->assertEquals($bookData['author_id'], $book->author_id);
    }

    public function test_can_update_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $bookData = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Author::inRandomOrder()->first()->id,
        ];

        $book = $this->bookService->updateBook(Book::inRandomOrder()->value('id'), $bookData);
        $this->assertEquals($bookData['title'], $book->title);
        $this->assertEquals($bookData['description'], $book->description);
        $this->assertEquals($bookData['publish_date'], $book->publish_date);
        $this->assertEquals($bookData['author_id'], $book->author_id);
    }

    public function test_can_delete_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $book = Book::inRandomOrder()->first();

        $book = $this->bookService->deleteBook(Book::inRandomOrder()->value('id'));
        $this->assertFalse(Book::where('id', $book)->exists());
    }

    public function test_http_can_retrieve_books(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $response = $this->get('/books');
        $response->assertStatus(200);
    }

    public function test_http_can_create_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $bookData = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Author::inRandomOrder()->first()->id,
        ];

        $response = $this->post('/books', $bookData);
        $response->assertStatus(200);
    }

    public function test_http_can_update_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $book_id = Book::inRandomOrder()->value('id');

        $bookData = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Author::inRandomOrder()->first()->id,
        ];

        $response = $this->put("/books/{$book_id}", $bookData);
        $response->assertStatus(200);
    }

    public function test_http_can_delete_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $book_id = Book::inRandomOrder()->value('id');

        $response = $this->delete("/books/{$book_id}");
        $response->assertStatus(200);
    }

    public function test_http_can_validate_create_book(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(3)
        ->create();

        $data = [
            'title' => null,
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Book::with(['author'])->inRandomOrder()->first()->author->id,
        ];

        $response = $this->post('/books', $data);
        $response->assertStatus(400);

        $data['title'] = fake()->sentence();
        $data['description'] = null;

        $response2 = $this->post('/books', $data);
        $response2->assertStatus(400);

        $data['description'] = fake()->paragraph();
        $data['publish_date'] = null;

        $response3 = $this->post('/books', $data);
        $response3->assertStatus(400);

        $data['publish_date'] = 'test';

        $response4 = $this->post('/books', $data);
        $response4->assertStatus(400);

        $data['publish_date'] = fake()->date();
        $data['author_id'] = null;

        $response5 = $this->post('/books', $data);
        $response5->assertStatus(400);

        // Non existant author_id
        $data['author_id'] = 7234;

        $response6 = $this->post('/books', $data);
        $response6->assertStatus(400);

        // Valid data
        $dataValid = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Book::with(['author'])->inRandomOrder()->first()->author->id,
        ];

        $responseValid = $this->post('/books', $dataValid);
        $responseValid->assertStatus(200);
    }

    public function test_http_can_validate_update_book(): void
    {

        Author::factory()
        ->hasBooks()
        ->count(3)
        ->create();

        $book = Book::inRandomOrder()->first();
        $book_id = $book->id;

        $data = [
            'title' => null,
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Book::with(['author'])->inRandomOrder()->first()->author->id,
        ];

        $response = $this->put("/books/{$book_id}", $data);
        $response->assertStatus(400);

        $data['title'] = fake()->sentence();
        $data['description'] = null;

        $response2 = $this->put("/books/{$book_id}", $data);
        $response2->assertStatus(400);

        $data['description'] = fake()->paragraph();
        $data['publish_date'] = null;

        $response3 = $this->put("/books/{$book_id}", $data);
        $response3->assertStatus(400);

        $data['publish_date'] = 'test';

        $response4 = $this->put("/books/{$book_id}", $data);
        $response4->assertStatus(400);

        $data['publish_date'] = fake()->date();
        $data['author_id'] = null;

        $response5 = $this->post('/books', $data);
        $response5->assertStatus(400);

        // Non existant author_id
        $data['author_id'] = 7234;

        $response6 = $this->post('/books', $data);
        $response6->assertStatus(400);

        // Should allow same name, different bio
        $dataValid = [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'publish_date' => fake()->date(),
            'author_id' => Book::with(['author'])->inRandomOrder()->first()->author->id,
        ];

        $responseValid = $this->put("/books/{$book_id}", $dataValid);
        $responseValid->assertStatus(200);
    }
}
