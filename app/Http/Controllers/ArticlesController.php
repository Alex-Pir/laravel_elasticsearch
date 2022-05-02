<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Repositories\IRepository;
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
        $repository = $this->repository;

        $currentPage = $request->input('page');

        $articles = Cache::remember(
            md5(serialize(['articles', $currentPage])),
            Constants::CACHE_TIME_SHORT,
            function() use ($repository) {
                return $repository->getAll();
            }
        );

        return Inertia\Inertia::render('Articles', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'articles' => $articles
        ]);
    }
}
