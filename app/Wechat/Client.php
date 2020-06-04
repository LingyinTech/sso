<?php


namespace App\Wechat;


use EasyWeChat\OfficialAccount\Application;

class Client
{
    protected $wechat;

    /**
     * Client constructor.
     * @param Application | null $wechat
     */
    public function __construct($wechat = null)
    {
        if (null === $wechat) {
            $wechat = app('wechat.official_account');
        }

        $this->wechat = $wechat;
    }

}
