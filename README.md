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
   git clone https://github.com/dickygiancini/psn-api.git
   cd psn-api
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

## Using the service

According to the test provided, there are multiple routes are required:
1. GET: /customer
2. GET: /customer/:id
3. POST: /customer
4. PATCH: /customer/:id
5. DELETE: /customer/:id
6. PATCH: /address/:id
7. DELETE: /address/:id

To test the routes, you can do:
```bash
curl -X POST http://localhost/{url} \
-H "Accept: application/json" \
-H "Content-Type: application/json" \
-d '{your_desired_data}'
```

The url can be replaced with any url provided, and the data passed would depend on the url (if it's a GET /customer or GET /customer/1, then you don't need to pass any data)

### Unit Testing

There are 2 files for the current unit testing, which is `CustomerTest.php` and `AddressTest.php` located in `test/Feature` directory. To run the test, please run this command:

```bash
./vendor/bin/sail artisan test
```

### Happy Testing!
