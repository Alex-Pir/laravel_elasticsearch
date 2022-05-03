<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Интерфейс предназначен для классов,
 * реализующих работу с источниками данных
 */
interface IRepository {

    /**
     * Возвращает все элементы
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Возвращает элемент по идентификатору
     *
     * @param int $id
     * @return array
     */
    public function getById(int $id): array;

    /**
     * Записывает модель в хранилище
     *
     * @param Model $model
     * @return void
     */
    public function create(Model $model): void;

    /**
     * Изменяет модель в хранилище
     *
     * @param Model $model
     * @return void
     */
    public function update(Model $model): void;

    /**
     * Удаляет модель из хранилища
     *
     * @param Model $model
     * @return void
     */
    public function delete(Model $model): void;

    /**
     * Производит все вызванные ранее операции create, update, delete
     *
     * @return bool
     */
    public function saveChanges(): bool;
}
