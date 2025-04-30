<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Runner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RunnerStateFactory extends Factory
{
    protected $model = \App\Models\RunnerState::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "runner_id" => Runner::factory()->create(),
            "message_id" => Message::factory()->create(),
            "state" => $this->faker->randomElement([
                'completed',
                'in_progress',
                'required_action',
            ]),
        ];
    }
}
