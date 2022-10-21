<?php

namespace Modules\Slider\Entities;

use Modules\Media\Entities\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Slider\Database\factories\SlideFactory::new();
    }
    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
