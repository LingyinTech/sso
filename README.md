# 微信扫码关注公众号并登录网站

## 修改配置

复制一个配置文件

```
cp .env.example .env
```

并修改对应的配置

## 导入数据表

```cli
php artisan migration
```

## 流程图

![流程图](resources/images/flow.png)

## 登录流程

* 第一步

访问 https://sso.lingyin99.com/developer  新增一个 api_token

* 第二步

在应用中判断登录，未登录跳转（或弹框）至登录页 https://sso.lingyin99.com/?redirect_uri=https%3A%2F%2Fwww.baidu.com  

redirect_uri 为回调页面，为了避免不必要的问题，应该对其做 urlencode 编码

* 第三步

sso 验证扫码成功后，会回调至 redirect_uri , 并会带回一个授权 code。  

应用接收到 code 后，请求接口 https://sso.lingyin99.com/api/user-info?Authorization={$apiToken}&code={$code} ,获取回用户信息。  

Authorization 更建议的方式是通过请求头来传。   

种上登录态，该干啥就干啥了  

## 推送

通过上一步流程，每个用户会分配一个永久用户标识 code

```
curl --location --request POST 'https://sso.lingyin99.com/api/push/{$code}?type=text' \
--header 'Authorization: {$apiToken}' \
--header 'Content-Type: application/json' \
--data-raw '{"text":"test push"}'
```

支持模板消息和各种普通消息类型  
