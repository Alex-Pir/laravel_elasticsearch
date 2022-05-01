<?php
namespace App\DTO;

use InvalidArgumentException;
use stdClass;

class ArticleDto implements IDto {

    protected int $id;
    protected string $title;
    protected string $body;
    protected array $tags;

    public function __construct(stdClass $model) {

        if (!$model->id) {
            throw new InvalidArgumentException('Can not find Id');
        }

        $this->id = $model->id;
        $this->title = $model->title;
        $this->body = $model->body;
        $this->tags = is_string($model->tags)
            ? json_decode($model->tags)
            : $model->tags;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
        ];
    }
}
