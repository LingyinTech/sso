<?php


namespace App\Wechat\User;


use App\Wechat\Client;

class UserInfo extends Client
{
    public function get($openId)
    {
        return $this->wechat->user->get($openId);
    }
}
