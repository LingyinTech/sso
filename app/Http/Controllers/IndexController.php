<?php


namespace App\Http\Controllers;


use App\Jobs\WechatLoginExpireJob;
use App\Models\TokenRecord;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Cookie;

class IndexController extends Controller
{

    public function index(Request $request)
    {
        $app = app('wechat.official_account');
        $response['token'] = uniqid('lingyin-');

        $response['redirect_uri'] = $request->get('redirect_uri', '');

        $result = $app->qrcode->temporary($response['token'], 10 * 60);
        $response['url'] = $app->qrcode->url($result['ticket']);

        Cache::put("lingyin:ticket:{$result['ticket']}", $response['token'], $result['expire_seconds'] + 300);

        $nowTime = time();

        (new TokenRecord())->addRecord([
            'token' => $response['token'],
            'ticket' => $result['ticket'],
            'redirect_uri' => $response['redirect_uri'],
            'expireAt' => $nowTime + $result['expire_seconds'] + 300
        ]);

        Cache::put("lingyin:token:{$response['token']}", $response['token'], $result['expire_seconds']);
        dispatch(new WechatLoginExpireJob($response['token']))->delay($result['expire_seconds'] - 30);

        $cookie = new Cookie('lingyin-token', $response['token'], $nowTime + 3600);
        $timestamp = new Cookie('lingyin-ttl', $nowTime, $nowTime + 3600);
        $signCookie = new Cookie('lingyin-sign', md5($response['token'] . time() . $request->userAgent() . $request->ip()), $nowTime + 3600);

        if ($request->ajax()) {
            return response()
                ->json($response)
                ->withCookie($cookie)
                ->withCookie($timestamp)
                ->withCookie($signCookie);
        }

        return response(view('index.index', $response))
            ->withCookie($cookie)
            ->withCookie($timestamp)
            ->withCookie($signCookie);
    }

    public function getUserInfo(Request $request)
    {
        $code = $request->get('code');

        $openid = Cache::get("lingyin:openid:{$code}");

        $userInfo = (new UserInfo())->getUserInfoByOpenid($openid);

        return response()->json([
            'status' => 0,
            'msg' => 'success',
            'user_info' => $userInfo,
        ]);
    }

}
