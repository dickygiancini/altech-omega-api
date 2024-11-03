## About This Repository

This is a repository for an ongoing recruitment by PT Pasifik Satelit Nusantara, where candidates are required to do backend test based on the provided url. The following stacks are present on this repo:

- Laravel 11 (Latest)
- PHP 8
- Docker (Laravel Sail)
- MySQL

## Reproducing

To reproducre the same result as the development process, please do the following:

1. Cloning the repo:
   ```bash
   git clone https://github.com/dickygiancini/altech-omega-api.git
   cd altech-omega-api
   ```

2. Now, there are multiple ways on installing the dependencies:
   - Using the resular `composer install` way
   ```bash
   composer install
   ```
   You will need composer and php installed in your system

   - Using docker to install laravel sail outside local composer
   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
   ```

   - Build sail (just to be safe)
   ```bash
   ./vendor/bin/sail build --no-cache
   ```

   This command was based on the laravel [documentation](https://laravel.com/docs/11.x/sail#installing-composer-dependencies-for-existing-projects)

3. Setting up

Now, you need to create .env by:
```bash
cp .env.example .env
```
and set up the db connection like this:
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
You also need to run key generate if there are no APP_KEY:
```bash
./vendor/bin/sail artisan key:generate
```

4. Running The Application

To run the application, do the following:
```bash
./vendor/bin/sail artisan migrate:fresh --seed
./vendor/bin/sail artisan serve
```
If running correctly, it should show a string of `"Loaded successfully. Laravel version : 11.X. Running PHP : 8.X"`
The url for the application would be (https://localhost)

## Code Design

The codebase written, is following the SOLID principles, where we make sure, that Controller are doing 1 job and 1 job only (S). Also, if there are any changes to the code, we can add a new Repository and/or add new Validation, without changing anything in the Controllers (O). It also follows Liskov Substitution, where any interface implementation is used (AuthorRepositoryInterface and BookRepositoryInterface) (L). Each Interfaces are generally specific to each of their use cases (I). And also, our high-level modules depends on abstractions (D).

## Using the service

According to the test provided, there are multiple routes are required:
1. GET: /authors
2. GET: /authors/:id
3. POST: /authors
4. PATCH: /authors/:id
5. DELETE: /authors/:id
6. GET: /authors/:id/books
7. GET: /books
8. GET: /books/:id
9. POST: /books
10. PATCH: /books/:id
11. DELETE: /books/:id


To test the routes, you can do:
```bash
curl -X POST http://localhost/{url} \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-d '{your_desired_data}'
```

The url can be replaced with any url provided, and the data passed would depend on the url (if it's a GET /authors or GET /authors/1, then you don't need to pass any data)

## Unit Testing

There are 2 files for the current unit testing, which is `AuthorServiceTest.php` and `BookServiceTest.php` located in `test/Unit` directory. To run the test, please run this command:

```bash
./vendor/bin/sail artisan test
```

## Future Performance Improvement

We can optimize like example, our database by using indexing as follows:
```bash
// database\migrations\create_books_table.php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('author_id')->constrained();
    $table->string('title');
    $table->text('description');
    $table->date('publish_date');
    $table->timestamps();

    // Indexing
    $table->index(['author_id', 'publish_date']);
    $table->index(['title', 'publish_date']);
});
```

We can also, say, adding pagination to the get request so we are not loading every data inside the database
```bash
// app\Repositories\BookRepository.php
public function getAll(int $paginate)
{
    return $this->model->with(['author'])->paginate($paginate);
}
```

Selective select may also improve performace for the select query, since we might not need all data from the relationships
```bash
// app\Repositories\BookRepository.php
public function getAll(int $paginate)
{
    return $this->model->with(['author' => fn($q) => $q->select("author_id", "name", "bio") ])->select("author_id", "title", "description", "publish_date")->paginate($paginate);
}

// or at app\Models\Models\Book.php
protected $hidden = ["created_at", "updated_at"];
```

## Happy Testing!
