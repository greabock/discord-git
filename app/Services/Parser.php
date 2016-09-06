<?php
/**
 * Created by PhpStorm.
 * User: Greabock
 * Date: 06.09.2016
 * Time: 19:50
 */

namespace App\Services;


class Parser
{
    protected  $regex = '#{{\s*?([a-zA-Z0-9.]*)\s*?}}#';

    public function parse($template, $content)
    {
        $content = array_dot(json_decode($content));
        return preg_replace_callback($this->regex, function ($matches) use ($content) {
            return array_get($content, $matches[1], "{{{$matches[1]}}}");
        }, $template);
    }
}