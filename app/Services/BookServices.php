<?php

namespace App\Services;

use App\Repositories\Interfaces\BookRepositoryInterface;

class BookServices
{
    private BookRepositoryInterface $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function getAllBooks()
    {
        return $this->bookRepo->getAll();
    }

    public function getBookById(int $id)
    {
        return $this->bookRepo->findById($id);
    }

    public function createBook(array $data)
    {
        return $this->bookRepo->create($data);
    }

    public function updateBook(int $id, array $data)
    {
        return $this->bookRepo->update($id, $data);
    }

    public function deleteBook(int $id)
    {
        return $this->bookRepo->delete($id);
    }

    public function findByAuthorId(int $author_id)
    {
        return $this->bookRepo->findByAuthorId($author_id);
    }
}
