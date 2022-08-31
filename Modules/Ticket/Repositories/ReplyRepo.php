<?php

namespace Modules\Ticket\Repositories;

use Modules\Ticket\Entities\Reply;



class ReplyRepo
{
    public function store($ticketId, $body, $mediaId = null)
    {
        return Reply::query()->create([
            "user_id" => auth()->id(),
            "ticket_id" => $ticketId,
            "body" => $body,
            "media_id" => $mediaId
        ]);
    }
}
