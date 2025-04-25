<?php

namespace App\SDK\Ports;

use App\SDK\Thread;

interface ThreadRepositoryInterface
{
    public function createOrRetrieve(int $clientId, ?int $threadId): Thread;
}
