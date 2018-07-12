<?php

namespace App\Notifications\Advert;

use App\Entity\Adverts\Advert\Advert;
use App\Notifications\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class ModerationPassedNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $advert;

    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }

    public function via($notifiable)
    {
        return ['mail', SmsChannel::class];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
    ->subject('Модерация объявления успешно пройдена')
            ->greeting('Hello ')
                    ->line('Ваше объявление успешно отмодерировано.')
            ->action('Просмотреть объявление',route('adverts.show',$this->advert))
                    ->line('Спасибо что с нами!');
    }
    public function toSms()
    {
        return 'Ваше объявление успешно отмодерировано';
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
