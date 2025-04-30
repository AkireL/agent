<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hash',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    protected static function newFactory()
    {
        return \Database\Factories\ClientFactory::new();
    }
}
