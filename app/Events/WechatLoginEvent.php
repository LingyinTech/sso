<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Cache;

class WechatLoginEvent extends Event implements ShouldBroadcast
{

    protected $token;
    public $data;

    /**
     * Create a new event instance.
     *
     * @param string $token
     * @param array $data
     * @return void
     */
    public function __construct(string $token, array $data)
    {
        $this->token = $token;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("wechat-login-{$this->token}");
    }

    /**
     * 确定事件是否要被广播
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return false <> Cache::get("lingyin:token:{$this->token}");
    }
}
