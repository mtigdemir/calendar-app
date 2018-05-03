<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['user_id', 'title', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
