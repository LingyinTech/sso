@extends('layouts.app')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ mix('/static/css/index.css') }}" type="text/css">
@endsection

@section('content')

    <div class="weixin">
        <div class="weixin-icon">
            <input type="hidden" name="redirect_uri" value="{{ $redirect_uri }}">
            <input type="hidden" name="code" value="{{ $code }}}">
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script src="{{ mix('/static/js/index/redirect.js') }}"></script>
@endsection
