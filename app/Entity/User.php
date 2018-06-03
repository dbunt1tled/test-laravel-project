<?php

namespace App\Entity;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class User
 *
 * @package App\Entity
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $status
 * @property boolean $phone_auth
 * @property string $role
 * @property string $verify_token
 * @property string $phone_verify_token
 * @property boolean $phone_verified
 * @property Carbon $phone_verify_token_expire
 * @property string $phone
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereLast_name($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User whereVerifyToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User wherePhone($value)
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
        'name', 'email', 'password', 'verify_token', 'status', 'role', 'last_name','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'phone_verify_token_expire' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'phone_auth' => 'boolean',
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
        $user = static::new($name,$email,null,null,null,$password);
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

    public static function new($name, $email, $last_name = null, $phone = null, $status = null,$password = null, $role = null,$verifyPhone = false): self
    {
        $verifyPhone = (!empty($phone) && $verifyPhone)?true:false;
        return static::create([
            'name' => $name,
            'email' => $email,
            'password' => !empty($password)?Hash::make($password):Hash::make(Str::random()),
            'status' => (!is_null($status) && (in_array($role,array_keys(User::getStatuses()))))?$status:self::STATUS_WAIT,
            'verify_token' => ($status === self::STATUS_ACTIVE)?'':Str::random(),
            'role' => (!is_null($role) && (in_array($role,array_keys(User::rolesList()))))?$role:self::ROLE_USER,
            'last_name' => $last_name,
            'phone' => $phone,
            'phone_verified' => $verifyPhone,
        ]);
    }
    public function edit($name = null, $last_name = null,$phone = null, $email = null, $status = null,$password = null, $role = null)
    {
        if(!empty($name)){
            $this->name = $name;
        }
        if(!empty($last_name)){
            $this->last_name = $last_name;
        }
        if(!empty($phone)){
            $this->phone = $phone;
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

    public function isPhoneVerified()
    {
        return $this->phone_verified;
    }

    public function requestPhoneVerification(Carbon $now)
    {
        if(empty($this->phone)){
            throw new \DomainException('Номер телефона отсутствует.');
        }
        if(!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now) ){
            throw new \DomainException('Проверочный код уже отправлен.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000,99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }
    public function verifyPhone($token, Carbon $now)
    {
        if($token !== $this->phone_verify_token){
            throw new \DomainException('Введен не правильный проверочный код');
        }
        if($this->phone_verify_token_expire->lt($now)){
            throw new \DomainException('Вышел срок действия проверочного кода.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->phone_auth = false;
        $this->saveOrFail();
    }
    public function enablePhoneAuth(): void
    {
        if (!empty($this->phone) && !$this->isPhoneVerified()) {
            throw new \DomainException('Phone number is empty.');
        }
        $this->phone_auth = true;
        $this->saveOrFail();
    }
    public function disablePhoneAuth(): void
    {
        $this->phone_auth = false;
        $this->saveOrFail();
    }
    public function isPhoneAuthEnabled(): bool
    {
        return (bool)$this->phone_auth;
    }
    public function hasFilledProfile(): bool
    {
        return !empty($this->name) && !empty($this->last_name) && $this->isPhoneVerified();
    }
}
