<?php
namespace App\Repositories;

use App\DTO\ArticleDto;
use App\DTO\IDto;
use stdClass;

class ArticleRepository extends BaseSQLRepository {

    protected function getTable(): string {
        return 'articles';
    }

    protected function getDtoModel(stdClass $model): IDto {
        return new ArticleDto($model);
    }
}
