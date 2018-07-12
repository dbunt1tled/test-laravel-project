<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 12.07.18
 * Time: 23:53
 */

namespace App\Services\NewsLetter;

class MailChimp implements NewsLetter
{
    private $client;
    private $listId;

    public function __construct(\DrewM\MailChimp\MailChimp $client, $listId)
    {
        $this->client = $client;
        $this->listId = $listId;
    }
    public function subscribe($email): void
    {
        $this->client->post('lists/' . $this->listId . '/members', [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
        if($error = $this->client->getLastError()) {
            throw new \RuntimeException($error);
        }
    }
    public function unsubscribe($email): void
    {
        $hash = $this->client->subscriberHash($email);
        $this->client->delete('lists/' . $this->listId . '/members/' . $hash);
        if($error = $this->client->getLastError()) {
            throw new \RuntimeException($error);
        }
    }
}