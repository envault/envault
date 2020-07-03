<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class VariablesImportedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var int
     */
    public $count;

    /**
     * Create a new notification instance.
     *
     * @param int $count
     * @return void
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable)
    {
        $channel = $notifiable->slack_notification_channel ? "#{$notifiable->slack_notification_channel}" : '#general';

        $variableForm = Str::plural('variable', $this->count);
        $wasForm = $this->count > 1 ? 'were' : 'was';

        return (new SlackMessage())
            ->success()
            ->from(config('app.name'))
            ->to($channel)
            ->content("{$this->count} environment {$variableForm} {$wasForm} added!")
            ->attachment(function ($attachment) use ($notifiable) {
                $attachment->title($notifiable->name, route('apps.show', [
                    'app' => $notifiable->id,
                ]))
                    ->content('Please run `npx envault` to sync your environment!');
            });
    }
}
