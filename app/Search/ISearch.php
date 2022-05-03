<?php
namespace App\Search;

use Illuminate\Support\Collection;

interface ISearch {
    public function search(string $query = ''): Collection;
}
