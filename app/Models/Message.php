<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'thread_id',
        'role',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
