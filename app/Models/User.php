<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
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
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return bool
     */
    public function isAdminOrOwner()
    {
        return $this->role == 'admin' || $this->role == 'owner' ? true : false;
    }

    /**
     * @param \App\Models\App $app
     * @return bool|mixed
     */
    public function isAppAdmin(App $app)
    {
        return $this->app_collaborations()->newPivotStatementForId($app->id)->first()->role ?? null == 'admin' ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function app_collaborations()
    {
        return $this->belongsToMany(App::class, 'app_collaborators')
            ->withPivot([
                'role',
            ])
            ->withTimestamps();
    }

    /**
     * @param \App\Models\App $app
     * @return bool
     */
    public function isAppCollaborator(App $app)
    {
        return (bool) $this->app_collaborations()->newPivotStatementForId($app->id)->first();
    }

    /**
     * @return bool
     */
    public function isOwner()
    {
        return $this->role == 'owner';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actions()
    {
        return $this->hasMany(LogEntry::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function app_setup_tokens()
    {
        return $this->hasMany(AppSetupToken::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function auth_requests()
    {
        return $this->hasMany(AuthRequest::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function log()
    {
        return $this->morphMany(LogEntry::class, 'loggable');
    }
}
