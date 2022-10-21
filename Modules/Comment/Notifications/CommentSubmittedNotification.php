<?php

namespace Modules\Comment\Notifications;

use Modules\Comment\Mail\CommentSubmittedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Kavenegar\LaravelNotification\KavenegarChannel;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CommentSubmittedNotification extends Notification
{
    use Queueable;

    public $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable): array
    {
        $channels = [
            "mail",
            "database"
        ];
    
        // if (!empty($notifiable->mobile)) $channels[] = KavenegarChannel::class;

        return $channels;
    }

    public function toMail($notifiable)
    {
        return (new CommentSubmittedMail($this->comment))->to($notifiable->email);
    }


    public function toSMS($notifiable)
    {
        return 'یک دیدگاه جدید برای دوره ی شما در وب آموز ارسال شده است. جهت مشاهده و ارسال پاسخ روی لینک زیر کلیک فرمایید.' . "\n" .  route("comments.index");
    }

    public function toArray($notifiable): array
    {
        return [
            "message" => "دیدگاه جدید برای دوره ی شما ثبت شده است.",
            "url" => route("comments.index"),
        ];
    }
}
