<?php
namespace App\Entity\User;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\User\Network
 *
 * @property int $user_id
 * @property string $network
 * @property string $identity
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\Network whereIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\Network whereNetwork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\Network whereUserId($value)
 * @mixin \Eloquent
 */
class Network extends Model
{
    protected $table = 'user_networks';
    protected $fillable = ['network', 'identity'];
    public $timestamps = false;
}