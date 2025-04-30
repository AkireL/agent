<?php

namespace App\Models;

use Database\Factories\RunnerStateFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RunnerState extends Model
{
    use HasFactory;

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

    public static function newFactory()
    {
        return RunnerStateFactory::new();
    }
}
