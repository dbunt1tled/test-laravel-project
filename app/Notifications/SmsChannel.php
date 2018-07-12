<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 12.07.18
 * Time: 12:27
 */

namespace App\Notifications;

use App\Entity\User;
use App\Services\Sms\SmsSender;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    private $sender;

    public function __construct(SmsSender $sender)
    {
        $this->sender = $sender;
    }
    public function send(User $notifiable, Notification $notification)
    {
        if (!$notifiable->isPhoneVerified()) {
            return;
        }
        $message = $notification->toSms($notifiable);
        $this->sender->send($notifiable->phone, $message);
    }
}