<?php

namespace Modules\Ticket\Entities;

use Modules\User\Entities\User;
use Modules\Media\Entities\Media;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "ticket_replies";

     protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\ReplyFactory::new();
    }



    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function attachmentLink()
    {
        if ($this->media_id)
            return URL::temporarySignedRoute('media.download', now()->addDay(), ['media' => $this->media_id]);
    }
}
