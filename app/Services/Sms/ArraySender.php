<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 03.06.18
 * Time: 15:45
 */

namespace App\Services\Sms;

class ArraySender implements SmsSender
{
    private $messages = [];

    public function send($number, $text)
    {
        $this->messages[] = [
                'to' => '+'.trim($number,'+'),
                'text' => $text
            ];
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}