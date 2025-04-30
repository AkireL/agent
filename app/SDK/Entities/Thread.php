<?php

namespace App\SDK\Entities;

class Thread
{
    private int $id;
    private int $clientId;

    public function __construct(int $id, int $clientId)
    {
        $this->id = $id;
        $this->clientId = $clientId;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }
}
