<?php


namespace App\Wechat\Message;


use App\Wechat\Client;
use EasyWeChat\Kernel\Messages\Article;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Media;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Voice;

class CustomerMessage extends Client
{

    const TEXT = 'text';
    const IMAGE = 'image';
    const VIDEO = 'Video';
    const VOICE = 'voice';
    const NEWS = 'news';
    const ARTICLE = 'article';
    const MEDIA = 'media';

    public function send($openid, $type, $message)
    {
        switch ($type) {
            case self::TEXT:
                $message = new Text($message['text']);
                break;
            case self::IMAGE:
                $message = new Image($message);
                break;
            case self::VIDEO:
                $message = new Video($message['media_id'], $message);
                break;
            case self::VOICE:
                $message = new Voice($message);
                break;
            case self::NEWS:
                $items = [];
                foreach ($message as $value) {
                    $items = new NewsItem($value);
                }
                $message = new News($items);
                break;
            case self::ARTICLE:
                $message = new Article($message);
                break;
            case self::MEDIA:
                $message = new Media($message['media_id'], $message['type']);
                break;
        }

        $this->wechat->customer_service->message($message)->to($openid)->send();
    }

}
