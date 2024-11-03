<?php

namespace Tests\Unit;

use App\Models\Models\Author;
use App\Services\AuthorServices;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase;

    private AuthorServices $authorService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorService = app(AuthorServices::class);
    }

    public function test_can_create_author(): void
    {
        $authorData = [
            'name' => 'John Doe',
            'bio' => 'A great writer',
            'birth_date' => '1990-01-01'
        ];

        $author = $this->authorService->createAuthor($authorData);
        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals($authorData['name'], $author->name);
        $this->assertEquals($authorData['bio'], $author->bio);
        $this->assertEquals($authorData['birth_date'], $author->birth_date);
    }

    public function test_can_update_author(): void
    {
        Author::factory()
        ->count(3)
        ->create();

        $updatedAuthorData = [
            'name' => 'John Doe Edit',
            'bio' => 'A great writer edit',
            'birth_date' => '1990-01-02'
        ];

        $updateAuthor = $this->authorService->updateAuthor(Author::inRandomOrder()->value('id'), $updatedAuthorData);
        $this->assertEquals($updatedAuthorData['name'], $updateAuthor->name);
        $this->assertEquals($updatedAuthorData['bio'], $updateAuthor->bio);
        $this->assertEquals($updatedAuthorData['birth_date'], $updateAuthor->birth_date);
    }

    public function test_can_delete_author(): void
    {
        Author::factory()
        ->count(3)
        ->create();

        $author_id = Author::inRandomOrder()->value('id');

        $deleteAuthor = $this->authorService->deleteAuthor($author_id);
        $this->assertFalse(Author::where('id', $author_id)->exists());
    }

    public function test_http_can_retrieve_authors(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(3)
        ->create();

        $response = $this->get('/authors');
        $response->assertStatus(200);

        $author = Author::inRandomOrder()->first();

        // Random Author
        $response2 = $this->get("/authors/{$author->id}");
        $response2->assertStatus(200);

        // Retrieve Author By Book
        $response3 = $this->get("/authors/{$author->id}/books");
        $response3->assertStatus(200);
    }

    public function test_http_can_create_author(): void
    {
        $data = [
            'name' => fake()->name,
            'bio' => fake()->paragraph(),
            'birth_date' => fake()->date()
        ];

        $response = $this->post('/authors', $data);
        $response->assertStatus(200);
    }

    public function test_http_can_update_author(): void
    {
        Author::factory()
        ->count(2)
        ->create();

        $author = Author::inRandomOrder()->first();

        $data = [
            'name' => fake()->name,
            'bio' => fake()->paragraph(),
            'birth_date' => fake()->date()
        ];

        $response = $this->put("/authors/{$author->id}", $data);
        $response->assertStatus(200);
    }

    public function test_http_can_delete_author(): void
    {
        Author::factory()
        ->count(2)
        ->create();

        $author = Author::inRandomOrder()->first();

        $response = $this->delete("/authors/{$author->id}");
        $response->assertStatus(200);
    }

    public function test_http_can_validate_create_author(): void
    {
        $data = [
            'name' => null,
            'bio' => fake()->paragraph(),
            'birth_date' => fake()->date()
        ];

        $response = $this->post('/authors', $data);
        $response->assertStatus(400);

        $data['name'] = fake()->name;
        $data['bio'] = null;

        $response2 = $this->post('/authors', $data);
        $response2->assertStatus(400);

        $data['bio'] = fake()->paragraph();
        $data['birth_date'] = null;

        $response3 = $this->post('/authors', $data);
        $response3->assertStatus(400);

        $data['birth_date'] = 'test';

        $response4 = $this->post('/authors', $data);
        $response4->assertStatus(400);
    }

    public function test_http_can_validate_update_author(): void
    {

        Author::factory()
        ->count(3)
        ->create();

        $author = Author::inRandomOrder()->first();
        $author_id = $author->id;

        $data = [
            'name' => null,
            'bio' => fake()->paragraph(),
            'birth_date' => fake()->date()
        ];

        $response = $this->put("/authors/{$author_id}", $data);
        $response->assertStatus(400);

        $data['name'] = fake()->name;
        $data['bio'] = null;

        $response2 = $this->put("/authors/{$author_id}", $data);
        $response2->assertStatus(400);

        $data['bio'] = fake()->paragraph();
        $data['birth_date'] = null;

        $response3 = $this->put("/authors/{$author_id}", $data);
        $response3->assertStatus(400);

        $data['birth_date'] = 'test';

        $response4 = $this->put("/authors/{$author_id}", $data);
        $response4->assertStatus(400);

        // Should allow same name, different bio
        $dataValid = [
            'name' => $author->name,
            'bio' => fake()->paragraph(),
            'birth_date' => $author->birth_date,
        ];

        $responseValid = $this->put("/authors/{$author_id}", $dataValid);
        $responseValid->assertStatus(200);
    }

    public function test_http_can_validate_delete_author(): void
    {
        Author::factory()
        ->hasBooks()
        ->count(2)
        ->create();

        $author = Author::inRandomOrder()->first();

        $response = $this->delete("/authors/{$author->id}");
        $response->assertStatus(500);
    }
}
