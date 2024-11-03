<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookInsertRequest;
use App\Services\BookServices;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    //
    private BookServices $bookService;

    public function __construct(BookServices $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        try {
            //code...
            $authors = $this->bookService->getAllBooks();
            return response()->json(['status' => 'ok', 'count' => $authors->count(), 'data' => $authors], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Retrieving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function findById(int $id)
    {
        try {
            //code...
            $author = $this->bookService->getBookById($id);
            return response()->json(['status' => 'ok', 'count' => 1, 'data' => $author], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Retrieving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function create(BookInsertRequest $request)
    {
        try {
            //code...
            $author = $this->bookService->createBook($request->validated());
            return response()->json(['status' => 'ok', 'message' => 'Successfully Create New Book'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Saving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function update(BookInsertRequest $request, int $id)
    {
        try {
            //code...
            $author = $this->bookService->updateBook($id, $request->validated());
            return response()->json(['status' => 'ok', 'message' => 'Successfully Update Book'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Saving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function delete(int $id)
    {
        try {
            //code...
            $author = $this->bookService->deleteBook($id);
            return response()->json(['status' => 'ok', 'message' => 'Successfully Delete Book'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Saving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }
}
