<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property string $verify_token
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_WAIT = 0;
    public const STATUS_ACTIVE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verify_token', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getStatuses()
    {
        $statuses = [
            User::STATUS_ACTIVE => [
                'text' => 'Активный',
                'class' => 'success',
            ],
            User::STATUS_WAIT => [
                'text' => 'Ожидает подтверждения',
                'class' => 'primary',
            ],
        ];
        return $statuses;
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public static function register($name, $email, $password): self
    {
        $user = static::new($name,$email,null,$password);
        $user->save();
        return $user;
    }

    public static function new($name, $email, $status = null,$password = null): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => !empty($password)?Hash::make($password):Hash::make(Str::random()),
            'status' => (!is_null($status))?$status:self::STATUS_WAIT,
            'verify_token' => ($status === self::STATUS_ACTIVE)?'':Str::random(),
        ]);
    }
    public function edit($name = null, $email = null, $status = null,$password = null)
    {
        if(!empty($name)){
            $this->name = $name;
        }
        if(!empty($email)){
            $this->email = $email;
        }
        if(!is_null($status) && in_array($status,array_keys(self::getStatuses()))){
            $this->status = $status;
        }
        if(!empty($password)){
            $this->password = Hash::make($password);
        }
    }

    public function verify()
    {
        if (!$this->isWait()) {
            throw new \DomainException('Ваша почта уже подтверждена.');
        }
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'verify_token' => null,
        ]);
    }
}