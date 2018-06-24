<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Adverts\Attribute
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $type
 * @property int $required
 * @property mixed $variants
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereVariants($value)
 */
class Attribute extends Model
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';

    protected $table = 'attribute';

    protected $fillable = ['name', 'type', 'category_id', 'required', 'variants', 'sort' ];

    protected $casts = [
        'variants' => 'array',
    ];
    public static function typeList()
    {
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT => 'Float'
        ];
    }
    public function isString()
    {
        return $this->type === self::TYPE_STRING;
    }
    public function isInteger()
    {
        return $this->type === self::TYPE_INTEGER;
    }
    public function isFloat()
    {
        return $this->type === self::TYPE_FLOAT;
    }
    public function isSelect()
    {
        return \count($this->variants) > 0;
    }
    public static function new($name, $categoryId, $type, $required, $variants, $sort): self
    {
        return static::create([
            'name' => $name,
            'category_id' => $categoryId,
            'type' => $type,
            'required' => $required,
            'variants' => $variants,
            'sort' => $sort,
        ]);
    }
    public function edit($name = null, $categoryId = null, $type = null, $required = null, $variants = null, $sort = null)
    {
        if(!empty($name)){
            $this->name = $name;
        }
        if(!empty($categoryId)){
            $this->category_id = $categoryId;
        }
        if(!empty($type)){
            $this->type = $type;
        }
        if(!is_null($required)){
            $this->required = $required;
        }
        if(!is_null($variants)){
            $this->variants = $variants;
        }
        if(!is_null($sort)){
            $this->sort = $sort;
        }
    }
}
