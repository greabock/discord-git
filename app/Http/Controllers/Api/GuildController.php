<?php

namespace App\Http\Controllers\Api;

use Greabock\Discord\Discord;
use Illuminate\Container\Container;

class GuildController
{
    /**
     * @var Discord
     */
    protected $bot;

    public function __construct(Container $app)
    {
        $this->bot = $app['discord.bot'];
    }

    public function index(Discord $discord)
    {
        $userGuilds = $discord->guilds();

        $userGuilds = $this->prePareGuilds($userGuilds);

        return response(['data' => $userGuilds], 200, [
            'content-type' => 'application/json'
        ]);
    }

    public function test(Container $app){

    }

    private function prePareGuilds($userGuilds)
    {
        $botGuilds = $this->bot->guilds();
        $userGuilds =  $this->filerOwner($userGuilds);

        foreach ($userGuilds as $index => $userGuild) {
            $userGuilds[$index]['icon'] = $this->buildIcon($userGuild);
            foreach ($botGuilds as $botGuild){
                if($userGuild['id'] === $botGuild['id']){
                    $userGuilds[$index]['bot'] = true;
                    continue 2;
                }
            }
            $userGuilds[$index]['bot'] = false;
        }


        return $userGuilds;
    }

    private function buildIcon($userGuild)
    {
        if(is_null($userGuild['icon'])){
          return null;
        }
        return sprintf(
            'https://discordcdn.com/icons/%s/%s.jpg',
            $userGuild['id'],
            $userGuild['icon']
        );
    }

    private function filerOwner($userGuilds)
    {
        return array_filter($userGuilds, function($v){
            return $v['owner'];
        }, ARRAY_FILTER_USE_BOTH);
    }
}