<?php

namespace Modules\Comment\Listeners;

use Modules\Comment\Notifications\CommentApprovedNotification;
use Modules\Comment\Notifications\CommentSubmittedNotification;

class CommentApprovedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        // notify teacher
        if ($event->comment->user_id !== $event->comment->commentable->teacher->id)
            $event->comment->commentable->teacher->notify(new CommentSubmittedNotification($event->comment));

        $event->comment->user->notify(new CommentApprovedNotification($event->comment));
    }
}
