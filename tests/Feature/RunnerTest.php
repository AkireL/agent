<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Thread;
use App\SDK\Infrastructure\EloquentRunner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RunnerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_create_a_runner(): void
    {
        $client = Client::factory()->create();
        $clientId = $client->getKey();

        $thread = Thread::factory()->create([
            'client_id' => $clientId,
        ]);

        $runnerRepository = new EloquentRunner();

        $runnerId = $runnerRepository->getOrCreate($thread->getKey(), null);

        $this->assertDatabaseHas('runners', [
            'id' => $runnerId,
            'thread_id' => $thread->getKey(),
        ]);
    }
}
