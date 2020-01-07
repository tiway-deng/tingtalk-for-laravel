<?php

namespace Tiway\TingTalkRobot;

use Illuminate\Support\ServiceProvider;

class TingTalkRobotServiceProvider extends ServiceProvider
{
    protected $defer = true; // 延迟加载服务
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/tingtalk_robot.php' => config_path('tingtalk_robot.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        // 单例绑定服务
        $this->app->singleton('tingtalk', function ($app) {
            return new AlertToDingTalk();
        });
    }

    public function provides() {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['tingtalk'];
    }
}
