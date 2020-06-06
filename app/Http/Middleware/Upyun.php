<?php


namespace App\Http\Middleware;


use Illuminate\Http\Request;

abstract class Upyun
{
    protected function adaptUpyun(Request $request)
    {
        $request::setTrustedProxies([$request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_FOR);
    }
}
