<?php

namespace App\Http\Controllers;


use App\Jobs\WechatMessageJob;
use Illuminate\Http\Request;

class PushController extends Controller
{

    public function index(Request $request, $code)
    {
        $message = [
            'code' => $code,
            'type' => $request->get('type'),
            'data' => $request->json()->all(),
        ];
        dispatch(new WechatMessageJob($message));
    }
}
