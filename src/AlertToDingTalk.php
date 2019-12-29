<?php


namespace Tiway\TingTalkRobot;


use Mockery\Exception;

class AlertToDingTalk
{
    /**
     *
     * @param $token_name
     * @param $msg
     * @param bool $markdown
     * @param string $title
     * @param array $atMobiles
     * @param bool $is_at_all
     * @return array
     */
    public function alertToDing($token_name, $msg,  $markdown = false, $title = '', $atMobiles =[], $is_at_all=false)
    {
        try {
            $token_group = config('tingtalk_robot.token_group');
            $token = $token_group[$token_name]??'';
            if (empty($token)){
                throw new Exception('未找到配置的token信息');
            }
            $handle = new TingTalk();
            $handle->setToken($token);
            //markdown or text
            if ($markdown){
                $handle->setMarkdown($title, $msg);
            }else{
                $handle->setText($msg);
            }
            //at mobile
            if (count($atMobiles) > 0) {
                $handle->setAtArray($atMobiles);
            }
            //at all
            $handle->setAtAll($is_at_all);
            //发送
            $res = $handle->send();
            if ($res !== true) {
                throw new Exception(json_encode($res));
            }

            return ['status'=>true,'msg'=>'success'];
        } catch (\Exception $e) {
            return ['status'=>false,'msg'=>$e->getMessage()];
        }
    }
}