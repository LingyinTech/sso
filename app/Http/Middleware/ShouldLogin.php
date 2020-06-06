<?php

namespace App\Http\Middleware;

use App\Models\TokenRecord;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ShouldLogin extends Upyun
{

    protected function redirect(Request $request)
    {
        if ($request->expectsJson()) {
            return response('请先登录', 403);
        }

        return redirect(route('login', ['redirect_uri' => urlencode($request->fullUrl())]));
    }

    protected function checkSession(Request $request)
    {
        if ($request->session()->get('code')
            && $openid = $request->session()->get('openid')) {
            return true;
        }

        return false;
    }

    protected function checkCookie(Request $request)
    {
        $token = Cookie::get('lingyin-token');
        $ttl = Cookie::get('lingyin-ttl', '');
        $sign = Cookie::get('lingyin-sign', '');

        if ($token && $sign == md5($token . $ttl . $request->userAgent() . $request->ip())) {

            $record = (new TokenRecord())->getExpireRecordByToken($token);

            if ($record && $record->openid && $userInfo = (new UserInfo())->getUserInfoByOpenid($record->openid)) {

                $request->session()->put('code', $userInfo->code);
                $request->session()->put('openid', $record->openid);

                return true;
            }
        }

        return false;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->adaptUpyun($request);

        if ($this->checkSession($request) || $this->checkCookie($request)) {
            return $next($request);
        }

        return $this->redirect($request);
    }
}
