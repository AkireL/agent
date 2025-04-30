<?php

namespace Tests\Feature;

use App\Models\Runner;
use App\Models\Thread;
use App\SDK\Infrastructure\EloquentRunnerState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RunnerStateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_create_a_runner_state(): void
    {
        $runnerId = Runner::factory()->create()->getKey();

        $thread = Thread::factory()->create();

        $message = \App\Models\Message::factory()->create([
            'thread_id' => $thread->getKey(),
        ]);

        $runnerStateRepository = new EloquentRunnerState();

        $runnerStateRepository->create(
            $runnerId,
            $message->getKey()
        );

        $this->assertDatabaseHas('runner_states', [
            'runner_id' => $runnerId,
            'message_id' => $message->getKey(),
        ]);
    }
}
