<?php

namespace Modules\Ticket\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\TicketFactory::new();
    }

    const STATUS_OPEN = "open";
    const STATUS_CLOSE = "close";
    const STATUS_PENDING = "pending";
    const STATUS_REPLIED = "replied";

    static $statuses = [
        self::STATUS_OPEN,
        self::STATUS_CLOSE,
        self::STATUS_PENDING,
        self::STATUS_REPLIED
    ];

    protected $guarded = [];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function ticketable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
