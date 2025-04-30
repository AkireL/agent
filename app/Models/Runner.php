<?php

namespace App\Models;

use Database\Factories\RunnerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Runner extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
    ];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function runState()
    {
        return $this->hasMany(RunnerState::class);
    }

    public static function newFactory()
    {
        return RunnerFactory::new();
    }
}
