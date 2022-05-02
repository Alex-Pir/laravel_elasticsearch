<?php
namespace Tests\Unit;

use App\Repositories\ArticleRepository;
use Exception;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

/**
 * Тестирование класса @see ArticleRepository
 */
class ArticleRepositoryTest extends TestCase {
    use CreatesApplication;

    /**
     * Тест проверяет получение всех статей через репозиторий
     *
     * @return void
     */
    public function test_get_all_articles() {
        $articleRepository = new ArticleRepository();

        $articles = $articleRepository->getAll();

        $this->assertIsArray($articles);

        $article = current($articles);
        $this->assertIsInt($article['id']);
    }

    /**
     * Тест проверяет, вылетает ли исключение в случае,
     * когда невозможно получить статью по id
     *
     * @return void
     * @throws Exception
     */
    public function test_get_article_by_id_not_found() {
        $articleRepository = new ArticleRepository();
        $id = PHP_INT_MAX;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Can not found data by id');

        $articleRepository->getById($id);
    }

    /**
     * Тест проверяет работоспособность метода получения статьи по идентификатору
     *
     * @return void
     * @throws Exception
     */
    public function test_get_article_by_id_success() {
        $articleRepository = new ArticleRepository();
        $id = 1;

        $article = $articleRepository->getById($id);

        $this->assertIsArray($article);
        $this->assertEquals($id, $article['id']);
    }
}
