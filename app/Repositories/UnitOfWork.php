<?php
namespace App\Repositories;

use App\Repositories\Exceptions\UnitOfWorkException;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Класс предназначен для реализации сохранения
 * всех изменений в базу за один раз
 */
class UnitOfWork implements IUnitOfWork {

    protected array $new;
    protected array $dirty;
    protected array $delete;

    public function __construct() {
        $this->new = [];
        $this->dirty = [];
        $this->delete = [];
    }

    /**
     * Сохраняет изменения в базу
     *
     * @return bool
     * @throws UnitOfWorkException|\Throwable
     */
    public function commit(): bool {
        try {
            return DB::transaction(function() {
                $this->performOperations();
                return true;
            });
        } catch (Exception $ex) {
            try {
                DB::rollBack();
            } catch (Exception $ex) {
                throw new UnitOfWorkException($ex->getMessage());
            }
        }

        return false;
    }

    /**
     * Отмечает модель как новую
     *
     * @param Model $model
     * @return void
     */
    public function addNew(Model $model)
    {
        $this->new[] = $model;
    }

    /**
     * Отмечает модель  как измененную
     *
     * @param Model $model
     * @return void
     */
    public function addDirty(Model $model)
    {
        $this->dirty[] = $model;
    }

    /**
     * Отмечает модель как удаляемую
     *
     * @param Model $model
     * @return void
     */
    public function addDelete(Model $model)
    {
        $this->delete[] = $model;
    }

    /**
     * Производит необходимые операции с базой
     *
     * @return void
     */
    protected function performOperations() {

        /** @var Model $model */
        foreach ($this->new as $model) {
            $model->save();
        }

        /** @var Model $model */
        foreach ($this->dirty as $model) {
            $model->save();
        }

        /** @var Model $model */
        foreach ($this->delete as $model) {
            $model->delete();
        }

        $this->new = [];
        $this->dirty = [];
        $this->delete = [];
    }
}
