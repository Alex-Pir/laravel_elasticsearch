<?php
namespace App\Repositories;

use App\DTO\ArticleDto;
use App\DTO\IDto;
use App\Models\Article;
use stdClass;

/**
 * SQL репозиторий для работы со статьями
 */
class ArticleRepository extends BaseSQLRepository {

    private Article $article;

    public function __construct(IUnitOfWork $unitOfWork) {
        parent::__construct($unitOfWork);
        $this->article = new Article();
    }

    /**
     * Возвращает название таблицы статей
     *
     * @return string
     */
    protected function getTable(): string {
        return $this->article->getTable();
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
