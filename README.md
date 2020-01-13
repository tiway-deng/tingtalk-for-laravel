# README

> tingtalk-for-laravel 是一个简单发送企业钉钉群助手的轮子

### Installation

~~~bash

$ composer require tiway/tingtalk-robot

~~~

 #### 在**config/app.php** 添加配置
 providers 添加 
 ~~~php
 \Tiway\TingTalkRobot\TingTalkRobotServiceProvider::class,
 ~~~
 
 aliases   添加  
  ~~~php
'TingTalk'=> \Tiway\TingTalkRobot\Facades\DingTalkRobot::class
 ~~~
 
 发布配置文件
 ~~~bash
 $ php artisan vendor:publish --provider=Tiway\TingTalkRobot\TingTalkRobotServiceProvider

 ~~~
 
 ### Basic Usage
 在 config/tingtalk_robot.php 添加 钉钉机器人的token
 ~~~php
   
 'token_group' => [
        "test" => '74F0B992DC4F497CBBC7B63F847B2186CBBC7B63F847B2186'
    ]
 ~~~
 
在 routes/console.php 中添加测试
~~~php
Artisan::command('tiway:test_ting', function () {
    $res = \Tiway\TingTalkRobot\Facades\DingTalkRobot::alertToDing('test','33');
    dd($res);

});
~~~

更多详细信息 [企业钉钉群发送信息轮子](https://blog.csdn.net/qq_39941141/article/details/103962767).

