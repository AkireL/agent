<?php

use App\SDK\UseCases\CreateMessage;
use App\SDK\UseCases\CreateOrRetrieveThread;

class Agent
{
    public function __construct(private int $clientId, private string $systemPrompt, private $tools)
    {
    }

    public function run($message, $threadId)
    {

        $thread = new CreateOrRetrieveThread($this->clientId)
           ->execute($threadId);

        $message = new CreateMessage()
            ->execute(
                $thread->getId(),
                'user',
                [
                    'content' => $message,
                ]
            );
        // TODO Implement Runner


    }
}
