<?php

namespace App\Repositories;

use App\Models\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface {
    private Book $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('author')->get();
    }

    public function findById(int $id)
    {
        return $this->model->with('author')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $book = $this->findById($id);
        $book->update($data);
        return $book;
    }

    public function delete(int $id)
    {
        $book = $this->findById($id);
        return $book->delete();
    }

    public function findByAuthorId(int $authorId)
    {
        return $this->model->where('author_id', $authorId)->get();
    }
}
