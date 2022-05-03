<?php
namespace App\Repositories;

use App\DTO\IDto;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use stdClass;

/**
 * Базовый класс для работы с SQL репозиторием
 */
abstract class BaseSQLRepository implements IRepository {

    /** @var int количество элементов, получаемых за 1 запрос */
    protected const PAGE_SIZE = 20;

    /** @var IUnitOfWork объект, реализующий сохранение изменений в базе */
    protected IUnitOfWork $unitOfWork;

    public function __construct(IUnitOfWork $unitOfWork) {
        $this->unitOfWork = $unitOfWork;
    }

    public function search(string $query = ''): Collection {
        return DB::table($this->getTable())
            ->where('body', 'like', "%{$query}%")
            ->orWhere('title', 'like', '%{$query}%')
            ->get();
    }

    /**
     * Возвращает элементы с учетом постраничной навигации
     *
     * @return array
     */
    public function getAll(): array {

        $models = DB::table($this->getTable())
            ->paginate(static::PAGE_SIZE);

        foreach ($models as $model) {
            $result[] = $this->getDtoModel($model)
                ->toArray();
        }

        return $result ?? [];
    }

    /**
     * Возвращает элемент по идентификатору
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getById(int $id): array {
        if ($id <= 0) {
            throw new InvalidArgumentException('Id can be >= 0');
        }

        $model = DB::table($this->getTable())
            ->where('id', $id)
            ->first();

        if (!$model) {
            throw new Exception('Can not found data by id');
        }

        return $this->getDtoModel($model)
            ->toArray();
    }

    /**
     * Записывает модель в базу
     *
     * @param Model $model
     * @return void
     */
    public function create(Model $model): void
    {
        $this->unitOfWork->addNew($model);
    }

    /**
     * Изменяет модель в базе
     *
     * @param Model $model
     * @return void
     */
    public function update(Model $model): void
    {
        $this->unitOfWork->addDirty($model);
    }

    /**
     * Удаляет модель из базы
     *
     * @param Model $model
     * @return void
     */
    public function delete(Model $model): void
    {
        $this->unitOfWork->addDelete($model);
    }

    /**
     * Производит все вызванные ранее операции create, update, delete
     *
     * @return bool
     */
    public function saveChanges(): bool
    {
        return $this->unitOfWork->commit();
    }

    /**
     * Возвращает название таблицы,
     * с которой работает класс
     *
     * @return string
     */
    protected abstract function getTable(): string;

    /**
     * Возвращает DTO-объект
     * @see IDto
     *
     * @param stdClass $model
     * @return IDto
     */
    protected abstract function getDtoModel(stdClass $model): IDto;
}
