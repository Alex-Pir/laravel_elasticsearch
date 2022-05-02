<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Интерфейс предназначен для описания способа сохранения
 * изменений за один раз
 */
interface IUnitOfWork {

    /**
     * Вносит изменения
     *
     * @return bool
     */
    public function commit(): bool;

    /**
     * Отмечает модель как новую
     *
     * @param Model $model
     * @return mixed
     */
    public function addNew(Model $model);

    /**
     * Отмечает модель как измененную
     *
     * @param Model $model
     * @return mixed
     */
    public function addDirty(Model $model);

    /**
     * Отмечает модель как удаляемую
     *
     * @param Model $model
     * @return mixed
     */
    public function addDelete(Model $model);
}
