<?php
namespace Tests\Unit;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\UnitOfWork;
use Exception;
use Illuminate\Foundation\Testing\TestCase;
use InvalidArgumentException;
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
        $articleRepository = new ArticleRepository(new UnitOfWork());

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
        $articleRepository = new ArticleRepository(new UnitOfWork());
        $id = PHP_INT_MAX;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Can not found data by id');

        $articleRepository->getById($id);
    }

    /**
     * Тест проверяет, вылетает ли исключение в случае,
     * когда передан отрицательный идентификатор
     *
     * @return void
     * @throws Exception
     */
    public function test_get_article_by_id_argument_exception() {
        $articleRepository = new ArticleRepository(new UnitOfWork());
        $id = -1;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Id can be >= 0');

        $articleRepository->getById($id);
    }

    /**
     * Тест проверяет работоспособность метода получения статьи по идентификатору
     *
     * @return void
     * @throws Exception
     */
    public function test_get_article_by_id_success() {
        $articleRepository = new ArticleRepository(new UnitOfWork());
        $id = 1;

        $article = $articleRepository->getById($id);

        $this->assertIsArray($article);
        $this->assertEquals($id, $article['id']);
    }

    /**
     * Тест проверяет сохранение, изменение, удаление статьи
     *
     * @return void
     * @throws Exception
     */
    public function test_create_update_delete_article_success() {
        $article = new Article();
        $repository = new ArticleRepository(new UnitOfWork());

        $article->title = 'Test article title';
        $article->body = 'Test article description';
        $article->tags = ['tag1', 'tag2'];

        // Add
        $repository->create($article);
        $result = $repository->saveChanges();
        $this->assertEquals(true, $result);
        $this->assertIsInt($article->id);

        // Update
        $article->body = 'Test article description after update';
        $repository->update($article);
        $repository->saveChanges();
        $article->refresh();
        $this->assertEquals('Test article description after update', $article->body);

        // Delete
        $repository->delete($article);
        $result = $repository->saveChanges();
        $this->assertEquals(true, $result);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Can not found data by id');
        $repository->getById($article->id);
    }
}
