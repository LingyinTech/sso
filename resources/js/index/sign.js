require('../push');

;(function () {

    function showQrcode() {
        $.ajax({
            url: '/',
            method: 'GET',
            type: 'json'
        }).done(function (response) {
            if (!!response.url && !!response.token) {
                let wechat = $('.wechat-img');
                wechat.attr('src', response.url);
                wechat.attr('data-token', response.token);
                window.sign.listenScanResult(response.token);
            }
        }).fail(function () {
            console.log('fail');
        });
    }

    function listenScanResult(token) {
        Echo.channel('wechat-login-' + token)
            .listen('WechatLoginEvent', (e) => {
                if ('token-expire' === e.data.type) {
                    layer.msg('二维码过期，登录失败，请重新扫码');
                    window.sign.showQrcode();
                } else if ('login-success' === e.data.type) {
                    let redirectUri = $('input[name=redirect_uri]').val() || document.referrer;
                    if (!redirectUri) {
                        layer.msg('未设置回调地址');
                        return;
                    }
                    let splice = -1 === redirectUri.indexOf('?') ? '?' : '&';
                    window.top.location.href = redirectUri + splice + 'code=' + e.data.code;
                }
            });
    }

    window.sign = window.sign || {};
    window.sign.showQrcode = showQrcode;
    window.sign.listenScanResult = listenScanResult;

})();

;(function () {
    let wechat = $('.wechat-img');
    if (wechat.attr('src') && wechat.data('token')) {
        window.sign.listenScanResult(wechat.data('token'));
    } else {
        window.sign.showQrcode();
    }
})();
