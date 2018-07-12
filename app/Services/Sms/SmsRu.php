<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 03.06.18
 * Time: 15:45
 */

namespace App\Services\Sms;

use GuzzleHttp\Client;

class SmsRu implements SmsSender
{
    private $appId;
    private $url;
    /**
     * @var Client $client
     */
    private $client;

    public function __construct($appId,$url = 'https://sms.ru/sms/send')
    {
        if(empty($appId)){
            throw new \InvalidArgumentException('Необходимо установить уникальный ключ сервиса');
        }
        $this->appId = $appId;
        $this->url = $url;
        $this->client = new Client();
    }
    public function send($number, $text)
    {
        $this->client->post($this->url,[
            'form_params' => [
                'api_id' => $this->appId,
                'to' => '+'.trim($number,'+'),
                'text' => $text
            ],
        ]);

    }
}