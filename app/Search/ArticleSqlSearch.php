<?php
namespace App\Search;

use App\Models\Article;
use Illuminate\Support\Collection;

class ArticleSqlSearch implements ISearch {

    public function search(string $query = ''): Collection {
        return Article::query()
            ->where('body', 'like', "%{$query}%")
            ->orWhere('title', 'like', '%{$query}%')
            ->get();
    }

}
