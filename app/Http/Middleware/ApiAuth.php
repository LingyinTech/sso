<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiAuth
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
        $apiToken = $request->server->get('HTTP_AUTHORIZATION', $request->get('Authorization'));
        if (!$apiToken) {
            return response('Unauthorized.', 401);
        }

        $appsecret = DB::table('developer')->where('api_token', $apiToken)->first(['white_list']);
        if (!$appsecret) {
            return response('Unauthorized.', 401);
        }
        $whiteList = $appsecret->white_list;

        if (!empty($whiteList)) {
            $whiteList = explode(',', $whiteList);
            if (!in_array($request->ip(), $whiteList)) {
                return response("访问ip【{$request->ip()}】不在白名单之中", 403);
            }
        }

        // @todo 限流，计数等

        return $next($request);
    }
}
