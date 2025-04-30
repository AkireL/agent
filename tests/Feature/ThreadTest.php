<?php

namespace Tests\Feature;

use App\Models\Client;
use App\SDK\Infrastructure\EloquentThread;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * @test
     */
    public function it_create_a_thread(): void
    {
        $client = Client::factory()->create();

        $clientId = $client->id;

        $threadRepository = new EloquentThread();

        $thread = $threadRepository->createOrRetrieve($clientId, null);

        $this->assertDatabaseHas('threads', [
            'id' => $thread->getId(),
            'client_id' => $clientId,
        ]);
    }
}
