<?php

namespace App\SDK\Infrastructure;

use App\SDK\Entities\Message;

class EloquentMessage implements \App\SDK\Ports\MessageRepositoryInterface
{
    public function create(int $threadId,
    string $role,
    array $message,): Message
    {
        $message = \App\Models\Message::create([
            'thread_id' => $threadId,
            'role' => $role,
            'content' => $message,
        ]);

        return new Message(
            role: $message->role,
            content: json_decode($message->content, true),
            threadId: $message->thread_id
        );
    }

}
