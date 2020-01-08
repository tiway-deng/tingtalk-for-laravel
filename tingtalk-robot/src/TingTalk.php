<?php


namespace Tiway\TingTalkRobot;


class TingTalk
{
    const TEXT     = 'text';
    const MARKDOWN = 'markdown';

    private $_host='https://oapi.dingtalk.com';

    private $_uri='';

    private $_message = [];

    private $_error = [];

    public function __construct() {
    }

    public function setToken($token) {
        $this->_uri = '/robot/send?access_token='.$token;
        return $this;
    }

    private function setTextType() {
        $this->_message['msgtype'] = self::TEXT;
        return $this;
    }

    private function setMarkdownType() {
        $this->_message['msgtype'] = self::MARKDOWN;
        return $this;
    }

    public function setAtArray(array $phones) {
        //先定义是选择那一种发送格式
        $type = $this->_message['msgtype']??'';
        if (empty($type)){
            $this->_error[] = '请先选择发送格式';
        }

        //at手机号码不能为空
        if (count($phones)==0) {
            $this->_error[] = '请填写＠手机号码';
        }
        if ($type == self::MARKDOWN) {
            $markdown_text = $this->_message['markdown']['text'];
            foreach ($phones as $phone) {
                $markdown_text .= "\n\n @".$phone;
                $this->_message['markdown']['text'] = $markdown_text;
            }
        }
        $this->_message['at']['atMobiles'] = $phones;

        return $this;
    }

    public function setAtAll(bool $bool) {
        $this->_message['at']['isAtAll'] = $bool;
        return $this;
    }

    public function setText($text='') {
        $this->setTextType();
        $this->_message['text'] = array('content'=>$text);
        return $this;
    }

    public function setMarkdown($title = '', $text='') {
        $this->setMarkdownType();

        if (empty($title)) {
            $this->_error[] = '请填写markdown的title';
        }else{
            $this->_message['markdown']['title'] = $title;
        }

        if (empty($text)) {
            $this->_error[] = '内容不能为空';
        }else{
            $this->_message['markdown']['text'] = $text;
        }

        return $this;
    }

    public function send() {
        if (count($this->_error) > 0) {
            return $this->_error;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_host.$this->_uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 跳过服务器检查
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->_message));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        dd($ch);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        return $result;
    }
}