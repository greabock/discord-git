<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Handler
 * @package App
 *
 * @property string $template
 * @property array $channels
 */
class Handler extends Model
{
    protected $fillable = [
        'channels',
        'type',
        'template',
    ];

    protected $casts = [
        'channels' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

    public function shouldParse(){
        return $this->type = 'json';
    }
}