<?php

namespace App\Http\Controllers;

use App\Repositories\IRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ArticlesController extends Controller
{
    protected IRepository $repository;

    public function __construct(IRepository $repository) {
        $this->repository = $repository;
    }

    public function index(Request $request) {
        $repository = $this->repository;

        $currentPage = $request->input('page');

        $articles = Cache::remember(md5(serialize(['articles', $currentPage])), 3600, function() use ($repository) {
            return $repository->getAll();
        });

        return Inertia::render('Articles', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'articles' => $articles
        ]);
    }
}
