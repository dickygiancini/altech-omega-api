<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\AuthorsController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Middleware\AddressExistMiddleware;
use App\Http\Middleware\CustomerExistMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return response()->json('Loaded successfully. Laravel version : '. Illuminate\Foundation\Application::VERSION .". Running PHP : ". PHP_VERSION );
});

Route::get('/test-api', function() {
    return response()->json(['message' => 'api ok']);
});

// Route::prefix('customer')->group(function () {
//     Route::get('/', [CustomerController::class, 'index']);
//     Route::get('/{id}', [CustomerController::class, 'detail'])->middleware('customerMiddleware');

//     Route::post('/', [CustomerController::class, 'create']);
//     Route::patch('/{id}', [CustomerController::class, 'update'])->middleware('customerMiddleware');
//     Route::delete('/{id}', [CustomerController::class, 'destroy'])->middleware('customerMiddleware');
// });

// Route::prefix('address')->group(function () {
//     Route::post('/', [AddressController::class, 'create']);
//     Route::patch('/{id}', [AddressController::class, 'update'])->middleware('addressMiddleware');
//     Route::delete('/{id}', [AddressController::class, 'destroy'])->middleware('addressMiddleware');
// });

Route::prefix('authors')->group(function() {
    Route::get('/', [AuthorsController::class, 'index']);
    Route::get('/{id}', [AuthorsController::class, 'findById']);
    Route::get('/{id}/books', [AuthorsController::class, 'findBookByAuthorId']);
    Route::post('/', [AuthorsController::class, 'create']);
    Route::put('/{id}', [AuthorsController::class, 'update']);
    Route::delete('/{id}', [AuthorsController::class, 'delete']);
});

Route::prefix('books')->group(function() {
    Route::get('/', [BooksController::class, 'index']);
    Route::get('/{id}', [BooksController::class, 'findById']);
    Route::post('/', [BooksController::class, 'create']);
    Route::put('/{id}', [BooksController::class, 'update']);
    Route::delete('/{id}', [BooksController::class, 'delete']);
});
