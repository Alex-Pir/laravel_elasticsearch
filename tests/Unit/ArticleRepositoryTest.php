<?php
namespace Tests\Unit;

use App\Repositories\ArticleRepository;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

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
}
