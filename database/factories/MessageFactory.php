<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    protected $model = \App\Models\Message::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thread_id' => \App\Models\Thread::factory(),
            'role' => $this->faker->randomElement(['user', 'assistant', 'system']),
            'content' => [
                'content' => $this->faker->text(),
            ],
        ];
    }
}
