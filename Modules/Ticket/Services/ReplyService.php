<?php

namespace Modules\Ticket\Services;

use Illuminate\Http\UploadedFile;
use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Repositories\ReplyRepo;
use Modules\Ticket\Repositories\TicketRepo;
use Modules\Media\Services\MediaFileService;

class ReplyService
{
   public static function store(Ticket $ticket, $reply, $attachment)
    {
        $repo = new ReplyRepo();
        $ticketRepo = new TicketRepo();
        $media_id = null;
        if ($attachment && ( $attachment instanceof UploadedFile)){
            $media_id = MediaFileService::privateUpload($attachment)->id;
        }

        $reply = $repo->store($ticket->id, $reply, $media_id);
        if ($reply->user_id != $ticket->user_id){
            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_REPLIED);
        }else{
            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_OPEN);
        }
        return $reply;
    }
}
