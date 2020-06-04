;(function () {
    let redirectUri = $('input[name=redirect_uri]').val() || document.referrer;
    if (!redirectUri) {
        layer.msg('未设置回调地址');
        return;
    }
    let code = $('input[name=code]').val();
    let splice = -1 === redirectUri.indexOf('?') ? '?' : '&';
    window.top.location.href = redirectUri + splice + 'code=' + code;
})();
