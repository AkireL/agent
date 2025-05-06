<?php

namespace App\SDK\Infrastructure;

use App\Models\Message as ModelsMessage;
use App\SDK\Entities\Message;
use App\SDK\Ports\MessageRepositoryInterface;

class EloquentMessage implements MessageRepositoryInterface
{
    public function create(int $threadId,
    string $role,
    array $message): Message
    {
        $message = ModelsMessage::create([
            'thread_id' => $threadId,
            'role' => $role,
            'content' => $message,
        ]);

        return new Message(
            id: $message->id,
            role: $message->role,
            content: $message->content,
            threadId: $message->thread_id
        );
    }

    public function listMessages(int $threadId): array
    {
        $messages = ModelsMessage::query()
            ->where('thread_id', $threadId)
            ->orderBy('id', 'asc')
            ->get();

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
        })
        ->toArray();
    }
}
