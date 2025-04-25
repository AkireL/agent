<?php

namespace App\SDK\Entities;

class Message
{
    public function __construct(private int $id=0, private string $role, private array $content, private int $threadId)
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function setContent(array $content): void
    {
        $this->content = $content;
    }

    public function getThreadId(): int
    {
        return $this->threadId;
    }

    public function setThreadId(int $threadId): void
    {
        $this->threadId = $threadId;
    }
}
