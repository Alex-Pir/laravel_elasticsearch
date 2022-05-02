<?php
namespace App\Repositories;

interface IRepository {
    public function getAll(): array;
    public function getById(int $id): array;
}
