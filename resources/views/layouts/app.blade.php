<html>
<head>
    <title>@yield('title') - LingyinTech SSO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('css')
        <link rel="stylesheet" href="{{ mix('/static/css/app.css') }}" type="text/css">
    @show
</head>
<body>
@section('sidebar')

@show

<div class="container">
    @yield('content')
</div>

<div class="footer">
    @section('footer')
        <div class="copyright">
            <div>
                Copyright ©  2016 - {{ date('Y') }}
                <a target="_blank" href="https://www.lingyin99.com">LingyinTech</a>
                粤ICP备18103540号
            </div>
            <a href="https://www.upyun.com/"><img src="/static/images/upyun-logo.png" style="height: 60px;"></a>
        </div>
    @show
</div>

@section('js')
    <script src="{{ mix('static/js/app.js') }}"></script>
@show
</body>
</html>
