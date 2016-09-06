<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserRegistry;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Contracts\Factory;

class LoginController extends Controller
{
    /**
     * @var Factory
     */
    protected $socialite;

    /**
     * @var UserRegistry
     */
    protected $registry;

    /**
     * @var Redirector
     */
    protected $redirect;

    /**
     * LoginController constructor.
     *
     * @param Factory      $socialite
     * @param UserRegistry $registry
     * @param Redirector   $redirect
     */
    public function __construct(Factory $socialite, UserRegistry $registry, Redirector $redirect)
    {
        $this->redirect = $redirect;
        $this->registry = $registry;
        $this->socialite = $socialite;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login()
    {
        return $this->socialite->driver('discord')->scopes(['guilds'])->redirect();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle()
    {
        $discordUser = $this->socialite->driver('discord')->user();
        $this->registry->login($discordUser);
        return $this->redirect->route('dispatcher');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->registry->logout();

        return $this->redirect->route('home');
    }
}
