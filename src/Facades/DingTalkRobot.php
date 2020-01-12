<?php


namespace Tiway\TingTalkRobot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class DingTalkRobot
 * @package Tiway\TingTalkRobot\Facades
 */
class DingTalkRobot extends Facade
{
    protected static function getFacadeAccessor() {
        return 'tingtalk';
    }
}