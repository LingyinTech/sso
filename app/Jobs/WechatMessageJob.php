<?php

namespace App\Jobs;

use App\Wechat\Message\CustomerMessage;
use App\Wechat\Message\TemplateMessage;
use Illuminate\Support\Facades\DB;
use Twinkle\DI\ServiceLocatorTrait;

/**
 * Class WechatMessageJob
 *
 * @package App\Jobs
 * @property-read TemplateMessage $templateMessage
 * @property-read CustomerMessage $customerMessage
 */
class WechatMessageJob extends Job
{
    use ServiceLocatorTrait;

    public static function supportAutoNamespaces()
    {
        return ['App\\Wechat\\Message'];
    }

    public static function supportedClassSuffix()
    {
        return [
            'Message',
        ];
    }

    protected $message;

    /**
     * Create a new job instance.
     *
     * @param array $message
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = DB::table('user_info')
            ->select('openid')
            ->where('code', $this->message['code'])
            ->first();
        if (empty($data) || empty($data['openid'])) {
            return;
        }
        $openid = $data['openid'];
        $type = $this->message['type'];
        $data = $this->message['data'];
        switch ($type) {
            case TemplateMessage::MESSAGE_TYPE:
                $this->templateMessage->send($openid, $data['template_id'], $data['data'], $data['redirect']);
                break;
            default:
                $this->customerMessage->send($openid, $type, $data);

        }
    }
}
