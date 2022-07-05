<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\Entities\Media;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED , self::CONFIRMATION_STATUS_PENDING,self::CONFIRMATION_STATUS_REJECTED];


    protected static function newFactory()
    {
        return \Modules\Course\Database\factories\CourseFactory::new();
    }

    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id');
    }
}
