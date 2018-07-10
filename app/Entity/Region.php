<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 *
 * @package App\Entity
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property Region $parent
 * @property Region[] $children
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder $roots()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region roots()
 */
class Region extends Model
{
    protected $table = 'region';
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(static::class,'parent_id','id');
    }

    public function children()
    {
        return $this->hasMany(static::class,'parent_id','id');
    }

    public static function new($name, $slug=null, $parentId = null): self
    {
        if(empty($slug)){
            $slug = str_slug($name);
        }
        return static::create([
            'name' => $name,
            'slug' => $slug,
            'parent_id' => $parentId,
        ]);
    }
    public function edit($name = null, $slug = null, $parentId = null)
    {
        if(!empty($slug)){
            $this->slug = $slug;
        }else{
            if($this->name != $name){
                $this->slug = str_slug($name);
            }
        }
        if(!empty($name)){
            $this->name = $name;
        }

        if(!is_null($parentId)){
            $this->parent_id = $parentId;
        }
    }
    public function getAddress()
    {
        return ($this->parent ? $this->parent->getAddress(): '') . $this->name;
    }

    public function scopeRoots(Builder $query)
    {
        return $query->where('parent_id',null);
    }
    public function getPath(): string
    {
        return ($this->parent ? $this->parent->getPath() . '/' : '') . $this->slug;
    }
}
