<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 12.07.18
 * Time: 23:31
 */

namespace App\Services\NewsLetter;

interface NewsLetter
{
    public function subscribe($email) : void;
    public function unsubscribe($email) : void;
}