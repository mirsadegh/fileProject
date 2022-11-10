<?php

namespace Modules\Blog\Entities;

use Modules\User\Entities\User;
use Modules\Media\Entities\Media;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Comment\Traits\HasComments;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory,HasComments;

    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
          return $this->belongsTo(Media::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function convertTagsToArray()
    {
        return explode(',',$this->tags) ;
    }
}
