<?php

namespace App\Repositories\Interfaces;

interface AuthorRepositoryInterface {
    public function getAll();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function hasBooks(int $id): bool;
    public function findBookByAuthorId(int $id);
}
