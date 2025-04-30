<?php

namespace App\SDK\Ports;

use App\SDK\Entities\Thread;

interface ThreadRepositoryInterface
{
    public function createOrRetrieve(int $clientId, ?int $threadId): Thread;
}
