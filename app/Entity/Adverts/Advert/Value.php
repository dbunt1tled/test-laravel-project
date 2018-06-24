<?php

namespace App\Entity\Adverts\Advert;


use Illuminate\Database\Eloquent\Model;



/**
 * App\Entity\Adverts\Advert\Value
 *
 * @property int $advert_id
 * @property int $attribute_id
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Value whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Value whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Value whereValue($value)
 * @mixin \Eloquent
 */
class Value extends Model
{
    protected $table = 'advert_advert_values';
    public $timestamps = false;
    protected $fillable = ['attribute_id','value'];

}
