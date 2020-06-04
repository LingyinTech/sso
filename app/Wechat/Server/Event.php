<?php


namespace App\Wechat\Server;


abstract class Event
{
    /**
     * @param $message
     * @param $app
     * @return mixed
     */
    abstract public function handle($message, $app = null);
}
