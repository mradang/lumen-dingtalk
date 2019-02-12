<?php

namespace mradang\LumenDingtalk;

use Illuminate\Support\ServiceProvider;

class LumenDingtalkServiceProvider extends ServiceProvider {

    public function boot() {
        $this->configure();
        $this->registerRoutes();
    }

    protected function configure() {
        $this->app->configure('dingtalk');

        $this->mergeConfigFrom(
            __DIR__.'/../config/dingtalk.php', 'dingtalk'
        );

        // 初始化钉钉SDK
        \mradang\DingTalk\DingTalk::init([
            // 基础配置
            'corpid' => config('dingtalk.corpid'),
            'agentid' => config('dingtalk.agentid'),

            // 2018.12.17 之前的应用，请配置 corpsecret
            'corpsecret' => config('dingtalk.corpsecret'),
            // 2018.12.17 之后的应用，请配置 appkey 和 appsecret
            'appkey' => config('dingtalk.appkey'),
            'appsecret' => config('dingtalk.appsecret'),
        ]);
    }

    protected function registerRoutes() {
        \Illuminate\Support\Facades\Route::group([
            'namespace' => 'mradang\LumenDingtalk\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        });
    }

}