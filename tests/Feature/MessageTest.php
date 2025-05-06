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

    /**
     * @test
     */
    public function it_return_list_messages(): void
    {
        $thread = Thread::factory()->create();

        $messageRepository = new EloquentMessage();

        $messageRepository->create(
            $thread->getKey(),
            'user',
            [
                'content' => 'Hello world',
            ]
        );

        $messageRepository->create(
            $thread->getKey(),
            'user',
            [
                'content' => 'Lorem ipsum dolor sit amet 1',
            ]
        );

        $messageRepository->create(
            $thread->getKey(),
            'user',
            [
                'content' => 'Lorem ipsum dolor sit amet 2',
            ]
        );

        $messageRepository->create(
            $thread->getKey(),
            'user',
            [
                'content' => 'Lorem ipsum dolor sit amet 3',
            ]
        );

        $messages = $messageRepository->listMessages($thread->getKey());

        var_dump($messages);
        $this->assertCount(4, $messages);
    }
}
