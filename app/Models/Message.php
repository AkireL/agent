<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'role',
        'content',
    ];

    protected $casts = [
        'content' => 'json',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
    protected static function newFactory()
    {
        return MessageFactory::new();
    }
}
