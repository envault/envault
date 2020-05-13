<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\Apps\CollaboratorAddedEvent::class => [
            \App\Listeners\Apps\LogCollaboratorAdditionListener::class,
        ],
        \App\Events\Apps\CollaboratorRemovedEvent::class => [
            \App\Listeners\Apps\LogCollaboratorRemovalListener::class,
        ],
        \App\Events\Apps\CollaboratorRoleUpdatedEvent::class => [
            \App\Listeners\Apps\LogCollaboratorRoleUpdateListener::class,
        ],
        \App\Events\Apps\CreatedEvent::class => [
            \App\Listeners\Apps\LogCreationListener::class,
        ],
        \App\Events\Apps\DeletedEvent::class => [
            \App\Listeners\Apps\LogDeletionListener::class,
        ],
        \App\Events\Apps\NameUpdatedEvent::class => [
            \App\Listeners\Apps\LogNameUpdateListener::class,
        ],
        \App\Events\Apps\NotificationSettingsUpdatedEvent::class => [
            \App\Listeners\Apps\LogNotificationSettingsUpdateListener::class,
        ],
        \App\Events\Apps\NotificationsSetUpEvent::class => [
            \App\Listeners\Apps\LogNotificationsSetUpListener::class,
            \App\Listeners\Apps\NotifyConfirmingNotificationsSetupListener::class,
        ],
        \App\Events\Users\CreatedEvent::class => [
            \App\Listeners\Users\LogCreationListener::class,
        ],
        \App\Events\Users\DeletedEvent::class => [
            \App\Listeners\Users\LogDeletionListener::class,
        ],
        \App\Events\Users\EmailUpdatedEvent::class => [
            \App\Listeners\Users\LogEmailUpdateListener::class,
        ],
        \App\Events\Users\NameUpdatedEvent::class => [
            \App\Listeners\Users\LogNameUpdateListener::class,
        ],
        \App\Events\Users\RoleUpdatedEvent::class => [
            \App\Listeners\Users\LogRoleUpdateListener::class,
        ],
        \App\Events\Users\SignedInEvent::class => [
            \App\Listeners\Users\LogSignInListener::class,
        ],
        \App\Events\Variables\CreatedEvent::class => [
            \App\Listeners\Variables\LogCreationListener::class,
            \App\Listeners\Variables\NotifyOfVariableCreationListener::class,
        ],
        \App\Events\Variables\DeletedEvent::class => [
            \App\Listeners\Variables\LogDeletionListener::class,
        ],
        \App\Events\Variables\ImportedEvent::class => [
            \App\Listeners\Variables\LogImportListener::class,
            \App\Listeners\Variables\NotifyOfVariableImportListener::class,
        ],
        \App\Events\Variables\KeyUpdatedEvent::class => [
            \App\Listeners\Variables\LogKeyUpdateListener::class,
            \App\Listeners\Variables\NotifyOfVariableKeyUpdateListener::class,
        ],
        \App\Events\Variables\ValueUpdatedEvent::class => [
            \App\Listeners\Variables\LogValueUpdateListener::class,
            \App\Listeners\Variables\NotifyOfVariableValueUpdateListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }
}
