# lumen Dingtalk

整合 mradang/dingtalk 和自建钉钉通讯录同步接口，触发员工和部门数据变更事件

## 依赖
- mradang/dingtalk
- guzzlehttp/guzzle

## 安装
```
composer require mradang/lumen-dingtalk
```

## 配置
1. 添加 .env 环境变量，使用默认值时可省略
```
# 钉钉配置，2018.12.17 之后的应用不需要DINGTALK_CORPSECRET
DINGTALK_CORPID=dingxxxxxxx
DINGTALK_AGENTID=xxxxxxxx
DINGTALK_CORPSECRET=xxxxxxxx
DINGTALK_APPKEY=xxxxxxxx
DINGTALK_APPSECRET=xxxxxxxx
DINGTALK_ALLOW_SITE=http://xx.xx.com/|http://localhost:8080/

# 通讯录同步接口
SYNC_CORP_ID=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
SYNC_CORP_SECRET=xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
SYNC_HOST=http://xxx.xxx.xxx
```

2. 修改 bootstrap\app.php 文件
```php
// 取消 EventServiceProvider 注释
$app->register(App\Providers\EventServiceProvider::class);
// 注册 ServiceProvider
$app->register(mradang\LumenDingtalk\LumenDingtalkServiceProvider::class);
```

3. 手动添加钉钉通讯录同步任务

修改 lumen 工程 app\Console\Kernel.php 文件，在 schedule 函数中增加
```php
// 每分钟同步钉钉通讯录数据
try {
    $schedule
    ->call(function () {
        \mradang\LumenDingtalk\Services\DingTalkService::sync();
    })
    ->everyMinute()
    ->name('DingTalkService::sync')
    ->withoutOverlapping(10);
} catch (\Exception $e) {
    L(sprintf('Kernel.schedule 同步钉钉数据失败：%s', $e->getMessage()), 'sys');
}
```

## 添加的路由
- post /dingtalk/config

## 添加的事件
- mradang\LumenDingtalk\Events\UserUpdateEvent
> array $user
- mradang\LumenDingtalk\Events\UserDeleteEvent
> string $userid
- mradang\LumenDingtalk\Events\DepartmentUpdateEvent
> array $dept
- mradang\LumenDingtalk\Events\DepartmentDeleteEvent
> string $deptid
