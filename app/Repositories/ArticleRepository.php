<?php
namespace App\Repositories;

use App\DTO\ArticleDto;
use App\DTO\IDto;
use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * SQL репозиторий для работы со статьями
 */
class ArticleRepository extends BaseSQLRepository {

    /**
     * Возвращает название таблицы статей
     *
     * @return string
     */
    protected function getTable(): string {
        return 'articles';
    }

    /**
     * Возвращает DTO-объект статьи
     *
     * @param stdClass $model
     * @return IDto
     */
    protected function getDtoModel(stdClass $model): IDto {
        return new ArticleDto($model);
    }
}
