@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ mix('/static/css/index.css') }}" type="text/css">
@endsection

@section('title', '扫码登录')

@section('content')
<div class="weixin">
    <div class="weixin-icon">
        <div style="font-size: 20px;">微信登录</div>
        <img class="wechat-img" src="{{ $url }}" data-token="{{ $token }}">
        <div class="wechat-tip">扫码关注【灵引未来】公众号进行登录</div>
        <input type="hidden" name="redirect_uri" value="{{ $redirect_uri }}">
    </div>
</div>

@endsection

@section('js')
    @parent
    <script src="{{ mix('/static/js/index/sign.js') }}"></script>
@endsection
