<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->text(),
            'tags' => collect(['php', 'ruby', 'java', 'javascript', 'bash'])
                ->random(2)
                ->values()
                ->all()
        ];
    }
}
