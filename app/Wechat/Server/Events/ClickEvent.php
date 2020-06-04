<?php


namespace App\Wechat\Server\Events;

use App\Wechat\Server\Event;

class ClickEvent extends Event
{

    public function handle($message, $app = null)
    {
        return var_export($message, true);
    }
}
