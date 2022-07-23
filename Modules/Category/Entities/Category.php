<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title','slug','parent_id'];

    protected static function newFactory()
    {
        return \Modules\Category\Database\factories\CategoryFactory::new();
    }

    public function getParentAttribute()
    {
        return  is_null($this->parent_id) ? 'دسته اصلی': $this->parentCategory->title;
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function path()
    {
        return route('categories.show', $this->id);
    }

}
