<?php

namespace Tiway\TingTalkRobot;

use Illuminate\Support\ServiceProvider;

/**
 * Class TingTalkRobotServiceProvider
 * @package Tiway\TingTalkRobot
 */
class TingTalkRobotServiceProvider extends ServiceProvider
{
    protected $defer = true;

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

    /**
     * @return array
     */
    public function provides() {
        // 因为延迟加载 所以要定义 provides
        return ['tingtalk'];
    }
}
