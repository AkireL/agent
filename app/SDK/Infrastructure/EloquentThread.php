<?php

namespace App\SDK\Infrastructure;

use App\Models\Client;

class EloquentThread implements \App\SDK\Ports\ThreadRepositoryInterface
{
    public function createOrRetrieve(int $clientId, ?int $threadId): \App\SDK\Thread
    {
        $client = Client::findOrFail($clientId);
        if ($threadId) {
            $thread = $client->threads()->find($threadId);

            if ($thread) {
                return new \App\SDK\Thread($thread->id, $client->id);
            }
        }

        $thread = $client->threads()->create();

        return new \App\SDK\Thread($thread->id, $client->id);
    }

}
