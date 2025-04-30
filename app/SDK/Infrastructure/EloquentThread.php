<?php

namespace App\SDK\Infrastructure;

use App\Models\Client;
use App\SDK\Entities\Thread;
use App\SDK\Ports\ThreadRepositoryInterface;

class EloquentThread implements ThreadRepositoryInterface
{
    public function createOrRetrieve(int $clientId, ?int $threadId): Thread
    {
        $client = Client::findOrFail($clientId);
        if ($threadId) {
            $thread = $client->threads()->find($threadId);

            if ($thread) {
                return new Thread($thread->id, $client->id);
            }
        }

        $thread = $client->threads()->create();

        return new Thread($thread->id, $client->id);
    }

}
