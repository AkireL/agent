<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'hash',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
