<?php

namespace Modules\Comment\Notifications;


use Illuminate\Bus\Queueable;
use Modules\Comment\Entities\Comment;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CommentRejectedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct(Comment  $comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        $channels[] = 'mail';
        $channels[] = 'database';

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }



    public function toArray($notifiable)
    {
        return [
            "message" => "دیدگاه شما رد شد.",
            "url" => $this->comment->commentable->path(),
        ];
    }
}
