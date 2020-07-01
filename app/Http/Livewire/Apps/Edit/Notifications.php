<?php

namespace App\Http\Livewire\Apps\Edit;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Notifications extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var string
     */
    public $slackNotificationChannel = '';

    /**
     * @var string
     */
    public $slackNotificationWebhookUrl = '';

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update()
    {
        $this->authorize('update', $this->app);

        $this->validate([
            'slackNotificationChannel' => ['alpha_dash'],
            'slackNotificationWebhookUrl' => ['url'],
        ]);

        $oldChannel = $this->app->slack_notification_channel;
        $oldWebhookUrl = $this->app->slack_notification_webhook_url;

        $this->app->slack_notification_channel = $this->slackNotificationChannel;
        $this->app->slack_notification_webhook_url = $this->slackNotificationWebhookUrl;
        $this->app->save();

        if ($oldChannel != $this->app->slack_notification_channel || $oldWebhookUrl != $this->app->slack_notification_webhook_url) {
            if ($this->app->notificationsEnabled()) {
                $this->emit('app.notifications.set-up', $this->app->id);

                event(new \App\Events\Apps\NotificationsSetUpEvent($this->app));
            } else {
                $this->emit('app.notifications.updated', $this->app->id);

                event(new \App\Events\Apps\NotificationSettingsUpdatedEvent($this->app));
            }
        } else {
            // Configuration changes have not been made
            $this->emit('app.notifications.updated', $this->app->id);
        }

        $this->mount($this->app->refresh());
    }

    /**
     * @param \App\Models\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;
        $this->slackNotificationChannel = $app->slack_notification_channel;
        $this->slackNotificationWebhookUrl = $app->slack_notification_webhook_url;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.edit.notifications');
    }
}
