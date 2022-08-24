<?php

namespace Modules\Discount\Providers;

use Modules\Payment\Events\PaymentWasSuccessful;

use Modules\Discount\Listeners\UpdateUsedDiscountsForPayment;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            UpdateUsedDiscountsForPayment::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
