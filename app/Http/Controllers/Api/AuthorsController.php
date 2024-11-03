<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorInsertRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Services\AuthorServices;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    //
    private AuthorServices $authorService;

    public function __construct(AuthorServices $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        try {
            //code...
            $authors = $this->authorService->getAllAuthor();
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
            $author = $this->authorService->getAuthorById($id);
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

    public function create(AuthorInsertRequest $request)
    {
        try {
            //code...
            $author = $this->authorService->createAuthor($request->validated());
            return response()->json(['status' => 'ok', 'message' => 'Successfully Create New Author'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Saving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function update(AuthorUpdateRequest $request, int $id)
    {
        try {
            //code...
            $author = $this->authorService->updateAuthor($id, $request->validated());
            return response()->json(['status' => 'ok', 'message' => 'Successfully Update Author'], 200);
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
            $author = $this->authorService->deleteAuthor($id);
            return response()->json(['status' => 'ok', 'message' => 'Successfully Delete Author'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Saving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }

    public function findBookByAuthorId(int $author_id)
    {
        try {
            //code...
            $books = $this->authorService->findBookByAuthor($author_id);
            return response()->json(['status' => 'ok', 'count' => $books->count(), 'data' => $books], 200);
        } catch (\Throwable $th) {
            //throw $th;
            $error = $th->getMessage();

            if(!env("APP_DEBUG")) {
                $error = "Failed Retrieving Data";
            }

            return response()->json(['status' => 'error', $error], 500);
        }
    }
}
