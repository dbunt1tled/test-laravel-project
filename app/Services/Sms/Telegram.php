<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 03.06.18
 * Time: 15:45
 */

namespace App\Services\Sms;

use GuzzleHttp\Client;

class Telegram implements SmsSender
{
    private $url;
    private $chats = [];
    /**
     * @var Client $client
     */
    private $client;

    public function __construct($appId,$url = 'https://api.telegram.org/')
    {
        if(empty($appId)){
            throw new \InvalidArgumentException('Необходимо установить уникальный ключ сервиса');
        }
        $this->url = $url.'bot'.$appId.'/';
        $this->client = new Client();
        $data =  $this->client->request('POST',$this->url.'getUpdates',[]);
        $data =(array) json_decode((string)$data->getBody());
        $data = $data['result'];
        foreach ($data as $val){
            $this->chats[] = $val->message->chat->id;
        }
    }
    public function send($number, $text)
    {
        if(empty($text)){
            $text = 'Пустое сообщение';
        }
        foreach ($this->chats as $chat) {
            $this->client->post($this->url.'sendMessage',['json' => ['chat_id' => $chat,'text' => $text]]);
        }
    }
}