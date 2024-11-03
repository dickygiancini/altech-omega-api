<?php

namespace App\Repositories;

use App\Models\Models\Author;
use App\Models\Models\Book;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface {
    private Author $model;
    private Book $book;

    public function __construct(Author $model, Book $book)
    {
        $this->model = $model;
        $this->book = $book;
    }

    public function getAll()
    {
        return $this->model->with(['books'])->get();
    }

    public function findById(int $id)
    {
        return $this->model->with(['books'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $author = $this->findById($id);
        $author->update($data);
        return $author;
    }

    public function delete(int $id)
    {
        $author = $this->findById($id);
        return $author->delete();
    }

    public function hasBooks(int $id): bool
    {
        return $this->findById($id)->books()->exists();
    }

    public function findBookByAuthorId(int $id)
    {
        return $this->book->with(['author'])->where('author_id', $id)->get();
    }
}
