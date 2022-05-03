<?php

namespace App\Jobs;

use App\Models\Article;
use Elastic\Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const CREATE_COMMAND = "create";
    const DELETE_COMMAND = "delete";

    protected Model $model;
    protected string $command;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Model $model, string $command)
    {
        $this->model = $model->withoutRelations();
        $this->command = $command;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Client $elasticsearch)
    {
        switch ($this->command) {
            case static::CREATE_COMMAND:
                $elasticsearch->index([
                    'index' => $this->model->getSearchIndex(),
                    'type' => $this->model->getSearchType(),
                    'id' => $this->model->getKey(),
                    'body' => $this->model->toSearchArray(),
                ]);
                break;
            case static::DELETE_COMMAND:
                $elasticsearch->delete([
                    'index' => $this->model->getSearchIndex(),
                    'type' => $this->model->getSearchType(),
                    'id' => $this->model->getKey()
                ]);
                break;
            default:
                //nothing
        }
    }
}
