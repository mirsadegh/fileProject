<?php

namespace Modules\Course\Providers;

use Modules\Payment\Events\PaymentWasSuccessful;
use Modules\Course\Listeners\RegisterUserInTheCourse;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentWasSuccessful::class => [
            RegisterUserInTheCourse::class
        ]
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
