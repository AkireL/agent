<?php

namespace App\SDK\UseCases;

use App\SDK\Entities\Message;

class CreateMessage
{
    public function __construct() {
    }

    public function execute(
        int $threadId,
        string $role,
        array $message,
        ): Message
    {
        return new Message(
            role: $role,
            content: $message,
            threadId: $threadId
        );
    }
}
