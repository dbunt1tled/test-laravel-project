<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 03.06.18
 * Time: 15:16
 */

namespace App\Services\Sms;

interface SmsSender
{
 public function send($number,$text);
}