<?php

namespace IDEALE\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}