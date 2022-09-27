<?php

namespace Modules\Comment\Events;


use Illuminate\Broadcasting\Channel;
use Modules\Comment\Entities\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentApprovedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
