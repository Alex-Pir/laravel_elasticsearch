<?php
namespace App\Providers;

use App\Search\ArticleElasticSearch;
use App\Search\ArticleSqlSearch;
use App\Search\ISearch;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind(ISearch::class, function() {
            if (!config('services.search.enabled')) {
                return new ArticleSqlSearch();
            }

            return new ArticleElasticSearch(
                $this->app->make(Client::class)
            );
        });

        $this->app->bind(Client::class, function($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }
}
