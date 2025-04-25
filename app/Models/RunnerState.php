<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunnerState extends Model
{
    protected $fillable = [
        'runner_id',
        'message_id',
        'state',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function runner()
    {
        return $this->belongsTo(Runner::class);
    }
}
