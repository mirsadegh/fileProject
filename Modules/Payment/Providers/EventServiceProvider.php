<?php

namespace Modules\Payment\Providers;

use Modules\Payment\Events\PaymentWasSuccessful;
use Modules\Course\Listeners\RegisterUserInTheCourse;
use Modules\Payment\Listeners\AddSellersShareToHisAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            AddSellersShareToHisAccount::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
