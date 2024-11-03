<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Exception;

class AuthorServices
{
    private AuthorRepositoryInterface $authorRepo;

    public function __construct(AuthorRepositoryInterface $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }

    public function getAllAuthor()
    {
        return $this->authorRepo->getAll();
    }

    public function getAuthorById(int $id)
    {
        return $this->authorRepo->findById($id);
    }

    public function createAuthor(array $data)
    {
        return $this->authorRepo->create($data);
    }

    public function updateAuthor(int $id, array $data)
    {
        return $this->authorRepo->update($id, $data);
    }

    public function deleteAuthor(int $id)
    {
        if($this->authorRepo->hasBooks($id)) {
            throw new Exception("Cannot Delete Author With Existing Book(s)");
        }

        return $this->authorRepo->delete($id);
    }

    public function findBookByAuthor(int $author_id)
    {
        return $this->authorRepo->findBookByAuthorId($author_id);
    }
}
