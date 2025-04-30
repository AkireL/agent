<?php

namespace App\SDK\Infrastructure;

use App\Models\Runner;
use App\SDK\Ports\RunnerRepositoryInterface;

class EloquentRunner implements RunnerRepositoryInterface
{
    private function create($threadId)
    {
        return Runner::create([
            'thread_id' => $threadId,
        ]);
    }

    private function find($threadId, $runnerId)
    {
        return Runner::where([
            'thread_id'=> $threadId,
            'id' => $runnerId,
        ])->first();
    }

    public function getOrCreate(int $threadId, ?int $runnerId=null): int
    {
        if ($threadId) {
            $runner = $this->find($threadId, $runnerId);

            if (! $runner) {
                $runner = $this->create($threadId);
            }

            return $runner->id;
        }

        $thread = \App\Models\Thread::find($threadId);

        $runner = $thread->runners()->create();

        return $runner->id;
    }

}
