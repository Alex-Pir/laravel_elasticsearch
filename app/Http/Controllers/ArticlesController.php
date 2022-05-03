<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Requests\CreateArticlePostRequest;
use App\Models\Article;
use App\Repositories\IRepository;
use App\Search\ISearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia;

/**
 * Контроллер для работы со статьями
 */
class ArticlesController extends Controller
{
    /** @var IRepository объект репозитория для работы с хранилищем статей */
    protected IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Получает статьи и передает их vue-компоненту
     *
     * @param Request $request
     * @return Inertia\Response
     */
    public function index(Request $request): Inertia\Response
    {
        $currentPage = $request->input('page');

        $articles = Cache::remember(
            md5(serialize(['articles', $currentPage])),
            Constants::CACHE_TIME_SHORT,
            function() {
                return $this->repository->getAll();
            }
        );

        return Inertia\Inertia::render('Articles', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'articles' => $articles
        ]);
    }

    /**
     * @param CreateArticlePostRequest $request
     * @return bool
     */
    public function create(CreateArticlePostRequest $request): bool {
        $data = $request->validated();

        $article = new Article();
        $article->fill($data);

        $this->repository->create($article);
        $this->repository->saveChanges();

        return isset($article->id);
    }

    public function search(Request $request, ISearch $search): array {
        $query = $request->input('q');

        if (!trim($query)) {
            return [];
        }

        $searchResult = $search->search($query);

        return array_values(
            $searchResult->toArray()
        );
    }
}
