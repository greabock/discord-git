<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = [
        "access_token",
        "token_type",
        "expires_in",
        "refresh_token",
        "scope",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}