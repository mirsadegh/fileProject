<?php

namespace Modules\User\Http\Services\Message;



use Modules\User\Http\Interfaces\MessageInterface;

class MessageService
{
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function send(){
        return $this->message->fire();
    }
}
