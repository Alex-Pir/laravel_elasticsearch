<?php
namespace Tests\Unit;

use App\Models\Article;
use App\Repositories\UnitOfWork;
use Illuminate\Foundation\Testing\TestCase;
use Tests\CreatesApplication;

/**
 * Тестирование класса @see UnitOfWork
 */
class UnitOfWorkTest extends TestCase {
    use CreatesApplication;

    /**
     * Тест проверяет работоспособность сохранения, изменения и удаления данных через UnitOfWork
     *
     * @return void
     * @throws \App\Repositories\Exceptions\UnitOfWorkException
     * @throws \Throwable
     */
    public function test_unit_of_work_success() {
        $article = new Article();
        $unitOfWork = new UnitOfWork();

        $article->title = 'Test article title';
        $article->body = 'Test article description';
        $article->tags = ['tag1', 'tag2'];

        // Add
        $unitOfWork->addNew($article);
        $result = $unitOfWork->commit();
        $this->assertEquals(true, $result);
        $this->assertIsInt($article->id);

        // Update
        $article->body = 'Test article description after update';
        $unitOfWork->addDirty($article);
        $unitOfWork->commit();
        $article->refresh();
        $this->assertEquals('Test article description after update', $article->body);

        // Delete
        $unitOfWork->addDelete($article);
        $result = $unitOfWork->commit();
        $this->assertEquals(true, $result);
        $article = Article::query()->find($article->id);
        $this->assertEquals(null, $article);
    }
}
