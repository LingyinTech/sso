<?php

namespace App\Http\Controllers;

use App\Wechat\Server\Events\ClickEvent;
use App\Wechat\Server\Events\ScanEvent;
use App\Wechat\Server\Events\SubscribeEvent;
use App\Wechat\Server\Events\UnsubscribeEvent;
use EasyWeChat\Kernel\Messages\Message;
use Exception;
use Twinkle\DI\ServiceLocatorTrait;

/**
 * Class WechatController
 * @package App\Http\Controllers
 * @property-read ScanEvent $scanEvent
 * @property-read SubscribeEvent $subscribeEvent
 * @property-read UnsubscribeEvent $unsubscribeEvent
 * @property-read ClickEvent $clickEvent
 */
class WechatController extends Controller
{
    use ServiceLocatorTrait;

    public static function supportAutoNamespaces()
    {
        return [
            'App\\Wechat\\Server\\Events'
        ];
    }

    public static function supportedClassSuffix()
    {
        return [
            'Event',
        ];
    }

    public function serve()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            return var_export($message, true);
        });

        $app->server->push(function ($message) use ($app) {
            try {
                $event = strtolower($message['Event']) . "Event";
                return $this->{$event}->handle($message, $app);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }, Message::EVENT);

        return $app->server->serve();
    }
}
