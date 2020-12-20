<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class App extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return bool
     */
    public function notificationsEnabled()
    {
        return $this->slack_notification_channel && $this->slack_notification_webhook_url;
    }

    /**
     * @param \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForSlack(Notification $notification)
    {
        return $this->slack_notification_webhook_url;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'app_collaborators')
            ->withPivot([
                'role',
            ])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function log()
    {
        return $this->morphMany(LogEntry::class, 'loggable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setup_tokens()
    {
        return $this->hasMany(AppSetupToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variables()
    {
        return $this->hasMany(Variable::class);
    }
}
