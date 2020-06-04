<?php

namespace App\Wechat\Server\Events;

use App\Events\WechatLoginEvent;
use App\Wechat\Server\Event;
use App\Wechat\User\UserInfo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ScanEvent extends Event
{

    public function handle($message, $app = null)
    {
        $user = (new UserInfo($app))->get($message['FromUserName']);

        $token = Cache::get("lingyin:ticket:{$message['Ticket']}");

        $code = md5(uniqid('lingyin-code'));
        Cache::put("lingyin:openid:{$code}", $message['FromUserName'], 3600);

        DB::table('token_record')->where('token', $token)->update([
            'openid' => $message['FromUserName'],
        ]);

        $user['code'] = md5($message['FromUserName'] . 'lingyin99');

        $fields = [
            'openid', 'code',
            'nickname', 'sex',
            'country', 'province',
            'city', 'headimgurl',
            'subscribe_time',
            'unionid', 'subscribe_scene'
        ];
        $update = [];
        foreach ($fields as $field) {
            if (isset($user[$field])) {
                $update[$field] = $user[$field];
            }
        }

        DB::table('user_info')->updateOrInsert(
            ['openid' => $message['FromUserName']],
            $update
        );

        Cache::forget("lingyin:token:{$token}");

        event(new WechatLoginEvent($token,[
            'type' => 'login-success',
            'code' => $code
        ]));

        return '登录成功';
    }
}
