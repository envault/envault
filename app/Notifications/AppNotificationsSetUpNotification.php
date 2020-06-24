<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class AppNotificationsSetUpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        $configAppName = config('app.name');

        return (new SlackMessage())
            ->success()
            ->from(config('app.name'))
            ->to($channel)
            ->content('Slack notifications have been set up!')
            ->attachment(function ($attachment) use ($configAppName, $notifiable) {
                $attachment->title($notifiable->name, route('apps.show', [
                    'app' => $notifiable->id,
                ]))
                    ->content("Please set up your local environment to receive variable updates from {$configAppName}.");
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
