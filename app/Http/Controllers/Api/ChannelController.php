<?php

namespace App\Http\Controllers\Api;

use Greabock\Discord\Discord;

class ChannelController
{
    /**
     * @var Discord
     */
    protected $discord;

    public function index(){

        $this->discord = app()->build(Discord::class, [
            'token' => [
                'access_token' => 'MjE5ODg2NjgwOTY0OTg4OTI4.CqvHlA._gJzVW6SrHVnihnb9QoLS_ZuHKQ',
                'token_type' => 'Bot'
            ]
        ]);

        return $this->discord->guilds()->getBody();
    }
}