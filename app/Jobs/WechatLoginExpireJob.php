<?php

namespace App\Jobs;

use App\Events\WechatLoginEvent;
use App\Wechat\Message\CustomerMessage;
use App\Wechat\Message\TemplateMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twinkle\DI\ServiceLocatorTrait;

/**
 * Class WechatMessageJob
 *
 * @package App\Jobs
 * @property-read TemplateMessage $templateMessage
 * @property-read CustomerMessage $customerMessage
 */
class WechatLoginExpireJob extends Job
{
    protected $token;

    /**
     * Create a new job instance.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new WechatLoginEvent($this->token,[
            'type' => 'token-expire',
        ]));
    }
}
