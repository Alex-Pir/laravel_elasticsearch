<?php
namespace App\Providers;

use App\Http\Controllers\ArticlesController;
use App\Repositories\ArticleRepository;
use App\Repositories\IRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->when(ArticlesController::class)
            ->needs(IRepository::class)
            ->give(ArticleRepository::class);
    }
}
