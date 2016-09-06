<?php

namespace Greabock\Discord;

use GuzzleHttp\Client;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class DiscordServiceProvider extends ServiceProvider
{
    /**
     *  Регистриуем службу Discord.
     */
    public function register(){

        $this->registerGuzzleClient();
        $this->registerDiscordBot();
        $this->registerDiscordUser();

    }

    private function registerGuzzleClient()
    {
        // Преднастренный газзл для дискорда.
        $this->app->singleton('discord.http', function (){
            $base_uri = 'https://discordapp.com';
            return new Client(compact('base_uri'));
        });

        // Когда дискорду нужен газзл,
        // отдаем ему преднастроенный газзл.
        $this->app
            ->when(Discord::class)
            ->needs(Client::class)
            ->give('discord.http');
    }

    private function registerDiscordBot()
    {
        // Дискорд для бота получаем, только по ключу в контейнере
        $this->app->singleton('discord.bot', function(Container $app){
            return $app->build(Discord::class, [
                'token' => [
                    'access_token' => $app['config']['services.discord.bot_token'],
                    'token_type' => 'Bot',
                ]
            ]);
        });
    }

    private function registerDiscordUser()
    {
        $this->app->singleton('discord.user', function(Container $app){
            return $app->build(Discord::class, [
                'token' => $app['auth']->user()->token->toArray()
            ]);
        });

        $this->app->alias('discord.user', Discord::class);
    }
}