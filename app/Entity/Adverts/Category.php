<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class Category
 *
 * @package App\Entity
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Kalnoy\Nestedset\Collection|Category[] $children
 * @property-read Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|Category d()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $_lft
 * @property int $_rgt
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereRgt($value)
 */
class Category extends Model
{
    use NodeTrait;
    protected $table = 'category';
    protected $fillable = ['name', 'slug', 'parent_id'];

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
    public function getPath(): string
    {
        return implode('/', array_merge($this->ancestors()->defaultOrder()->pluck('slug')->toArray(), [$this->slug]));
    }
    public function parentAttributes(): array
    {
        return $this->parent ? $this->parent->allAttributes() : [];
    }
    /**
     * @return Attribute[]
     */
    public function allAttributes(): array
    {
        return array_merge($this->parentAttributes(), $this->attributes()->orderBy('sort')->getModels());
    }
    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id', 'id');
    }
}
