<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SSOLogin extends ShouldLogin
{

    protected function redirect(Request $request, $code = null)
    {
        return response(view('index.redirect', [
            'redirect_uri' => $request->get('redirect_uri', ''),
            'code' => $code,
        ]));
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

        if (parent::checkSession($request) || parent::checkCookie($request)) {
            $code = md5(uniqid('lingyin-code'));
            Cache::put("lingyin:openid:{$code}", $request->session()->get('openid'), 3600);
            return $this->redirect($request, $code);
        }

        return $next($request);
    }
}
