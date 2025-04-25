<?php

namespace App\SDK\Ports;

use App\SDK\Entities\Message;

interface MessageRepositoryInterface
{
    public function create(int $threadId,
    string $role,
    array $message,): Message;
}
