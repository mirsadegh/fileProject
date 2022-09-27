<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;

use Modules\Comment\Events\CommentApprovedEvent;

use Modules\Comment\Events\CommentRejectedEvent;
use Modules\Comment\Events\CommentSubmittedEvent;
use Modules\Comment\Listeners\CommentApprovedListener;
use Modules\Comment\Listeners\CommentSubmittedListener;
use Cyaxaress\Comment\Listeners\CommentRejectedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentApprovedEvent::class => [
            CommentApprovedListener::class
        ],
        CommentRejectedEvent::class => [
            CommentRejectedListener::class
        ],
        CommentSubmittedEvent::class => [
            CommentSubmittedListener::class
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
