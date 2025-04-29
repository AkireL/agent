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
            content: $message->content,
            threadId: $message->thread_id
        );
    }

    public function listMessages(int $threadId): array
    {
        $messages = \App\Models\Message::where('thread_id', $threadId)->get();

        return $messages->map(function ($message) {
            $data = [];
            $content = $message->content;

            $data['role'] = $message->role;

            if (array_key_exists('content', $content)) {
                $data['content'] = $content['content'];

                return $data;
            }

            if (array_key_exists('tool_call', $content)) {
                $data['tool_call'] = $content['tool_call'];
                return $data;
            }
            $data['content'] = $content;

            return $data;
        })->toArray();
    }
}
