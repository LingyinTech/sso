<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class SSOLogin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = Cookie::get('lingyin-token');
        $ttl = Cookie::get('lingyin-ttl', '');
        $sign = Cookie::get('lingyin-sign', '');
        if ($token && $sign == md5($token . $ttl . $request->userAgent() . $request->ip())) {
            $code = md5($token);
            if (Cache::get("lingyin:openid:{$code}")) {
                return view('index.redirect', [
                    'redirect_uri' => $request->get('redirect_uri', ''),
                    'code' => $code,
                ]);
            }
        }

        return $next($request);
    }
}
