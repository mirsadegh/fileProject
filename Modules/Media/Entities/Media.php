<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Services\MediaFileService;

class Media extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
       'files' => 'json'
    ];

    protected static function newFactory()
    {
        return \Modules\Media\Database\factories\MediaFactory::new();
    }

    protected static function booted()
    {
        static::deleting(function ($media){
            MediaFileService::delete($media);
        });

    }

    public function getThumbAttribute()
    {
        return MediaFileService::thumb($this);
    }
}
