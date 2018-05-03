<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'title', 'date'];

    protected $casts = [
        'date' => 'datetime:Y-m-d'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
