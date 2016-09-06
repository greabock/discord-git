<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string  $hook
 */
class Route extends Model
{
    protected $fillable = [
        'hook',
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function handlers()
    {
        return $this->belongsToMany(Handler::class);
    }
}