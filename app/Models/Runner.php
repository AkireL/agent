<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    protected $fillable = [
        'thread_id',
        'message_id',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
