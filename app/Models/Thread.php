<?php

namespace App\Models;

use Database\Factories\ThreadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function runners()
    {
        return $this->hasMany(Runner::class);
    }

    public static function newFactory()
    {
        return ThreadFactory::new();
    }
}
