<?php

namespace App\SDK\Infrastructure;

use App\Models\Runner;
use App\Models\RunnerState;
use \App\SDK\Ports\RunnerStateRepositoryInterface;

class EloquentRunnerState implements RunnerStateRepositoryInterface
{
    public static function create($runnerId, $messageId, $state = "created")
    {
        $runner = Runner::find($runnerId);

        if (!$runner) {
            throw new \Exception("Runner not found");
        }

        $runner->runState()->create([
            'message_id' => $messageId,
            'state' => $state,
        ]);

        return $runner->runState()->latest()->first();
    }

    public static function updateState(int $id, string $state="completed")
    {
        $runnerState = RunnerState::find($id);

        if (! $runnerState) {
            throw new \Exception("RunnerState not found");
        }

        $runnerState->update([
            'state' => $state
        ]);

        return $runnerState;
    }
}
