<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\SDK\Infrastructure\EloquentMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_create_a_message(): void
    {
        $messageRepository = new EloquentMessage();

        $content = [
            'content' => 'Hello world',
        ];

        $thread = Thread::factory()->create();

        $message = $messageRepository->create(
            $thread->getKey(),
            'user',
            $content
        );

        $this->assertDatabaseHas('messages', [
            'id' => $message->getId(),
            'thread_id' => $thread->getKey(),
            'role' => 'user',
        ]);
    }
}
