<?php
/**
 * Created by PhpStorm.
 * User: sid
 * Date: 06.06.18
 * Time: 22:38
 */

namespace App\UseCases\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;

class FavoriteService
{
    public function add($userId, $advertId)
    {
        $user = $this->getUser($userId);
        $advert = $this->getAdvert($advertId);

        $user->addToFavorites($advert->id);
    }

    public function remove($userId, $advertId)
    {
        $user = $this->getUser($userId);
        $advert = $this->getAdvert($advertId);

        $user->removeFromFavorites($advert->id);

    }

    /**
     * @param $userId
     *
     * @return User|null
     */
    private function getUser($userId)
    {
        return User::findOrFail($userId)->first();
    }

    /**
     * @param $advertId
     *
     * @return Advert|null
     */
    private function getAdvert($advertId)
    {
        return Advert::findOrFail($advertId)->first();
    }
}