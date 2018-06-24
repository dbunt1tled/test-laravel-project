<?php

namespace App\Entity\Adverts\Advert;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Adverts\Advert\Photo
 *
 * @property int $id
 * @property int $advert_id
 * @property string $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereId($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
    protected $table = 'advert_advert_photos';
    public $timestamps = false;
    protected $fillable = ['file'];

}
