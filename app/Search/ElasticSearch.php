<?php
namespace App\Search;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Collection;

class ElasticSearch implements ISearch {

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch) {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = ''): Collection {
        // TODO: Implement search() method.
    }
}
