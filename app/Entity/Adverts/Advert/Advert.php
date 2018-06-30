<?php

namespace App\Entity\Adverts\Advert;

use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Entity\Adverts\Advert\Advert
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int|null $region_id
 * @property string $title
 * @property int $price
 * @property string $address
 * @property string $content
 * @property string $status
 * @property string|null $reject_reason
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $published_at
 * @property \Carbon\Carbon|null $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert forUser(User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert forRegion(Region $region)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert forCategory(Category $category)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert favoredByUser(User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|Advert active()
 * @mixin \Eloquent
 * @property-read \App\Entity\Adverts\Category $category
 * @property-read \App\Entity\Region|null $region
 * @property-read \App\Entity\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Adverts\Advert\Value[] $values
 */
class Advert extends Model
{
    public const STATUS_DRAFT = 'Черновик';
    public const STATUS_MODERATION = 'Модерация';
    public const STATUS_ACTIVE = 'Активен';
    public const STATUS_CLOSED = 'Закрыт';

    protected $table = 'advert_adverts';
    public $timestamps = true;
    //protected $fillable = ['user_id', 'region_id', 'category_id', 'title', 'price', 'address', 'content', 'status', 'reject_reason', 'expires_at', 'published_at' ];
    protected $guarded = ['id'];
    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function statusesList()
    {
        $statuses = [
            self::STATUS_ACTIVE => [
                'text' => 'Активен',
                'class' => 'success',
            ],
            self::STATUS_CLOSED => [
                'text' => 'Ожидает подтверждения',
                'class' => 'dark',
            ],
            self::STATUS_MODERATION => [
                'text' => 'Ожидает подтверждения',
                'class' => 'warning',
            ],
            self::STATUS_DRAFT => [
                'text' => 'Ожидает подтверждения',
                'class' => 'info',
            ],
        ];
        return $statuses;
    }
    public function sendToModeration()
    {
        if (!$this->isDraft()) {
            throw new \DomainException('Объявление не в статусе: Черновик.');
        }
        if(!$this->photos()->count()) {
            throw new \DomainException('Загрузите фотографии.');
        }
        $this->update(['status' => self::STATUS_MODERATION]);
    }
    public function moderate(Carbon $date): void
    {
        if ($this->status !== self::STATUS_MODERATION) {
            throw new \DomainException('Объявление не было модерировано');
        }
        $this->update([
            'published_at' => $date,
            'expires_at' => $date->copy()->addDays(15),
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    public function reject($reason): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'reject_reason' => $reason,
        ]);
    }
    public function expire(): void
    {
        $this->update([
            'status' => self::STATUS_CLOSED,
        ]);
    }
    public function close(): void
    {
        $this->update([
            'status' => self::STATUS_CLOSED,
        ]);
    }
    public function getValue($id)
    {
        foreach ($this->values as $value) {
            if ($value->attribute_id === $id) {
                return $value->value;
            }
        }
        return null;
    }
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }
    public function isModeration()
    {
        return $this->status === self::STATUS_MODERATION;
    }
    public function isOnModeration(): bool
    {
        return $this->status === self::STATUS_MODERATION;
    }
    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
    public function isClosed()
    {
        return $this->status === self::STATUS_CLOSED;
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }
    public function values()
    {
        return $this->hasMany(Value::class,'advert_id','id');
    }
    public function photos()
    {
        return $this->hasMany(Photo::class,'advert_id','id');
    }
    public function scopeActive(Builder $query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }
    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
    public function scopeForCategory(Builder $query, Category $category)
    {
        return $query->whereIn('category_id', array_merge(
            [$category->id],
            $category->descendants()->pluck('id')->toArray()
        ));
    }
    public function scopeFavoredByUser(Builder $query, User $user)
    {
        return $query->whereHas('favorites', function (Builder $query) use($user) {
            $query->where('user_id', $user->id);
        });
    }
    public function scopeForRegion(Builder $query, Region $region)
    {
        $ids = [$region->id];
        $childrenIds = $ids;
        while ($childrenIds = Region::where(['parent_id' => $childrenIds])->pluck('id')->toArray()) {
            $ids = array_merge($ids, $childrenIds);
        }
        return $query->whereIn('region_id', $ids);
    }
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'advert_favorites', 'advert_id', 'user_id');
    }
}
