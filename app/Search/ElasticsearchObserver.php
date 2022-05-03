<?php
namespace App\Search;

use App\Jobs\ProcessIndex;

class ElasticsearchObserver {
    public function saved($model) {
        ProcessIndex::dispatch($model, ProcessIndex::CREATE_COMMAND);
    }

    public function deleted($model) {
        ProcessIndex::dispatch($model, ProcessIndex::DELETE_COMMAND);
    }
}
