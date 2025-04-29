<?php

namespace App\SDK\Ports;


interface RunnerRepositoryInterface
{
    public function getOrCreate(int $threadId, ?int $runnerId): int;
}
