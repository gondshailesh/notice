<?php

namespace App\Notifications;

use App\Models\Notice;
use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class NoticePosted extends Notification
{
    use Queueable;

    public int $noticeId;

    public function __construct(int $noticeId)
    {
        $this->noticeId = $noticeId;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $notice = Notice::find($this->noticeId);

        if (!$notice) {
            return TelegramMessage::create()
                ->to(config('services.telegram.chat_id'))
                ->content('⚠️ A notice was posted but could not be retrieved.');
        }

        $url = route('notices.show', $notice->id);

        $emoji = strtolower($notice->priority ?? '') === 'urgent' ? '🚨' : '📢';

        $title = str_replace(
            ['_', '*', '[', ']', '`'],
            ['\_', '\*', '\[', '\]', '\`'],
            $notice->title
        );

        $categoryLabel = Notice::CATEGORIES[$notice->category] ?? ucfirst($notice->category);

        return TelegramMessage::create()
            ->to(config('services.telegram.chat_id'))
            ->content(
                "{$emoji} *New Notice Posted*\n\n" .
                "*Title:* {$title}\n" .
                "*Category:* {$categoryLabel}\n" .
                "*Priority:* " . ucfirst($notice->priority) . "\n\n" .
                "[📖 Read Full Notice]({$url})"
            )
            ->options(['parse_mode' => 'Markdown']);
    }
}