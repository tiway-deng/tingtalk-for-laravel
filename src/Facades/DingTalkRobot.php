<?php


namespace Tiway\TingTalkRobot\Facades;


use Illuminate\Support\Facades\Facade;

class DingTalkRobot extends Facade
{
    protected static function getFacadeAccessor() {
        return 'tingtalk';
    }
}