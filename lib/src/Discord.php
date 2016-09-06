<?php

namespace Greabock\Discord;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Routing\UrlGenerator;

class Discord
{
    /**
     * @var Client
     */
    protected $http;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $token = [];

    /**
     * @var string
     */
    protected $authToken;

    public function __construct(Client $client, UrlGenerator $url, array $token)
    {
        $this->token = $token;
        $this->http = $client;
        $this->url = $url;
    }

    public function me(){
        return $this->request('GET', 'users/@me');
    }

    public function guilds()
    {
        return $this->request('GET', 'users/@me/guilds');
    }

    public function users(){
        return $this->request('GET', 'users');
    }

    public function getAuthorizationHeader()
    {
        return $this->authToken ??
               $this->authToken =
                   $this->token['token_type'] . ' ' .
                   $this->token['access_token'];
    }

    protected function buildHeaders()
    {
        return [
            'Authorization' => $this->getAuthorizationHeader(),
        ];
    }

    public function request($method, $path, $options = [])
    {
        $path = 'api/'.trim($path, '/');

        $options = array_merge(
            ['headers' => $this->buildHeaders()],
            $options
        );

        try {
            $response = $this->http->request($method, $path, $options);
        } catch (RequestException $exception) {
            if ($response = $exception->getResponse()) {
                throw  new DiscordException(
                    $response->getReasonPhrase(),
                    $response->getStatusCode(),
                    $exception
                );
            }

            throw new DiscordException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
        return json_decode($response->getBody(), true);
    }

    public function sendMessage($content, $channels)
    {
        if(is_array($channels)){
            foreach ($channels as $channel){
                $this->sendMessage($content, $channel);
            }

            return;
        }

        $this->request('POST', 'channels/'.$channels.'/messages', [
            'json' => compact('content')
        ]);
    }
}