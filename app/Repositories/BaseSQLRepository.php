<?php
namespace App\Repositories;

use App\DTO\IDto;
use Illuminate\Support\Facades\DB;
use stdClass;

abstract class BaseSQLRepository implements IRepository {

    protected const PAGE_SIZE = 20;

    public function getAll(): array {

        $models = DB::table($this->getTable())
            ->paginate(static::PAGE_SIZE);

        foreach ($models as $model) {
            $result[] = $this->getDtoModel($model)
                ->toArray();
        }

        return $result ?? [];
    }

    public function getById()
    {
        // TODO: Implement getById() method.
    }

    protected abstract function getTable(): string;
    protected abstract function getDtoModel(stdClass $model): IDto;
}
