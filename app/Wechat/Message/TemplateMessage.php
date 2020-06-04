<?php

namespace App\Wechat\Message;

use App\Wechat\Client;

class TemplateMessage extends Client
{

    const MESSAGE_TYPE = 'template';

    public function send($openid, $templateId, $data = [], $redirect = null)
    {
        $push = [
            'touser' => $openid,
            'template_id' => $templateId,
        ];
        if (!empty($data)) {
            $push['data'] = $data;
        }
        if (is_array($redirect)) {
            $push['miniprogram'] = $redirect;
        } elseif (is_string($redirect)) {
            $push['url'] = $redirect;
        }
        $push = array_merge($push, ['data' => $data]);
        return $this->wechat->template_message->send($push);
    }

}
