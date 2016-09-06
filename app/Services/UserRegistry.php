<?php

namespace App\Services;

use App\User;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\StatefulGuard;
use SocialiteProviders\Manager\OAuth2\User as SocialiteUser;

class UserRegistry
{
    /**
     * @var StatefulGuard
     */
    protected $guard;

    /**
     * UserRegistry constructor.
     * @param Factory $auth
     * @param User $users
     */
    public function __construct(Factory $auth, User $users)
    {
        $this->users = $users;
        $this->guard = $auth->guard('web');
    }

    /**
     * @param SocialiteUser $socialiteUser
     */
    public function login(SocialiteUser $socialiteUser)
    {
        // Now if user doesn't exist we create it and login.
        // Otherwise just login.
        $user = $this->getLaravelUser($socialiteUser) ?? $this->createLaravelUser($socialiteUser);

        $user->setToken($socialiteUser->accessTokenResponseBody);

        return $this->guard->login($user);
    }

    /**
     * @param SocialiteUser $user
     * @return User|null
     */
    private function getLaravelUser(SocialiteUser $user)
    {
        return $this->users->with('token')->find($user->id);
    }

    /**
     * @param SocialiteUser $user
     * @return User
     */
    private function createLaravelUser(SocialiteUser $user)
    {
        return $this->users->create([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->guard->logout();
    }
}