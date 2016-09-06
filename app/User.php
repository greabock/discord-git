<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * Class User
 *
 * @property string $name
 * @property string $discordId
 */
class User extends Model implements
    AuthorizableContract,
    AuthenticatableContract
{
    use Authenticatable, Authorizable, Notifiable;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function routes()
    {
        return $this->hasMany(Route::class);
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function setToken($token)
    {
          $this->token()
                ->updateOrCreate(['user_id' => $this->id], $token);
    }

    public function token()
    {
        return $this->hasOne(Token::class);
    }
}
