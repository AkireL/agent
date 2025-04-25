<?php

namespace App\SDK\UseCases;

use App\SDK\Thread;

class CreateOrRetrieveThread
{
    public function __construct(
        private int $clientId,
    ) {}

    public function execute(?int $threadId): Thread
    {
        // TODO: Logic to create or retrieve a thread
        return new Thread($threadId = 0, $this->clientId);
    }
}
