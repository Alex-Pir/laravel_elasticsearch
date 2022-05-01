@extends('app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Articles <small>({{ $articles->count() }})</small>
            </div>
            <div class="card-body">
                @forelse ($articles as $article)
                    <div class="mb-3">
                        <h2>{{ $article->title }}</h2>
                        <p class="m-0">{{ $article->body }}</p>
                        <div>
                            @foreach ($article->tags as $tag)
                                <span class="badge badge-light">{{ $tag}}</span>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p>No articles found</p>
                @endforelse
            </div>
        </div>
    </div>
@stop
