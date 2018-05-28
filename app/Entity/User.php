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
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property string $role
 * @property string $verify_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereVerifyToken($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_WAIT = 0;
    public const STATUS_ACTIVE = 1;

    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'verify_token', 'status', 'role',
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

    public static function rolesList(): array
    {
        return [
            self::ROLE_USER => [
                'text' => 'Пользователь',
                'class' => 'default',
            ],
            self::ROLE_MODERATOR => [
                'text' => 'Модератор',
                'class' => 'primary',
            ],
            self::ROLE_ADMIN => [
                'text' => 'Администратор',
                'class' => 'danger',
            ],
        ];
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

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public static function new($name, $email, $status = null,$password = null, $role = null): self
    {
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => !empty($password)?Hash::make($password):Hash::make(Str::random()),
            'status' => (!is_null($status) && (in_array($role,array_keys(User::getStatuses()))))?$status:self::STATUS_WAIT,
            'verify_token' => ($status === self::STATUS_ACTIVE)?'':Str::random(),
            'role' => (!is_null($role) && (in_array($role,array_keys(User::rolesList()))))?$role:self::ROLE_USER,
        ]);
    }
    public function edit($name = null, $email = null, $status = null,$password = null, $role = null)
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
        if(!empty($role)){
            $this->role = $role;
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
    public function changeRole($role)
    {

        if(!in_array($role,array_keys(User::rolesList()),true)){
            throw new \InvalidArgumentException('Устанавливаемая роль не найдена.');
        }

        if ($this->role === $role) {
            throw new \DomainException('Данная роль уже присвоина пользователю.');
        }
        $this->update(['role' => $role]);
    }
}
