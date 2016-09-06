<?php

namespace App\Jobs;

use App\Handler;
use App\Services\Parser;
use Greabock\Discord\Discord;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendHook implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Discord
     */
    protected $bot;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var Handler
     */
    protected $handler;

    public function __construct(Handler $handler, $content)
    {
        $this->handler = $handler;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @param Parser  $parser
     */
    public function handle(Parser $parser)
    {
        $bot = app('discord.bot');
        $content = $this->content;

        if ($this->handler->shouldParse()) {
            $content = $parser->parse($this->handler->template, $content);
        }

        $bot->sendMessage($content, $this->handler->channels);
    }
}
