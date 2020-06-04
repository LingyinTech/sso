<?php

namespace App\Wechat\Server\Events;

use App\Wechat\Server\Event;

class SubscribeEvent extends Event
{

    public function handle($message, $app = null)
    {
        if (!isset($message['EventKey'])) {
            return '感谢关注.';
        }

        return (new ScanEvent())->handle($message);
    }
}
