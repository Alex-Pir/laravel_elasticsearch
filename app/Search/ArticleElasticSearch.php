<?php
namespace App\Search;

use App\Models\Article;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ArticleElasticSearch implements ISearch {

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch) {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticSearch($query);
        return $this->buildCollection($items);
    }

    protected function searchOnElasticSearch(string $query = ''): array {
        $model = new Article();

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5', 'body', 'tags'],
                        'query' => $query
                    ]
                ]
            ]
        ])->asArray();
    }

    protected function buildCollection(array $items): Collection {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Article::query()->findMany($ids)
            ->sortBy(function($article) use ($ids) {
                return array_search($article->getKey(), $ids);
            });
    }
}
