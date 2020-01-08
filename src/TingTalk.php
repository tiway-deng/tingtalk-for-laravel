<?php


namespace Tiway\TingTalkRobot;


class TingTalk
{
    const TEXT     = 'text';
    const MARKDOWN = 'markdown';

    private $_url='https://oapi.dingtalk.com/robot/send?access_token=';

    private $_message = [];

    private $_error = [];

    public function __construct() {
    }

    public function setToken($token) {
        $this->_url .= $token;
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
            $this->_error[] = 'Please select the sending format';
        }

        //at手机号码不能为空
        if (count($phones)==0) {
            $this->_error[] = 'Please fill in phone number which you at';
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
        if (empty($text)) {
            $this->_error[] = 'Please fill in the textMsg content';
        }
        $this->_message['text'] = array('content'=>$text);
        return $this;
    }

    public function setMarkdown($title = '', $text='') {
        $this->setMarkdownType();

        if (empty($title)) {
            $this->_error[] = 'Please fill in the title of markdown';
        }else{
            $this->_message['markdown']['title'] = $title;
        }

        if (empty($text)) {
            $this->_error[] = 'Please fill in the markdown content';
        }else{
            $this->_message['markdown']['text'] = $text;
        }

        return $this;
    }

    public function send() {
        if (count($this->_error) > 0) return $this->_error;
        //发送请求
        $headers[] = "Content-Type: application/json;charset=utf-8";
        $context = stream_context_create([
            'http' => [
                'header' => $headers,
                'method' => 'POST',
                'content' => json_encode($this->_message)
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);
        $url = $this->_url;
        $result = @file_get_contents($url, false, $context);
        if ($result) {
            $result = json_decode($result,true);
            if(array_get($result,'errcode') !== 0) {
                $error = array_get($result,'errmsg','Network Error');
                $this->_error[] = $error;
                return $this->_error;
            }
        }
        return true;
    }
}