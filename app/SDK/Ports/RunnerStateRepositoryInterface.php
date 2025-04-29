<?php
namespace App\SDK\Ports;

interface RunnerStateRepositoryInterface
{
    public static function create($runnerId, $messageId, $state = "created");
    public static function updateState(int $id, string $state = "completed");
}
