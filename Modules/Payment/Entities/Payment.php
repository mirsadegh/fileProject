<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;



    protected static function newFactory()
    {
        return \Modules\Payment\Database\factories\PaymentFactory::new();
    }
    protected $guarded = ['id'];
    const STATUS_PENDING = "pending";
    const STATUS_CANCELED = "canceled";
    const STATUS_SUCCESS = "success";
    const STATUS_FAIL = "fail";
    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_CANCELED,
        self::STATUS_SUCCESS,
        self::STATUS_FAIL,
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, "discount_payment");
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, "buyer_id");
    }

    public function seller()
    {
        return $this->belongsTo(User::class, "seller_id");
    }
}
